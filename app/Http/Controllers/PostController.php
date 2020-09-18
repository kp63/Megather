<?php

namespace App\Http\Controllers;

use App\Helpers\QueryTool;
use App\User;
use Google_Service_Sheets_ValueRange;
use Illuminate\Http\Request;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use \Closure;

class PostController extends Controller
{
    public static $pagination_articles = 15;

    public function index(Request $request)
    {
        $items = Post::latest()->paginate(self::$pagination_articles);
        $items_converted = Post::convert($items);

        return view('post.index', [
            'items' => $items,
            'items_converted' => $items_converted,
        ]);
    }

    public function search(Request $request)
    {
        $a = QueryTool::explodeAllQueries($request);
        if ($a !== false) { return redirect($a); } unset($a);

        $params = [];
        $items = Post::latest();

        if (
            $request->query('tags') !== null &&
            is_string($request->query('tags')) &&
            trim($request->query('tags')) !== ''
        ) {
            $tags = (function ($tags) {
                $output = [];
                $tags = explode(' ', $tags);
                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    if (preg_match('/(#?(([0-9A-Za-zＡ-Ｚａ-ｚ０-９ー～_]|\p{Hiragana}|\p{Katakana}|\p{Han}|\p{Hangul})+))/u', $tag)) {
                        $output[] = ltrim($tag, '#');
                    }
                }
                return $output;
            })($request->query('tags'));

            if ($tags !== []) {
                foreach ($tags as $i => $tag) {
                    $tag_encoded = json_encode($tag);
                    $tag_encoded = str_replace('\\', '\\\\', $tag_encoded);
                    if ($i === 0) {
                        $items = $items->  whereRaw('json_contains(details, \'[' . $tag_encoded . ']\', \'$.included_tags\')');
                    } else {
                        $items = $items->orWhereRaw('json_contains(details, \'[' . $tag_encoded . ']\', \'$.included_tags\')');
                    }
                }
            }
        }

        if ($request->query('games') !== null && trim($request->query('games')) !== '') {
            $games = [];

            foreach (explode('.', $request->query('games')) as $i => $game) {
                $game = trim($game);
                if ($game !== '' && Config::get('tags.games.' . $game)) {
                    $games[] = $game;
                }
            }
            if ($games !== []) {
                    $params['games'] = implode('.', $games);
            }
            if ($games !== Config::get('tags.games')) {
                $items->whereIn('details->game', $games);
            }
        }
        if ($request->query('types') !== null && trim($request->query('types')) !== '') {
            $types = [];
            foreach (explode('.', $request->query('types')) as $i => $type) {
                $type = trim($type);
                if ($type !== '' && Config::get('tags.types.' . $type)) {
                    $types[] = $type;
                }
            }
            if ($types !== []) {
                $params['types'] = implode('.', $types);
            }
            if ($types !== Config::get('tags.types')) {
                $items->whereIn('details->type', $types);
            }
        }
        $items = $items->latest();
        $items = $items->paginate(self::$pagination_articles);
        $items_converted = Post::convert($items);

        return view('post.search', [
            'items' => $items,
            'items_converted' => $items_converted,
            'params' => $params,
            'display_list' => $params !== [],
            'games' => $games ?? [],
            'types' => $types ?? [],
        ]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => [
                'required',
                'min:5',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if (mb_substr_count($value, "\n") >= 15) { // x行目までの制限
                        $fail('改行が多すぎます。');
                    }
                }
            ],
            'game' => [
                'required',
                function ($attribute, $value, Closure $fail) {
                    if (!isset($value) || $value === '_unselected') {
                        $fail('ゲームが選択されていません。');
                    }
                    if (!isset(Config::get('tags.games')[$value])) {
                        $fail('不正なゲーム名が指定されました。');
                    }
                }
            ],
            'type' => [
                'required',
                function ($attribute, $value, Closure $fail) {
                    if (!isset($value) || $value === '_unselected') {
                        $fail('タイプが選択されていません。');
                    }
                    if (!isset(Config::get('tags.types')[$value])) {
                        $fail('不正なタイプ名が指定されました。');
                    }
                }
            ]
        ]);

        if (Post::store($data)) {
            return redirect('/');
        }

        return view('post.create');
    }

//    public function show($id)
//    {
//        //
//    }

    public function destroy(Request $request)
    {
        if ($request->post('target') !== null) {
            if ($target = intval($request->post('target'))) {
                $post = Post::find($target);
                if ($post !== null) {
                    $user_id = Auth::id();
                    if ($post->user_id === $user_id) {
                        if ($post->delete()) {
                            $id = bin2hex(random_bytes(8));
                            $filename = 'deleted_post/' . $id . '.json';
                            $data = [
                                'reason' => 'Self-delete',
                                'deleted_post' => $post->toArray(),
                            ];
                            $data = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
                            if (Storage::disk('local')->put($filename, $data)) {
                                return response('success')->header('Content-Type', 'text/plain');
                            }
                        }
                    }
                }
            }
        }
        return response('failed')->header('Content-Type', 'text/plain');
    }

    public function report(Request $request)
    {
        if ($request->input('target') !== null) {
            if ($target = intval($request->input('target'))) {
                $post = Post::find($target);
                if ($post !== null) {
                    try {

                        $sheets = \App\GoogleSheets::i();

                        $sheet_id = '1byJLdmvOgDjT1xCTt64mRkS7QIdaxmLkpCQ1eqcUKzI';
                        $values = new Google_Service_Sheets_ValueRange();
                        $values->setValues(
                            [
                                'values' => [
                                    'REPORT_POST',
                                    Auth::id() ?? '-',
                                    Auth::user()->username ?? '未ログイン',
                                    '',
                                    $request->ip() ?? '',
                                    $post->id ?? '-',
                                    $post->user_id ?? '-',
                                    User::find($post->user_id) ?? '削除済みユーザー',
                                    $post->content ?? '',
                                ],
                            ]
                        );
                        $params = ['valueInputOption' => 'USER_ENTERED'];

                        $sheets->spreadsheets_values->append(
                            $sheet_id,
                            'A1',
                            $values,
                            $params
                        );
                        return response('success')->header('Content-Type', 'text/plain');
                    } catch (\Exception $e) {
                        return response('failed')->header('Content-Type', 'text/plain');
                    }
                }
            }
        }
        return response('failed')->header('Content-Type', 'text/plain');
    }
}

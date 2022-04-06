<?php

namespace App\Http\Controllers;

use App\Helpers\QueryTool;
use App\Helpers\Util;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Closure;
use Google_Service_Sheets_ValueRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public static int $pagination_articles = 15;

    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'destroy']);
    }

    public function index(Request $request)
    {
        $items = Post::latest()->paginate(self::$pagination_articles);

        return view('post.index', [
            'items' => $items,
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
                function ($attribute, $value, Closure $fail) {
                    if (mb_substr_count($value, "\n") >= 15) {
                        $fail('改行が多すぎます。');
                    }
                }
            ],
            'game' => [ 'required', Rule::in(array_keys(Post::getAllGames())) ],
            'type' => [ 'required', Rule::in(array_keys(Post::getAllTypes())) ],
        ]);

        $tags = collect([]);
        preg_match_all('/#(([0-9A-Za-zＡ-Ｚａ-ｚ０-９ー～_]|\p{Hiragana}|\p{Katakana}|\p{Han}|\p{Hangul})+)/u', $data['content'], $matches);
        foreach ($matches[1] as $tag) {
            $record = Tag::firstOrCreate(['name' => Tag::tag_normalize($tag)]);
            $tags->push($record->id);
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $data['content'];
        $post->game = $data['game'];
        $post->type = $data['type'];

        if ($post->save()) {
            $post->tags()->syncWithoutDetaching($tags);
            return redirect('/');
        }

        return view('post.create');
    }

    public function destroy(Request $request)
    {
        if (!$request->input('target'))
            return response('failed')->header('Content-Type', 'text/plain');

        $user = $request->user();
        $post = Post::find($request->input('target'));
        if ($post && $post->user_id !== $user->id)
            return response('failed')->header('Content-Type', 'text/plain');

        if ($post->delete())
            return response('success')->header('Content-Type', 'text/plain');

        return response('failed')->header('Content-Type', 'text/plain');
    }

    public function search(Request $request)
    {
        $a = QueryTool::explodeAllQueries($request);
        if ($a !== false)
            return redirect($a);

        $params = [];

        $items = Post::latest();

        if ($request->query('tags')) {
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
                $tag_ids = [];
                foreach ($tags as $i => $tag) {
                    $tag = Tag::where('name', Tag::tag_normalize($tag))->first();
                    if ($tag !== null) {
                        $tag_ids[] = $tag->id;
                    }
                }

                $tmp = DB::table('post_tag')->whereIn('tag_id', $tag_ids)->get();

                $post_ids = [];
                foreach ($tmp as $t) {
                    $post_ids[] = $t->post_id;
                }

                $items = Post::whereIn('id', $post_ids)->latest();
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
                $items->whereIn('game', $games);
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
                $items->whereIn('type', $types);
            }
        }

        if (isset($items)) {
            $items = $items->paginate(self::$pagination_articles);
            return view('post.search', [
                'items' => $items,
                'params' => $params,
                'display_list' => $params !== [],
                'games' => $games ?? [],
                'types' => $types ?? [],
            ]);
        }
    }

    public function report(Request $request)
    {
        if ($request->input('target') !== null) {
            if ($target = intval($request->input('target'))) {
                $post = Post::find($target);
                if ($post !== null) {
                    try {

                        $sheets = \App\Helpers\GoogleSheets::i();

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

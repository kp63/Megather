<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use \Closure;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $items = Post::getAll()->paginate(2);
        $items_converted = Post::convert($items);

        return view('post.index', [
            'items' => $items,
            'items_converted' => $items_converted,
        ]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
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

        $result = Post::create([
            'details' => [
                'game' => $request->input('game'),
                'type' => $request->input('type'),
            ],
            'content' => $request->input('content'),
        ]);

        if ($result) {
            return redirect('/');
        }

        return view('post.create');
    }

//    public function show($id)
//    {
//        // 'p' . substr(bin2hex(random_bytes(8)), 1)
//    }

//    public function destroy($id)
//    {
//        //
//    }
}

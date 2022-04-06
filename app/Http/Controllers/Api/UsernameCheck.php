<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsernameCheck extends Controller
{
    /**
     * 要求されたユーザー名が使用できるかどうか確認します
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $q = (string) $request->get('q');
        $res = 'ok';
        if (!User::checkNameFormat($q))
            $res = 'invalid';
        elseif (!User::checkNameUnique($q))
            $res = 'taken';

        return response($res)
            ->header('Content-Type', 'text/plain');
    }
}

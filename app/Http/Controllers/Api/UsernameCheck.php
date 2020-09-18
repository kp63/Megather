<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\UsernameValidation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsernameCheck extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'q' => [
                    'required',
                    new UsernameValidation
                ]
            ]
        );

        if ($validator->fails()) {
            $res = 'invalid';
        } else {
            $query = $validator->validate()['q'];
            if (DB::table('users')->where('username', $query)->first() !== null) {
                $res = 'used';
            } else {
                $res = 'ok';
            }
        }

        return response($res, 200)
            ->header('Content-Type', 'text/plain');
    }
}

<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @todo 管理パネルを作る。
 */
class ManagementPanelController extends Controller
{
    protected static function check()
    {
        if (Auth::check() === true && Auth::user()->role === 'admin') {
            return true;
        }
        return false;
    }

    public function index()
    {
        if (!static::check()) {
            return view('errors.404');
        }

        return view('managementPanel/index');
    }
}

@extends('layouts.app')

@section('content')
    <div class="content-box">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <p class="text-18px">本当にログアウトしますか？</p>
            <button type="submit" class="btn btn-danger">ログアウト</button>
        </form>
    </div>
@endsection

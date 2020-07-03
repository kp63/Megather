@extends('layouts.app')

@section('content')
    <div class="content-box">
        <h1>期限切れのページ</h1>
        <p>この問題は、もう一度@if (url()->previous() !== null)<a href="{{ url()->previous() }}">前のページ</a>@else前のページ@endifに戻り同じ操作をすることで直る場合があります。</p>
    </div>
@endsection

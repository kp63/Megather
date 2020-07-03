@extends('layouts.app')

@section('content')
    <div class="content-box">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <p>
                Sure?
                <button type="submit" style="display: inline-block; padding: 4px 8px; background-color: #e0e0e0; border-radius: 2px; cursor: pointer; ">Logout</button>.
            </p>
        </form>
    </div>
@endsection

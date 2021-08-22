@extends('layouts.app')
@include('posts.view_block')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="w-50">
            @yield('post') 
        </div>
    </div>
</div>

@endsection
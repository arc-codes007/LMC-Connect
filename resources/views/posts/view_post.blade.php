@extends('layouts.app')
@include('posts.view_block')
@section('content')

 <div>
     @yield('post') 
</div>

@endsection
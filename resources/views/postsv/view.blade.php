
@extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row justify-content-center">      
                <div class="card w-50">
                    <img src="{{ asset('images/posted_images/'.$username.'/'.$post->post_image) }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->description }}</p>
                        <a href="{{url('posts/edit/'.$post->random_id)}}">Edit post</a>
                    </div>
                </div>                                   
            </div>
        </div>
    @endsection
     



@extends('layouts.app')

@section('content')
<div class="container">
<div class="h1 text-center">Saved Posts</div>
<hr>

            <div class="row">
                @if(!empty($all_saved_posts))
                @foreach($all_saved_posts as $posts)
                <!-- @if(isset($posts) && !empty($posts)) -->
                <div class=" col-3 pb-4 m-auto">
                    <a href="{{ route('post.show',$posts->random_id) }}">
                        <img class="card-img" src="{{ asset('images/posted_images/'.$posts->username.'/'.$posts->post_image) }}" alt="Somethimg went Wrong!">
                    </a>
                </div>
                <!-- @endif -->
                @endforeach
                @endif
            </div>
        </div>
@endsection
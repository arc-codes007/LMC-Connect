@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="card-body text-center col-md-6">
            <div class="mx-2 my-2">
                <h4 class="card-text d-flex">
                    <i class="fas fa-user-tie fa-lg"></i>
                    <div class="mx-2">{{count($users)}} Users</div>
                </h4>
            </div>
        </div>
        <div class="card-body col-md-6">
            <div class="mx-2 my-2">
                <h4 class="card-text d-flex">
                    <i class="fas fa-image fa-lg"></i>
                    <div class="mx-2">{{count($posts)}} Posts</div>
                </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card-body text-center col-md-6">
            <div class="mx-2 my-2">
                <h4 class="card-text d-flex">
                    <i class="fas fa-file fa-lg"></i>
                    <div class="mx-2">{{count($resumes)}} Resumes Shared</div>
                </h4>
            </div>
        </div>
        <div class="card-body col-md-6">
            <div class="mx-2 my-2">
                <h4 class="card-text d-flex">
                    <i class="fas fa-bookmark fa-lg"></i>
                    <div class="mx-2">{{count($saved_posts)}} Saved Posts</div>
                </h4>
            </div>
        </div>
    </div>

    <div class="py-3 my-3 h3">Posts with most number of comments</div>
    <table class="py-3 my-3 table table-striped">
        <thead>
          <tr>
            <th scope="col">Post ID</th>
            <th scope="col">Post Title</th>
            <th scope="col">Post Description</th>
            <th scope="col">Posted By</th>  
          </tr>
        </thead>
        @foreach ($posts as $item)
        <tbody>
            <tr>
              <th scope="row">{{$item['id']}}</th>
              <td><a href="{{ route('post.show',$item->random_id) }}" class="text-dark">{{$item['title']}}</a></td>
              <td>{!!$item['description']!!}</td>
              <td>user name here</td>
            </tr>
          </tbody>   
        @endforeach

    </table>






</div>
@endsection
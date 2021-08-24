@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center">
        <div class="card-body text-center col-md-5 d-flex justify-content-center">
            <div class="mx-2 my-2">
                <h4 class="card-text d-flex">
                    <i class="fas fa-user-tie fa-lg"></i>
                    <div class="mx-2">{{$users_count}} Users</div>
                </h4>
            </div>
        </div>
        <div class="col-lg-5 text-center">
            <a href="{{route('admin_panel.open_all_user_list')}}" class="btn btn-primary">Open All Users List</a>
        </div>
    </div>
    <div class="row justify-content-between align-items-center">
        <div class="card-body text-center col-md-5 d-flex justify-content-center">
            <div class="mx-2 my-2">
                <h4 class="card-text d-flex">
                    <i class="fas fa-file fa-lg"></i>
                    <div class="mx-2">{{$resumes_count}} Resumes Shared</div>
                </h4>
            </div>
        </div>
        <div class="col-lg-5 text-center">
            <a href="{{route('admin_panel.open_deleted_user_list')}}" class="btn btn-primary">Restore Users</a>
        </div>

    </div>
    <div class="row justify-content-between align-items-center">
        <div class="card-body col-md-5 d-flex justify-content-center">
            <div class="mx-2 my-2">
                <h4 class="card-text d-flex">
                    <i class="fas fa-image fa-lg"></i>
                    <div class="mx-2">{{count($posts)}} Posts</div>
                </h4>
            </div>
        </div>
        <div class="col-lg-5 text-center">
            <a href="{{route('admin_panel.make_announcement_form')}}" class="btn btn-primary">Make Announcement</a>
        </div>
    </div>
    <div class="py-3 my-3 mt-4 h3 text-center">Posts with most number of comments</div>
    <table class="py-3 my-3 table table-striped">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Post Title</th>
            <th scope="col">Post Description</th>
            <th scope="col">Posted By</th>  
            <th scope="col">Comment Count</th>  
          </tr>
        </thead>
        @foreach ($posts as $key => $item)
        <tbody>
            <tr>
              <th scope="row">{{$key+1}}</th>
              <td><a href="{{ route('post.show',$item->random_id) }}" class="text-dark">{{$item->title}}</a></td>
              <td>{!!$item['description']!!}</td>
              <td><a href="{{ route('profile.view_user',$item->posted_by_username) }}" class="text-dark">{{$item->posted_by_username}}</a></td>
              <td>{{$item->comments_count}}</td>
            </tr>
          </tbody>   
        @endforeach

    </table>






</div>
@endsection
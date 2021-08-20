@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{route('storeeditpost',[$data->random_id])}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="hidden" name="random_id" value="{{$data->random_id}}">
        <div class="m-auto col-6-lg">
            <div class="form-group">
                <div class="h5">Title</div>
                <input type="text" name="title" id="title" value="{{(isset($data->title) && !empty($data->title))? $data->title : '' }}" class="form-control">
                @if ($errors->has('title'))
                <strong>{{ $errors->first('title') }}</strong>
                @endif
            </div>
            <div class="form-group">
                <div class="h5">Post Image</div>
                <img class="card-img" src="{{ asset('images/posted_images/'.$username.'/'.$data->post_image) }}" id="post_image" alt="Somethimg went Wrong!">
            </div>
            <div class="form-group">
                <div class="h5">Description</div>
                <input type="text" name="description" id="description" value="{{(isset($data->description) && !empty($data->description))? $data->description : '' }}" class="form-control">
                @if ($errors->has('description'))
                <strong>{{ $errors->first('description') }}</strong>
                @endif
            </div>

        </div>
        <div class="row pt-4">
            <button type="submit" class="btn btn-primary">Edit Post</button>
        </div>
    </form>

</div>



@endsection
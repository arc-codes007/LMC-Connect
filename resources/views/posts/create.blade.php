@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/posts" enctype="multipart/form-data" method="post">
        @csrf

        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Add New Post</h1>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Post Caption</label>

                    <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>

                    @if ($errors->has('title'))
                    <!-- <span class="invalid-feedback" role="alert"> -->
                    <strong>{{ $errors->first('title') }}</strong>
                    <!-- </span> -->
                    @endif
                </div>

                <div class="row pt-3">
                    <label for="post_image" class="col-md-4 col-form-label">Post Image</label>

                    <input type="file" class="form-control-file" id="post_image" name="post_image">

                    @if ($errors->has('post_image'))
                    <strong>{{ $errors->first('post_image') }}</strong>
                    @endif
                </div>


                <div class="form-group row pt-3">
                    <label for="description" class="col-md-4 col-form-label">Post Description</label>

                    <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ old('description') }}" autocomplete="description" autofocus>

                    @if ($errors->has('description'))

                    <strong>{{ $errors->first('description') }}</strong>

                    @endif
                </div>

                <div class="row pt-4">
                    <button class="btn btn-primary">Add New Post</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
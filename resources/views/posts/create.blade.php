@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('storepost')}}" enctype="multipart/form-data" method="post">
        @csrf

        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Add New Post</h1>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Post Title</label>

                    <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>

                    @if ($errors->has('title'))
                    <!-- <span class="invalid-feedback" role="alert"> -->
                    <strong>{{ $errors->first('title') }}</strong>
                    <!-- </span> -->
                    @endif
                </div>


                <div class="form-group col-md-3">
                    <div id="upload-demo" class="edit_posts_image" style="display: none;"></div>
                    <div id="preview-crop-image" class="img_container">
                        <a id='edit_posts_image' class="text-dark button w-100 h-100 text-center"><i class="fas fa-3x fa-camera"></i></a>
                    </div>
                    <div class="edit_posts_image" style="display: none;">
                        <div class="input-group mt-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="post_image" id="post_image" aria-describedby="inputGroupFileimage">
                                <input type="hidden" name="post_pic" id="post_pic" value="">
                                <label class="custom-file-label" for="post_image">Choose file</label>
                            </div>
                            <!-- <div class="input-group-append">
                                <button class="btn btn-outline-success" type="button"><i class="fas fa-save"></i></button>
                            </div> -->

                            @if ($errors->has('post_image'))
                            <strong>{{ $errors->first('post_image') }}</strong>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- <div class="row pt-3">
                    <label for="post_image" class="col-md-4 col-form-label">Post Image</label>

                    <input type="file" class="form-control-file" id="post_image" name="post_image">


                </div> -->


                <div class="form-group row pt-3">
                    <label for="description" class="col-md-4 col-form-label">Post Description</label>

                    <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ old('description') }}" autocomplete="description" autofocus>

                    @if ($errors->has('description'))

                    <strong>{{ $errors->first('description') }}</strong>

                    @endif
                </div>

                <div class="row pt-4">
                    <button type="submit" class="btn btn-primary" id="btn-upload-posts">Add New Post</button>
                </div>

            </div>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {

        $('#edit_posts_image').click(function(e) {
            e.preventDefault();
            $('.edit_posts_image').show();
            $('#preview-crop-image').hide();

        });

        var resize = $('#upload-demo').croppie({
            enableExif: true,
            enableOrientation: true,
            viewport: { // Default { width: 100, height: 100, type: 'square' } 
                width: 255,
                height: 255,
                type: 'square' //square
            },
            boundary: {
                width: 255,
                height: 255
            }
        });


        $('#post_image').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                resize.croppie('bind', {
                    url: e.target.result
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#btn-upload-posts').on('click', function(ev) {
            resize.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(img) {
                $('#post_pic').val(img);
                $("#preview-crop-image").html('<img src="' + img + '" />');
                $('#preview-crop-image').show();
                $('.edit_posts_image').hide();
            });
        });

    });
</script>

@endsection
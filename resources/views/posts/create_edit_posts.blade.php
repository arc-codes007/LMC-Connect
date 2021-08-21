@extends('layouts.app')

@section('content')

<div class="container">

    {{-- @if(isset($data->random_id) &&!empty($data->random_id)) --}}
    
        <form action="{{ (isset($data) && isset($data->random_id) && !empty($data->random_id)) ? route('storeeditpost',[$data->random_id]) : route('storepost')}}" enctype="multipart/form-data" method="post">
            @csrf
            @if (isset($data) && isset($data->random_id))
                <input type="hidden" name="random_id" value="{{$data->random_id}}">                
            @endif
            <div class="row">

                <div class="col-8 offset-2">

                    @if(isset($data) && isset($data->random_id))    
                        <div class="row">
                          <h2>Edit Post</h2>
                        </div>
                        @else 
                            <div class="row">
                             <h2>Create post</h2>    
                            </div>
                        

                     @endif
                  



                        {{-- // @if(isset($data->random_id) &&!empty($data->random_id)) --}}
                        
                            <div class="form-group row">
                             <div class="h5">Post Title</div>
                             <input type="text" name="title" id="title" value="{{(isset($data->title) && !empty($data->title))? $data->title : '' }}" class="form-control">
                              @if ($errors->has('title'))
                               <strong>{{ $errors->first('title') }}</strong>
                              @endif
                            </div>
                        


                            @if(isset($data) && isset($username))
                            <div class="form-group col-md-4">
                                <div class="h5">Post Image</div>
                                <img class="card-img" src="{{ asset('images/posted_images/'.$username.'/'.$data->post_image) }}" id="post_image" alt="Somethimg went Wrong!">
                            </div>
                           
                            @else
                            <div class="form-group col-md-3">
                                <div id="upload-demo" class="edit_posts_image" style="display: none;"></div>
                                <div id="preview-crop-image" class="img_container">
                                    <a id='edit_posts_image' class="text-dark button w-100 h-100 text-center"><i class="fas fa-3x fa-camera"></i></a>
                                </div>
                                <div class="edit_posts_image" style="display: none;">
                                    <div class="input-group mt-4">
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="post_image">Choose file</label>
                                            <input type="file" class="custom-file-input" name="post_image" id="post_image" aria-describedby="inputGroupFileimage">
                                            <input type="hidden" name="post_pic" id="post_pic" value="">
                                        </div>
            
            
                                        @if ($errors->has('post_image'))
                                        <strong>{{ $errors->first('post_image') }}</strong>
                                        @endif
                                    </div>
            
                                </div>
                            </div>
                                
                            @endif




                        <div class="form-group row pt-3">
                            <div class="h5">Description</div>
                            <input type="text" name="description" id="description" value="{{(isset($data->description) && !empty($data->description))? $data->description : '' }}" class="form-control">
                            @if ($errors->has('description'))
                            <strong>{{ $errors->first('description') }}</strong>
                            @endif
                        </div>

                        @if(isset($data) && isset($data->random_id))
                         <div class="row pt-4">
                            <button type="submit" id="edit_post_button" name="edit_post_button" class="btn btn-primary">Edit Post</button>
                         </div>


                         @else
                          <div class="row pt-4">
                             <button type="submit" class="btn btn-primary" name="add_post_button" id="btn-upload-posts">Add New Post</button>
                          </div>
    
                         @endif


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
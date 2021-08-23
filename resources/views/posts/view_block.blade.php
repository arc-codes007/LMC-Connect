@section('post')

<div class="card mb-4 bottom-shadow">
  <div class="card-header d-flex justify-content-between p-3 bg-white">
    <div>
      @if (isset($post_owner_details->profile_pic) && !empty($post_owner_details->profile_pic))
        <img src="{{asset('images/profile_pics/'.$post_owner_details->username.'/'.$post_owner_details->profile_pic)}}" class="avatar mx-1" alt="">
      @else
        <img src="{{asset('images/profile_pics/default-profile-pic.jpg')}}" class="avatar mx-1" alt="">
      @endif
        <a href="{{ route('profile.view_user', $post_owner_details->username) }}" class="text-dark h5 mb-0 mx-1"><strong>{{$post_owner_details->username}}</strong></a>
    </div>
    <div class="d-flex align-items-center">  
      @if($post_owner || $is_admin)
        <a href="{{route('editpost',$post->random_id)}}" class="text-dark mx-1"><i class="fas fa-lg fa-edit mt-1"></i></a>
      @endif               
      @if ($post_owner)
          <a href="javascript:void(0)" onclick="delete_post({{$post->id}})" class="text-danger mx-1"><i class="fas fa-lg fa-trash mt-1"></i></a>
      @endif
    </div>
  </div>
  <img src="{{ asset('images/posted_images/'.$post_owner_details->username.'/'.$post->post_image) }}" class="card-img-top">
  <div class="card-body">
    <h5 class="card-title">{{ $post->title }}</h5>
    <p class="card-text">{!! $post->description !!}</p>
          
  
        <div class="row pt-3 d-flex justify-content-around">
          <a href="javascript:void(0);" onclick="add_comment_form_toggle({{$post->id}})" onmouseover="tooltip(this)" title="Add Comment" class="text-dark"><i class="fas fa-lg fa-comment"></i></a>
          @if($post->show_send_resume_button == 1)
          <a href="javascript:void(0);" onclick="upload_resume_button({{$post->id}})" onmouseover="tooltip(this)" title="Send Resume" class="text-dark"><i class="fas fa-lg fa-paper-plane"></i></a>
          @endif
          
          <a href="javascript:void(0);" onclick="save_unsave_post(this,{{$post->id}})" onmouseover="tooltip(this)" id="{{$post->id}}_save_post" title="Save Post" class="text-dark" style = "{{($is_post_saved_for_user)? 'display : none':''}}"><i class="far fa-lg fa-bookmark"></i></a>
          <a href="javascript:void(0);" onclick="save_unsave_post(this,{{$post->id}})" onmouseover="tooltip(this)" id="{{$post->id}}_unsave_post" title="Unsave Post" class="text-dark" style = "{{($is_post_saved_for_user)? '':'display : none'}}"><i class="fas fa-lg fa-bookmark"></i></a>
          
          <a href="javascript:void(0);" onclick="share_post_modal()" onmouseover="tooltip(this)" title="Share Post" class="text-dark"><i class="fas fa-lg fa-share-alt"></i></a>
        </div>
      </div>
      <!-- Send Resume-->

          <div class="mx-3 my-1" id="{{$post->id}}_resume_form_toggle" style="display: none;">
            @if($post_owner && isset($resume) && !empty($resume))
              @foreach ($resume as $resume_value)
                <div class="mb-2"><a href="{{route('profile.view_user',$resume_value->username)}}" class="text-dark"><strong>{{$resume_value->username}}</strong></a></div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" disabled value="{{$resume_value->resume}}">
                  <div class="input-group-append">
                    <a href="{{route('downloadresume',$resume_value->resume)}}" target="_BLANK" class="input-group-text btn bg-primary text-light"><i class="fas fa-file-download"  onmouseover="tooltip(this)" title="Download Resume"></i></a>
                  </div>
                </div>
              @endforeach
            @elseif (isset($resume) && !empty($resume))
              <div class="input-group mb-3">
                <input type="text" class="form-control" disabled value="{{$resume->resume}}">
                <div class="input-group-append">
                  <a href="{{route('downloadresume',$resume->resume)}}" target="_BLANK" class="input-group-text btn bg-primary text-light"><i class="fas fa-file-download"  onmouseover="tooltip(this)" title="Download Resume"></i></a>
                </div>
              </div>
            @else
              <form action="" method="POST" id="{{$post->id}}_upload_resume_form" files="true" enctype="multipart/form-data" onsubmit="event.preventDefault(); upload_resume({{$post->id}})">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="{{$post->id}}_resume_file" name="resume">
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <label class="custom-file-label" for="resume">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit"><i class="fas fa-save"></i></button>
                  </div>
                </div>
                <div>
                  <small class="text-muted mx-2 mt-1">
                    Please upload the resume file in .pdf form only with max upto 10mb.
                  </small>
                </div>
                <div class="text-danger mx-2 mt-1" id="{{$post->id}}_upload_resume_form_error"></div>
              </form>  
            @endif            
          </div>
    



            <!-- Add Comment -->
        <div class="card-body" id="{{$post->id}}_add_comment" style="display:none">
          <form action="" method="post" id="{{$post->id}}_add_comment_form" onsubmit="event.preventDefault(); add_comment({{$post->id}})">
              <textarea name="comment" class="form-control" placeholder="Add New Comment"></textarea>
              <input type="hidden" name="random_id" value="{{$post->random_id}}">
              <input type="hidden" name="post_id" value="{{$post->id}}">
              <input type="submit" class="btn btn-dark mt-2" />
          </form>
      
          
        {{-- showing comments        --}}

          <button class="btn btn-primary my-4" type="button" id="{{$post->id}}_view_comments_btn" onclick="view_comments({{$post->id}})">View Comments</button>
          <button class="btn btn-primary my-4" type="button" id="{{$post->id}}_hide_comments_btn" onclick="hide_comments({{$post->id}})" style="display: none;">Hide Comments</button>
          <div class="collapse my-4" id="{{$post->id}}_comment_accordion">

          </div>      
      </div>


<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> --}}
  
  <!-- Modal -->
  <div class="modal fade" id="share_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="input-group">
           <input type="text" id="{{$post->id}}_share_link" value="{{ route('post.show',$post->random_id) }} " class="form-control" disabled>
            <div class="input-group-append">
              <span class="input-group-text btn btn-outline-info" onclick="copy_to_clipboard('{{$post->id}}   _share_link')"><i class="far fa-lg fa-copy"></i></span>
            </div>
            <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
        
      </div>
    </div>
  </div>


</div>
@endsection



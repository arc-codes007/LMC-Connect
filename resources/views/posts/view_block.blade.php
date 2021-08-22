@section('post')

    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <a href="{{ url('profile/'.$username) }}"><strong>{{$username}}</strong></a>
          <p class="text-end">
          <a href="{{url('posts/edit/'.$post->random_id)}}" class="text-dark"><i class="fas fa-lg fa-edit"></i></a>               
      </div>
      <img src="{{ asset('images/posted_images/'.$username.'/'.$post->post_image) }}" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title">{{ $post->title }}</h5>
        <p class="card-text">{{ $post->description }}</p>
          
  
        <div class="row pt-3 d-flex justify-content-around">
          <a href="javascript:void(0);" onclick="add_comment_form_toggle({{$post->id}})" onmouseover="tooltip(this)" title="Add Comment" class="text-dark"><i class="fas fa-lg fa-comment"></i></a>
          <a href="javascript:void(0);" onclick="upload_resume()" onmouseover="tooltip(this)" title="Send Resume" class="text-dark"><i class="fas fa-lg fa-paper-plane"></i></a>
          <a href="javascript:void(0);" onmouseover="tooltip(this)" title="Save Post" class="text-dark"><i class="fas fa-lg fa-bookmark"></i></a>
          <a href="javascript:void(0);" onclick="share_post_modal()" onmouseover="tooltip(this)" title="Share Post" class="text-dark"><i class="fas fa-lg fa-share-alt"></i></a>
        </div>
      </div>
      <!-- Send Resume-->
      <form action="{{route('storeresume')}}" enctype="multipart/form-data" method="POST" files="true">
          @csrf

          <div class="upload_resume mx-3 my-3" style="display: none;">
              <div class="input-group">
                <input type="file" class="form-control" id="resume" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="resume" >
                <input type="hidden" id="post_id" name="post_id" value= {{$post->id}}>
                <button  class="btn btn-outline-secondary"type="submit" id="inputGroupFileAddon04">Upload</button>
              </div>
          </div>
      </form>
    



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
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" value="{{ url('posts/view/'.$post->random_id) }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>


</div>
@endsection



@section('post')

<div class="container">
    <div class="row justify-content-center">
      <div class="card w-50 p-3">
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
              <i class="fas fa-lg fa-comment" id="comment_button" data-toggle="tooltip" data-placement="top" title="Add Comment"></i>
              <i class="fas fa-lg fa-paper-plane" id="upload_resume" data-toggle="tooltip" data-placement="top" title="Send Resume"></i>
              <i class="fas fa-lg fa-bookmark" data-toggle="tooltip" data-placement="top" title="Save Post"></i>
              <i class="fas fa-lg fa-share-alt" data-toggle="tooltip" data-placement="top" title="Share Post"></i>
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
            @error('resume')
                <div class="m-2 alert alert-danger">{{ $message }}</div>
            @enderror
        </form>
    



            <!-- Add Comment -->
              <div class="card-body" id="add_comment" style="display:none">
                  <form method="post" action="/posts/comments">
                      @csrf
                      <textarea name="comment" id="comment" class="form-control" placeholder="Add New Comment"></textarea>
                      <input type="hidden" id="random_id" name="random_id" value="{{$post->random_id}}">
                      <input type="hidden" name="post_id" id="post_id" value="{{$post->id}}">
                      <input type="submit" class="btn btn-dark mt-2" />
                  </form>
              
          
                  {{-- showing comments        --}}

                 <button class="btn btn-primary my-4" type="button" id="view_comments">View Comments</button>
                 <button class="btn btn-primary my-4" type="button" id="hide_comments" style="display: none;">Hide Comments</button>
                    <div class="collapse my-4" id="comment_accordion">

         </div>      
      </div>
    </div>    


<script>
    $(document).ready(function(){
        $('#comment_button').click(function(){
            $('#add_comment').toggle();
        });




         $('#view_comments').click(function(){
            $('#comment_accordion').html('');
            $('#comment_accordion').collapse('show');
            $('#view_comments').hide();
            $('#view_more_comments').show();
            $.ajax({
                url: "{{ route('get_comments') }}",
                type: "GET",
                data: {
                    post_id: $('#post_id').val(),
                    count: 5,
                },
                success: function(res_data) {
                    for(let comment of res_data.comment_data)
                    {
                        $('#comment_accordion').append(`<div><strong>${comment.username} :</strong> ${comment.comment}</div><hr>`);                        
                    }

                    if(res_data.comment_count > 5)
                    {
                        $('#comment_accordion').append(`<a class="btn btn-primary" onclick="view_all_comments()">View More</a>`);                        
                    }       
                },
                error: function(res_data) {
                    $('#comment_accordion').html(`No Comments! Be first to comment.`);                        
                }
            });

            });


            $('#hide_comments').click(function(){
                $('#view_comments').show();
                $('#hide_comments').hide();
                $('#comment_accordion').collapse('hide');
            });

            $('#upload_resume').click(function(e) {
                e.preventDefault();
                $('.upload_resume').toggle();                

            });

    });
    

    

    function view_all_comments()
    {
            // console.log('hello');
            $('#view_more_comments').hide();
            $('#comment_accordion').html('');
            $('#comment_accordion').collapse('show');
            $('#view_comments').hide();
            $('#hide_comments').show();
            $.ajax({
                url: "{{ route('get_comments') }}",
                type: "GET",
                data: {
                    post_id: $('#post_id').val(),
                },
                success: function(res_data) {

                    for(let comment of res_data.comment_data)
                    {
                        $('#comment_accordion').append(`<div><strong>${comment.username} :</strong> ${comment.comment}</div><hr>`);                        
                    }

                            
                },
                error: function(res_data) {
                    $('#comment_accordion').html(`No Comments! Be first to comment.`);                        
                }
            });

            }
    
    </script>

@endsection



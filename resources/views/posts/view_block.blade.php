@section('post')

<div class="container">
    <div class="row justify-content-center">
      <div class="card w-50 p-3">
        <img src="{{ asset('images/posted_images/'.$username.'/'.$post->post_image) }}" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">{{ $post->title }}</h5>
          <p class="card-text">{{ $post->description }}</p>
          <a href="{{url('posts/edit/'.$post->random_id)}}">Edit post</a>
  
           <div class="row pt-3 d-flex justify-content-around">
              <i class="fas fa-lg fa-comment" id="comment_button" data-toggle="tooltip" data-placement="top" title="Add Comment"></i>
              <i class="fas fa-lg fa-paper-plane" data-toggle="tooltip" data-placement="top" title="Send Resume"></i>
              <i class="fas fa-lg fa-bookmark" data-toggle="tooltip" data-placement="top" title="Save Post"></i>
              <i class="fas fa-lg fa-share-alt" data-toggle="tooltip" data-placement="top" title="Share Post"></i>
           </div>
        </div>
            <!-- Add Comment -->
            <div class="m2-5">
              {{-- <h5 class="card-header">Add Comment</h5> --}}
              <div class="card-body" id="add_comment" style="display:none">
                  <form method="post" action="/posts/comments">
                      @csrf
                      <textarea name="comment" id="comment" class="form-control" placeholder="Add New Comment"></textarea>
                      <input type="hidden" id="random_id" name="random_id" value="{{$post->random_id}}">
                      <input type="hidden" name="post_id" id="post_id" value="{{$post->id}}">
                      <input type="submit" class="btn btn-dark mt-2" />
                  </form>
              </div>
          </div>     
          {{-- showing comments        --}}

          <button class="btn btn-primary mx-4" type="button" id="view_comments">View Comments</button>
          <button class="btn btn-primary mx-4" type="button" id="hide_comments" style="display: none;">Hide Comments</button>
        <div class="collapse show mx-4 py-2" id="comment_accordion">

        </div>
        <button type="button" class="btn btn-primary" id="view_more_comments" style="display:none">View More Comments</button>

          
      </div>
    </div>    
</div>

<script>
    $(document).ready(function(){
        $('#comment_button').click(function(){
            $('#add_comment').show();
        });




         $('#view_comments').click(function(){
            // console.log('hello');
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
                    console.log(res_data);
                    for(let comment of res_data)
                    {
                        console.log(comment);
                        $('#comment_accordion').append(`<div><strong>${comment.username} :</strong> ${comment.comment}</div><hr>`);                        
                    }

                    // $('#comment_accordion').append(`<a class="btn btn-primary" id="view_more_comments">View More</a>`);                        
                            
                },
                error: function(res_data) {
                    $('#comment_accordion').html(`No Comments! Be first to comment.`);                        
                }
            });

            });


         $('#view_more_comments').click(function(){
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
                    console.log(res_data);
                    for(let comment of res_data)
                    {
                        console.log(comment);
                        $('#comment_accordion').append(`<div><strong>${comment.username} :</strong> ${comment.comment}</div><hr>`);                        
                    }

                            
                },
                error: function(res_data) {
                    $('#comment_accordion').html(`No Comments! Be first to comment.`);                        
                }
            });

            });

            $('#hide_comments').click(function(){
                $('#comment_accordion').hide();
                $('#view_comments').show();
                $('#hide_comments').hide();
            });

    });
    
    // var acc = document.getElementsByClassName("accordion");
    // var i;

    //  for (i = 0; i < acc.length; i++) {
    //    acc[i].addEventListener("click", function() {
    //    console.log('hello');
    //    this.classList.toggle("active");
    //    var panel = this.nextElementSibling;
    //    if (panel.style.display === "block") {
    //     panel.style.display = "none";
    //   } else {
    //    panel.style.display = "block";
    //    }
    //   });
    // }    
    
    </script>

@endsection



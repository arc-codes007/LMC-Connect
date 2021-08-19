@section('post')

<div class="container">
    <div class="row justify-content-center">
      <div class="card w-50">
        <img src="{{ asset('images/posted_images/'.$username.'/'.$post->post_image) }}" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">{{ $post->title }}</h5>
          <p class="card-text">{{ $post->description }}</p>
          <a href="{{url('posts/edit/'.$post->random_id)}}">Edit post</a>
  
           <div class="row pt-3 d-flex justify-content-around">
              <i class="fas fa-lg fa-comment"></i>
              <i class="fas fa-lg fa-share"></i>
              <i class="fas fa-lg fa-bookmark"></i>
           </div>
        </div>
            <!-- Add Comment -->
            <div class="m2-5">
              {{-- <h5 class="card-header">Add Comment</h5> --}}
              <div class="card-body">
                  <form method="post" action="/posts/comments">
                      @csrf
                      <textarea name="comment" class="form-control" placeholder="Add New Comment"></textarea>
                      <input type="hidden" name="random_id" value="{{$post->random_id}}">
                      <input type="submit" class="btn btn-dark mt-2" />
                  </form>
              </div>
          </div>     
          {{-- showing comments        --}}


          {{-- <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">View Comments</button>
  
          <div class="collapse multi-collapse" id="multiCollapseExample1">
            <div class="card-body">{{$commentcount}} Comments</div>
            @foreach ($comment as $comments)
             <div class="card-body">{{$comments->comment}}</div>   
            @endforeach
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">View More Comments</button>
            <div class="collapse multi-collapse" id="multiCollapseExample2">
              all comments here
            </div>
          </div> --}}

          <button class="btn btn-primary" type="button" id="myButton">View console</button>
          
      </div>
    </div>    
</div>

@endsection


<script>
// $(document).ready(function(){
//      $('#view').click(function(e){
//         e.preventDefault();
//         console.log('hello');
//      });
// });



$(document).ready(function(){
    $("#myButton").click(function(){
      alert("HELLO WORLD!!");
    });
  });
</script>
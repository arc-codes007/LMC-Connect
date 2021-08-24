@extends('layouts.app')

@section('content')

<div class="overlay">
    <div class="overlayDoor"></div>
    <div class="overlayContent">
        <div class="loader">
            <div class="inner"></div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-3" id="profile_section">
            <div class="sticky-top">
                <div class="border rounded  py-3 px-2"> 
                    <div class="row justify-content-center my-4">
                        <img src="{{(isset($profile_details->profile_pic) && !empty($profile_details->profile_pic))? asset('images/profile_pics/'.$username.'/'.$profile_details->profile_pic) : asset('images/profile_pics/default-profile-pic.png')  }}" alt="Profile Picture" class="img-thumbnail w-75 rounded-circle">
                    </div>
                    <div class="row justify-content-center m-3 h1">
                        <a href="{{route('profile.view_user',$username)}}" class="text-dark">{{$name}}</a>
                    </div>
                    <div class="h4 mt-3">Bio</div>
                    <div>{{(isset($profile_details->bio) && !empty($profile_details->bio))? $profile_details->bio : 'N/A' }}</div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{route('user_saved_posts')}}" class="btn btn-primary">Saved Posts</a>
                        <a href="{{ route('createpost') }}" class="btn btn-success">Add New Post</a>
                    </div>
                </div>
            </div>
        </div>
        <div  class="col-lg-6" id="home_section">
            <div id="post_container">
                
            </div>
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status" id="posts_loading_spinner" style="display: none">
                  <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3" id="notification_section">
            <div class="sticky-top">
                <div class="h2">Notifications</div>
                <div class="border rounded py-3 px-2 fancy-scroll" style="max-height: 35vh; overflow-y : scroll"> 
                    <div class="mt-1" id="notification_container">
                        @if (isset($notifications) && !empty($notifications))
                        @foreach ($notifications as $notification)
                        @switch($notification['type'])
                            @case('social_access_request')
                                <div class="alert alert-primary" role="alert">
                                    <h4 class="alert-heading h5">{{$notification['details']['title']}}</h4>
                                    
                                    <hr>
                                    <div>User <a href="{{route('profile.view_user',$notification['details']['requested_by_username'])}}">{{$notification['details']['requested_by_username']}}</a> wants to access your social links!</div>
                                    <hr>
                                    <div class="mb-0">
                                        <a class="btn btn-sm btn-success accept_social_request" data-notification_id = {{$notification['id']}} data-requested_by = {{$notification['details']['requested_by']}} data-requested_to = {{$notification['user_id']}}>Accept</a>
                                        <a href="" class="btn btn-sm btn-secondary decline_social_request" data-notification_id = {{$notification['id']}} data-requested_by = {{$notification['details']['requested_by']}} data-requested_to = {{$notification['user_id']}}>Decline</a>
                                    </div>
                                </div>
                            @break
                            @case('comment')
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <div>User <a href="{{route('profile.view_user',$notification['details']['comment_by_username'])}}">{{$notification['details']['comment_by_username']}}</a> commented on your post - <a href="{{route('post.show',$notification['details']['post_random_id'])}}">{{$notification['details']['post_title']}}</a>
                                        <button type="button" onclick="delete_notification({{$notification['id']}})" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @break
                            @case('post_deleted_by_admin')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Your post with title - {{$notification['details']['post_title']}} has been deleted by Adminstration</a>
                                        <button type="button" onclick="delete_notification({{$notification['id']}})" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                
                            @break

                            @case('resume_recieved')
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <div>User <a href="{{route('profile.view_user',$notification['details']['resume_sent_by_username'])}}">{{$notification['details']['resume_sent_by_username']}}</a> have sent resume on your post - <a href="{{route('post.show',$notification['details']['post_random_id'])}}">{{$notification['details']['post_title']}}</a>
                                    <button type="button" onclick="delete_notification({{$notification['id']}})" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            @break
                        
                            @default
                                
                        @endswitch
                        @endforeach
                        @else
                            <div>No new notifications!</div>
                        @endif
                    </div>
                </div>
                <div class="h2 mt-4">Announcements</div>
                <div class="border rounded py-3 px-2 fancy-scroll" style="max-height: 35vh; overflow-y : scroll"> 
                    <div class="mt-1">
                        @if (isset($announcements) && !empty($announcements))
                        @foreach ($announcements as $announcement)
                            <a href="{{route('home.view_announcement',$announcement->random_id)}}">
                                <div class="alert alert-dark" role="alert">
                                    {{$announcement->subject}}
                                </div>
                            </a>
                        @endforeach
                        @else
                            <div>No new announcements!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer fixed-bottom bg-dark d-flex justify-content-between d-lg-none" id="small_device_toggle_control">
    <div class="text-center btn btn-dark w-100" id="small_device_button_profile"><i class="fas fa-lg fa-user"></i></div>
    <div class="text-center btn btn-dark w-100" id="small_device_button_home"><i class="fas fa-lg fa-home"></i></div>
    <div class="text-center btn btn-dark w-100" id="small_device_button_notifications"><i class="fas fa-lg fa-bell"></i></div>
</div>
<script>

function delete_notification(notification_id)
{
    $.ajax({
            url: "{{route('delete_notification')}}",
            type: "POST",
            data:{
                notification_id:notification_id
            },
            success: function(res_data) {
                $('#notification_container').html('No new notifications!');
            },
            error: function(res_data) {
            }
        });

}

var page = 1;

function get_posts()
{
    $('#posts_loading_spinner').show();
    $.ajax({
        url: "{{ route('home.get_posts') }}",
        type: "GET",
        data: {
            page : page
        },
        success: function(res_data) {
            for(let post of res_data)
            {
                $('#post_container').append(post);
            }
            $('#posts_loading_spinner').hide();
            if(page == 1)
            {
                $('.overlay, body').addClass('loaded');
                    setTimeout(function() {
                        $('.overlay').css({'display':'none'})
                    }, 2000);
            }
            if(res_data.length == 0)
            {
                page = 'stop';
            }
        },
        error: function(res_data) {
            alertify.alert('Error', 'Something Went Wrong!');
        }
    });

}

function small_device_buttons_toggle()
{
    if($('#small_device_toggle_control').is(':visible'))
    {
        $('#small_device_button_home').click();
    }
    else
    {
        $('#profile_section').show();   
        $('#home_section').show();   
        $('#notification_section').show();   
    }

}

$(document).ready(function(){

    if($('#small_device_toggle_control').is(':visible'))
    {
        $('#home_section').show();   
        $('#profile_section').hide();   
        $('#notification_section').hide();   

        $('#small_device_button_home').addClass('active');
        $('#small_device_button_profile').removeClass('active');
        $('#small_device_button_notifications').removeClass('active');
    }    
    
    $( window ).resize(function() {
        small_device_buttons_toggle();
    });

    $('#small_device_button_profile').click(function()
    {
        $('#profile_section').show();   
        $('#home_section').hide();   
        $('#notification_section').hide();   

        $('#small_device_button_profile').addClass('active');
        $('#small_device_button_home').removeClass('active');
        $('#small_device_button_notifications').removeClass('active');

    });
    $('#small_device_button_home').click(function()
    {        
        $('#home_section').show();   
        $('#profile_section').hide();   
        $('#notification_section').hide();   

        $('#small_device_button_home').addClass('active');
        $('#small_device_button_profile').removeClass('active');
        $('#small_device_button_notifications').removeClass('active');

    });
    $('#small_device_button_notifications').click(function()
    {
        $('#notification_section').show();   
        $('#profile_section').hide();   
        $('#home_section').hide();   

        $('#small_device_button_notifications').addClass('active');
        $('#small_device_button_profile').removeClass('active');
        $('#small_device_button_home').removeClass('active');

    });

    get_posts();

    $(window).scroll(function(){
        var height = $(window).scrollTop();
        if(height > 95)
        {
            $('.sticky-top').css('padding-top','5rem');
        }
        else
        {
            $('.sticky-top').css('padding-top','0rem');

        }
        if(page != 'stop')
        {
            if(height + $(window).height() >= $(document).height()) 
            {
                page++;
                get_posts();
            }
        }

    });
    


    $('.accept_social_request').click(function(){
        var requested_by = $(this).data('requested_by');
        var requested_to = $(this).data('requested_to');
        var notification_id = $(this).data('notification_id');

        var this_element = this;

        $.ajax({
                url: "{{ route('social_access.accept_decline_request') }}",
                type: "POST",
                data: {
                    requested_by: requested_by,
                    requested_to: requested_to,
                    notification_id: notification_id,
                    type : 'accept'
                },
                success: function(res_data) {
                    $(this_element).parent().parent().fadeOut();
                },
                error: function(res_data) {
                    alertify.alert('Error', 'Something Went Wrong!');
                }
            });
    });

    $('.decline_social_request').click(function(){
        var requested_by = $(this).data('requested_by');
        var requested_to = $(this).data('requested_to');
        var notification_id = $(this).data('notification_id');

        var this_element = this;

        $.ajax({
                url: "{{ route('social_access.accept_decline_request') }}",
                type: "POST",
                data: {
                    requested_by: requested_by,
                    requested_to: requested_to,
                    notification_id: notification_id,
                    type : 'decline'
                },
                success: function(res_data) {
                    $(this_element).parent().parent().fadeOut();
                },
                error: function(res_data) {
                    alertify.alert('Error', 'Something Went Wrong!');
                }
            });
    });

});

</script>
@endsection

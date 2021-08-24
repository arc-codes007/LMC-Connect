<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
    <meta name="auth-token" content="{{ Auth::user()->getAttributes()['api_token'] }}">
    @endauth

    <title>LMC Connect</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        @auth
        $.ajaxSetup({
        headers: {
        'Authorization': 'Bearer '+$('meta[name="auth-token"]').attr('content')
        },
    });
        @endauth
        
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>
<body class="fancy-scroll" style="overflow-y: scroll">
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/favicon.png') }}" class="avatar">
                    LMC Connect
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @auth
                        <div class="dropdown navbar-left">
                            <input class="form-control" id="search_bar" placeholder="Search..." type="text" autocomplete="off"  id="autocomplete_search" />
                              <div id="searchResults" class="bg-light w-100 py-2 dropdown-menu fancy-scroll" style="overflow-y: scroll; max-height:70vh;">
                                
                            </div>                                    
                         </div>    
                        @endauth
                        
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        {{ __('My Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        {{ __('Edit Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('show_update_account_form',Auth::user()->username) }}">
                                        {{ __('Account Settings') }}
                                    </a>
                                    @if (Auth::user()->is_admin)
                                        <a class="dropdown-item" href="{{ route('admin_dashboard') }}">
                                            {{ __('Admin Dashboard') }}
                                        </a>                                        
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4 mt-5">
            @yield('content')
        </main>
    </div>

<script src="{{ asset('js/main.js') }}"></script>

<script>


function add_comment(post_id)
{

    var form_data = $(`#${post_id}_add_comment_form`).serializeArray();
    var data = {};
    for(let value of form_data)
    {
        data[value['name']] = value['value'];
    }

    $.ajax({
        url: "{{route('storecomment')}}",
        type: "POST",
        data:data,
        success: function(res_data) {
            $(`#${post_id}_add_comment_form`).children('[name="comment"]').val('');
            view_comments(post_id);
        },
        error: function(res_data) {
            console.log(res_data);
                alertify.alert('Error', 'Something Went Wrong!');
        }
    });
}

function upload_resume(post_id)
{
    form_id = post_id+"_upload_resume_form";

    var form_data = new FormData(document.getElementById(form_id));
    
    $.ajax({
        url: "{{route('storeresume')}}",
        type: "POST",
        data:form_data,
        success: function(res_data) {
            
            $(`#${post_id}_resume_form_toggle`).html(`
            <div class="input-group mb-3">
                <input type="text" class="form-control" disabled value="${res_data.resume}">
                <div class="input-group-append">
                  <a href="${res_data.download_url}" target="_BLANK" class="input-group-text btn bg-primary text-light"><i class="fas fa-file-download"  onmouseover="tooltip(this)" title="Download Resume"></i></a>
                </div>
            </div>
            `);
        },
        cache: false,
        contentType: false,
        processData: false,
        error: function(res_data) {
            error = res_data.responseJSON['errors'];      
            $(`#${post_id}_upload_resume_form_error`).html(`<strong>${error['resume'][0]}</strong>`);      
        }
    });
}



function view_comments(post_id)
{
    $(`#${post_id}_comment_accordion`).html('');
    $(`#${post_id}_comment_accordion`).collapse('show');
    $(`#${post_id}_view_comments_btn`).hide();

    $.ajax({
        url: "{{ route('get_comments') }}",
        type: "GET",
        data: {
            post_id: post_id,
            count: 5,
        },
        success: function(res_data) {
            for(let comment of res_data.comment_data)
            {
                $(`#${post_id}_comment_accordion`).append(`<div><strong>${comment.username} :</strong> ${comment.comment}</div><hr>`);                        
            }

            if(res_data.comment_count > 5)
            {
                $(`#${post_id}_comment_accordion`).append(`<a class="btn btn-primary" onclick="view_all_comments(${post_id})">View More</a>`);                        
            }       
        },
        error: function(res_data) {
            $(`#${post_id}_comment_accordion`).html(`No Comments! Be first to comment.`);                        
        }
    });

}

function view_all_comments(post_id)
{
    $(`#${post_id}_comment_accordion`).html('');
    $(`#${post_id}_comment_accordion`).collapse('show');
    $(`#${post_id}_hide_comments_btn`).show();

    $.ajax({
        url: "{{ route('get_comments') }}",
        type: "GET",
        data: {
            post_id: post_id,
        },
        success: function(res_data) {

            for(let comment of res_data.comment_data)
            {
                $(`#${post_id}_comment_accordion`).append(`<div><strong>${comment.username} :</strong> ${comment.comment}</div><hr>`);                        
            }

                    
        },
        error: function(res_data) {
            $(`#${post_id}_comment_accordion`).html(`No Comments! Be first to comment.`);                        
        }
    });

}

function save_unsave_post(e,post_id)
{

    $.ajax({
        url: "{{route('save_unsave_post')}}",
        type: "POST",
        data:{
            post_id:post_id
        },
        success: function(res_data) {
            if(res_data == 'saved')
            {
                $(`#${post_id}_unsave_post`).show();
                $(`#${post_id}_save_post`).hide();
            }
            else if(res_data == 'unsaved')
            {
                $(`#${post_id}_unsave_post`).hide();
                $(`#${post_id}_save_post`).show();
            }        
        },
        error: function(res_data) {
        }
    });

}

function delete_post(post_id) 
{

    
  alertify.confirm('Confirmation', 'Are you sure? Post will be deleted forever.', function(){     
        $.ajax({
            url: "{{route('delete_post')}}",
            type: "POST",
            data:{
                post_id:post_id
            },
            success: function(res_data) {
                location.reload();
            },
            error: function(res_data) {
                alertify.alert('Error', 'Something Went Wrong!');
            }
        });
    }, 
    function(){ });
    
}

$(document).ready(function(){

    $('#search_bar').bind('input',function(){

        $('#searchResults').hide();
        $('#searchResults').html('');

        var search_string = $(this).val();
        if(search_string.length >= 2)
        {
            $.ajax({
                url: "{{ route('home.get_search_string') }}",
                type: "GET",
                data: {
                search_string : search_string,
                },
                success: function(res_data) {
                    if(typeof res_data == 'object')
                    {
                        $('#searchResults').show();
                        var bottom_border = "";
                        if(Object.keys(res_data).length > 1)
                        {
                            bottom_border = "border-bottom";
                        }
                        for(let user of res_data)
                        {
                            if(user.profile_pic == null)
                            {
                                $('#searchResults').append(`<div class="${bottom_border} bg-light">
                                    <img src="{{asset('images/profile_pics/default-profile-pic.png')}}" class="avatar m-2" alt="">
                                     <span class="h5 strong"><a href="${user.url}")>${user.name}</span>
                                  </div>`);                                
                            }
                            else
                            {
                                $('#searchResults').append(`<div class="${bottom_border} bg-light">
                                    <img src="{{asset('images/profile_pics/${user.username}/${user.profile_pic}')}}" class="avatar m-2" alt="">
                                     <span class="h5 strong"><a href="${user.url}")>${user.name}</span>
                                  </div>`);
                            }
                            // $('#searchResults').html(`<div class="border-bottom bg-light">
                            //         <img src="{{asset('images/profile_pics/default-profile-pic.png')}}" class="avatar m-2" alt="">
                            //          <span class="h5 strong">Arceus</span>
                            //       </div>`);
                        }   
                    }
                },
                error: function(res_data) {
                }
            });
        }
    })
});
</script>
</body>
</html>

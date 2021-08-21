@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-3 sticky-top border rounded py-3"> 
            <div class="row justify-content-center my-4">
                <img src="{{(isset($profile_details->profile_pic) && !empty($profile_details->profile_pic))? asset('images/profile_pics/'.$username.'/'.$profile_details->profile_pic) : asset('images/profile_pics/default-profile-pic.jpg')  }}" alt="Profile Picture" class="img-thumbnail w-75 rounded-circle">
            </div>
            <div class="row justify-content-center mt-4 h1">
                {{$name}}
            </div>
            <div class="h4 mt-3">Bio</div>
            <div>{{(isset($profile_details->bio) && !empty($profile_details->bio))? $profile_details->bio : 'N/A' }}</div>
            <hr>
            <div>
                <a href="" class="btn btn-primary">Saved Items</a>
            </div>
        </div>
        <div class="col-lg-6">
            
        </div>
        <div class="col-lg-3 sticky-top border rounded py-3">
            <div class="h2">Notifications</div>
            <hr>
            <div class="mt-2">
                @if (isset($notifications) && !empty($notifications))
                @foreach ($notifications as $notification)
                @switch($notification['type'])
                    @case('social_access_request')
                        <div class="alert alert-primary" role="alert">
                            <h4 class="alert-heading h5">{{$notification['details']['title']}}</h4>
                            
                            <hr>
                            <div>User <a href="{{url('/profile/'.$notification['details']['requested_by'])}}">{{$notification['details']['requested_by']}}</a> wants to access your social links!</div>
                            <hr>
                            <div class="mb-0">
                                <a href="" class="btn btn-sm btn-success">Accept</a>
                                <a href="" class="btn btn-sm btn-secondary">Decline</a>
                            </div>
                        </div>
                        @break
                
                    @default
                        
                @endswitch
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

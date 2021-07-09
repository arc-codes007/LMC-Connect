@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <img src="{{ asset('images/profile_pics/'.$profile_details['profile_pic']) }}" alt="Profile Picture" class="img-thumbnail w-25 rounded-circle">
    </div>
    <div class="row justify-content-center mt-4 h1">
        {{$name}}
    </div>
    <div class="row justify-content-center h5">
        {{$email}}
    </div>
    <div class="row justify-content-center">
        <a href="#" class="m-2"><i class="text-success fab fa-2x fa-whatsapp"></i></a>
        <a href="#" class="m-2"><i class="text-primary fab fa-2x fa-facebook"></i></a>
        <a href="#" class="m-2"><i class="text-dark fab fa-2x fa-instagram"></i></a>
        <a href="#" class="m-2"><i class="text-primary fab fa-2x fa-linkedin"></i></a>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-lg-4">
            <div class="h2 text-center">Personal Details</div>
            <div class="mt-3">
                <div class="h5">Bio</div>
                <div>{{(isset($profile_details['bio']) && !empty($profile_details['bio']))? $profile_details['bio'] : 'N/A' }}</div>
            </div>
            <div class="mt-3">
                <div class="h5">Course</div>
                <div>{{(isset($profile_details['course']) && !empty($profile_details['course']))? $profile_details['course'] : 'N/A' }}</div>
            </div>
            <div class="mt-3">
                <div class="h5">Year</div>
                <div>{{(isset($profile_details['year']) && !empty($profile_details['year']))? $profile_details['year'] : 'N/A' }}</div>
            </div>
            <div class="mt-3">
                <div class="h5">Skills</div>
                @if (empty($profile_details['skillset']))
                    <div>N/A</div>

                @else
                    <div class="row row-cols-2">
                        <ul>
                            @foreach ($profile_details['skillset'] as $skill)
                                <li class="col">{{$skill}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

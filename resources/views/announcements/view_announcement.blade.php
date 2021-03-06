@extends('layouts.app')
@section('content')

<div class="container">
    <div class="h1 text-center">Announcement</div>
    <hr>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="h3 mb-2">Deparment - </div>
                <div class="border h-100 d-flex align-items-center justify-content-center">
                    {{$announcement->department}}
                </div>   
            </div>
        </div>    
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="h3 mb-2">Subject - </div>
                <div class="border h-100 d-flex align-items-center justify-content-center">
                    {{$announcement->subject}}
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="h3 mb-2">Annoucement - </div>
                <div class="border p-2 h-100">
                    {!! $announcement->content !!}
                </div>
            </div>
        </div>
</div>

@endsection
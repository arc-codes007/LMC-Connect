@extends('layouts.app')
@section('content')

<div class="container">
    <div class="h1 text-center">Announcement Form</div>
    <hr>
    <form action="{{route('admin_panel.save_announcement')}}" method="POST">
        @csrf
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="h3 mb-2">Select Deparment - </div>
                <select name="annoucement_department" id="annoucement_department" class="custom-select" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="All Departments">All Departments</option>
                    @foreach (config('LMC.departments') as $department)
                        <option value="{{$department}}">{{$department}}</option>
                    @endforeach
                </select>
                @error('annoucement_department')
                <span class="text-danger mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror        
            </div>
        </div>    
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="h3 mb-2">Subject - </div>
                <input type="text" name="announcement_subject" id="announcement_subject" class="form-control">
                @error('announcement_subject')
                <span class="text-danger mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="h3 mb-2">Annoucement Content - </div>
                <textarea name="announcement_content" id="announcement_content" class="tiny form-control"></textarea>
                @error('announcement_content')
                <span class="text-danger mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="py-3 pb-4"> 
                <button type="submit" class="btn btn-success mr-3">Make Annoucement</button> 
            </div>
        </div>
    </form>
</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="bg-white mt-2 p-3">
        <h4 class="pb-4 border-bottom">Account settings</h4>
        <div class="py-2">
            <form action="{{route('update_account')}}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="row py-2">
                    <div class="col-md-6"> 
                        <label for="name">Name</label> <input type="text" name="name" class="bg-light form-control" value="{{$user->name}}"> 
                        @error('name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                         @enderror
                    </div>
                    <div class="col-md-6 pt-md-0 pt-3"> 
                        <label for="username">Username</label> <input type="text" name="username" class="bg-light form-control" value="{{$user->username}}"> 
                        @error('username')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                         @enderror
                    </div>
                </div>
                <div class="row py-2">
                    <div class="col-md-6"> 
                        <label for="email">Email Address</label> <input type="text" name="email" class="bg-light form-control" value="{{$user->email}}">
                        @error('email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                         @enderror
                    </div>
                    <div class="col-md-6 pt-md-0 pt-3"> 
                        <label for="department">Department</label>
                        <select name="department" id="department" class="custom-select" required>
                            @foreach (config('LMC.departments') as $department)
                                <option value="{{$department}}" {{($department == $user->department)? 'selected' : ''}}>{{$department}}</option>
                            @endforeach
                        </select> 
                        @error('department')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                         @enderror
                    </div>
                </div>
                <div class="py-3 pb-4 border-bottom"> 
                    <button type="submit" class="btn btn-primary mr-3">Save Changes</button> 
                </div>
            </form>
            <div class="d-sm-flex justify-content-between pt-3" id="deactivate">
                <div>
                    <button class="btn btn-success" id="show_change_password_form">Change Password</button>
                </div>
                <div class="d-sm-flex align-items-center">
                    <div class="mx-3"> 
                        <b>Delete your account</b>
                        <p>
                            Your account will be deleted! 
                            <br> 
                            Can be recovered by Adminstration only!
                        </p>
                    </div>
                    <div class="ml-auto"> <button class="btn btn-danger">Delete</button> </div>
                </div>
            </div>
        </div>

        <div id="change_password_form" class="collapse">
        
            <div class="row py-2">
                <div class="col-lg-6">
                    <div class="m-2"><label for="current_password">Current Password</label> <input type="password" name="current_password" class="bg-light form-control" value=""></div>
                    <div class="m-2 py-3 pb-4">
                        <button type="submit" class="btn btn-primary mr-3">Save Password</button> 
                        <button class="btn border button">Cancel</button> 
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="m-2"><label for="current_password">New Password</label> <input type="password" name="password" class="bg-light form-control" value=""></div>
                    <div class="m-2"><label for="password_confirmation">Confirm Password</label> <input type="password" name="password_confirmation" class="bg-light form-control" value=""></div>             
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){

    $('#show_change_password_form').click(function () 
    {
       $('#change_password_form').collapse('toggle'); 
    });

});

</script>

@endsection
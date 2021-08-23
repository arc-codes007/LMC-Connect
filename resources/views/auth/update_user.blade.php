@extends('layouts.app')

@section('content')

<div class="container">
    <div class="bg-white mt-2 p-3">
        <h4 class="pb-4 border-bottom">Account settings</h4>
        @if (session('status'))
            <div class="alert alert-success my-2">
                {{ session('status') }}
            </div>
        @endif
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
                        @if ($user_type == 'admin')
                        <b>Delete this account</b>
                        @else
                        <b>Delete your account</b>
                        <p>
                            Your account will be deleted! 
                            <br> 
                            Can be recovered by Adminstration only!
                        </p>
                        @endif
                    </div>
                    <form action="{{route('delete_account')}}" method="POST" id="delete_account_form">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="ml-auto"> <button class="btn btn-danger" id="delete_account_button">Delete</button> </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="change_password_form_accordion" class="collapse">
        <form action="" method="POST" id="change_password_form">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div class="row py-2">
                @if($user_type == 'user')
                    <div class="col-lg-6">
                        <div class="m-2">
                            <label for="current_password">Current Password</label> <input type="password" name="current_password" class="bg-light form-control" value="">
                            <span class="text-danger error" role="alert">
                            </span>
                        </div>
                        <div class="m-2 py-3 pb-4">
                            <button type="submit" class="btn btn-primary mr-3">Save Password</button> 
                        </div>
                    </div>
                @endif
                <div class="col-lg-6">
                    <div class="m-2">
                        <label for="current_password">New Password</label> 
                        <input type="password" name="password" class="bg-light form-control" value="">
                        <span class="text-danger error" role="alert">
                        </span>
                    </div>
                    <div class="m-2">
                        <label for="password_confirmation">Confirm Password</label> <input type="password" name="password_confirmation" class="bg-light form-control" value="">
                        <span class="text-danger error" role="alert">

                        </span>
                    </div>             
                </div>
            </div>
            @if ($user_type == 'admin')
            <div class="m-2 py-3 pb-4">
                <button type="submit" class="btn btn-primary mr-3">Save Password</button> 
            </div>                    
            @endif
        </form>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){

    $('#show_change_password_form').click(function () 
    {
       $('#change_password_form_accordion').collapse('toggle'); 
    });

    $('#change_password_form').submit(function(e)
    {
       e.preventDefault(); 
       var form_data = $('#change_password_form').serializeArray();
       var data = {};

       for(let value of form_data)
       {
           data[value['name']] = value['value'];
       }
       
       $.ajax({
        url: "{{route('update_account_password')}}",
        type: "POST",
        data:data,
        success: function(res_data) {
                alertify.alert('Success', 'Password Updated Successfully!');
            },
        error: function(res_data) {
            if(res_data.status == 406)
            {
                alertify.alert('Error', 'Something Went Wrong!');
            }
            error = res_data.responseJSON['errors'];            
            for(let key in error)
            {
                if(['password','current_password'].includes(key))
                {
                    $(`input[name = '${key}']`).next().html(`<strong>${error[key][0]}</strong>`);
                }
            }            
        }
        });
    });

    $('#delete_account_button').click(function(e){
        e.preventDefault();

        alertify.confirm('Are you sure?', function(){ 
            $('#delete_account_form').submit();
        });
    });

});

</script>

@endsection
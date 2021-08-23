<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rule;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;




class UpdateUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('verified');
    }

    
    public function show_update_account_form($username)
    {
        if($username == Auth::user()->username)
        {
            $data['user_type'] = 'user'; 
        }
        else if(Auth::user()->is_admin == 1)
        {
            $data['user_type'] = 'admin'; 
        }
        else
        {
            abort(401);
        }

        $user = User::where('username',$username)->first();

        $data['user'] = $user;

        return view('auth.update_user',$data);
    }

    public function update_account(Request $request)
    {   

        $request->validate([
            'user_id' => 'required|numeric',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username'=>['required','alpha_dash'],
            'department' => ['required', Rule::in(config('LMC.departments'))]
        ]);

        $post_data = $request->all();
        $user_id = $post_data['user_id'];

        $user = User::findorfail($user_id);
        $stored_user_details = $user->getAttributes();
        
        if($stored_user_details['username'] != $post_data['username'])
        {
            $request->validate([
                'username' => 'unique:users,username'
            ]);
            $user->username = $post_data['username'];
        }
        if($stored_user_details['email'] != $post_data['email'])
        {
            $request->validate([
                'email' => 'unique:users,email'
            ]);
            $user->email = $post_data['email'];
        }
        
        if($stored_user_details['name'] != $post_data['name'])
            $user->name = $post_data['name'];

        if($stored_user_details['department'] != $post_data['department'])
            $user->department = $post_data['department'];

        if($user->save())
        {
            return back()->with('status', 'Account settings updated!'); 
        }
        else
        {
            abort(406);
        }
        
        
    }

    public function update_account_password(Request $request)
    {
        $logged_in_user_is_admin = Auth::user()->is_admin;

        if($logged_in_user_is_admin)
        {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
        else
        {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'current_password' => ['required', 'string', 'min:8', 'current_password'],
            ]);
        }

        $post_data = $request->all();
        $user = User::find($post_data['user_id']);
        $user->password = Hash::make($post_data['password']);

        if($user->save())
        {
            return (new Response('Success',200));
        }
        else
        {
            return (new Response('Something Went Wrong',406));
        }
    }

    public function delete_account(Request $request)
    {
        $post_data = $request->all();

        if(!isset($post_data['user_id']) || empty($post_data['user_id']))
        {
            abort(400);
        }

        if(Auth::user()->id == $post_data['user_id'] || Auth::user()->is_admin == 1)
        {
            $user = User::findorfail($post_data['user_id']);
            if($user->delete())
            {
               return redirect(url(''));
            }
            else
            {
                abort(400);
            }
        }
        else
        {
            abort(401);
        }
    }
}

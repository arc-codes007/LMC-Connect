<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rule;


class UpdateUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('verified');
    }

    
    public function show_update_account_form($username)
    {
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

        $stored_user_details = User::findorfail($user_id)->getAttributes();
        
        if($stored_user_details['username'] != $post_data['username'])
        {
            if(User::where('username',$post_data['username'])->count())
            {   
                $request->validate([
                    'username' => 'unique:users,username'
                ]);
            }
        }
        if($stored_user_details['email'] != $post_data['email'])
        {
            if(User::where('email',$post_data['email'])->count())
            {   
                $request->validate([
                    'email' => 'unique:users,email'
                ]);
            }
        }
        dd('sds');
    }
}

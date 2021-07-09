<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        $logged_in_user = Auth::user();
        
        $logged_in_user_details = $logged_in_user->getAttributes();

        $data = array(
            'name' => $logged_in_user_details['name'],
            'email' => $logged_in_user_details['email'],
            'department' => $logged_in_user_details['department'],
        ); 
        
        if(empty($logged_in_user->profile()->get()->all()))
        {
            $profile_details['profile_pic'] = 'default-profile-pic.jpg';
            $data['profile_details'] = $profile_details;
        }
        else
        {
            
            $profile_details = $logged_in_user->profile()->get()->all()[0]->getAttributes();
            if(empty($profile_details['profile_pic']))
            {
                $profile_details['profile_pic'] = 'default-profile-pic.jpg';
            }
            $data['profile_details'] = $profile_details;
        }

        if(empty($logged_in_user->posts()->get()->all()))
        {
            $data['posts_data'] = array();
        }
        else
        {
            $posts_details = $logged_in_user->posts()->get()->all()[0]->getAttributes();
            dd($posts_details);
        }
    
    

        return view('profile.profile', $data);
    }

    public function create()
    {
        $logged_in_user = Auth::user();

        if(!empty($logged_in_user->profile()->get()->all()))
        {
           return redirect()->route('profile.edit');
        }
        else
        {
            return view('profile.create');
        }
    }
}

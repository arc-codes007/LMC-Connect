<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use App\Models\Resume;
use App\Models\UserSavedPosts;



class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index(){
        $users = User::get()->all();
        $posts = Posts::get()->all();
        $resumes = Resume::get()->all();
        $saved_posts = UserSavedPosts::get()->all();
        
        foreach ($posts as $post) {
            $post_owner_details = User::find($post->user_id);
        }


        $admin_data = array();

        $admin_data['users'] = $users;
        $admin_data['posts'] = $posts;     
        $admin_data['resumes'] = $resumes;     
        $admin_data['saved_posts'] = $saved_posts;
        // dd($admin_data);
        return view('admin.panel',$admin_data);
    }
}

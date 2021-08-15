<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Posts;
class PostViewController extends Controller
{
    public function view($post_random_id)
    {
        
        $post = Posts::where('random_id', '=', $post_random_id)->first();
        $username = User::find($post->user_id)->username;
        return view('postsv.view',['post' => $post, 'username' => $username]);
        exit();
    }
}    
// postdata = $post -> getAttributes();

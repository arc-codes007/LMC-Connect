<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function get_comments(Request $request)
    {
        // post_id required, 
        // dd('here');
        $request->validate([
            'post_id' => 'required',
        ]);
        $get_data = $request->all();

        if (isset($get_data['count']) && !empty($get_data['count'])) 
        {
            $comment_collection = Comments::where('post_id', '=', $get_data['post_id'])->take($get_data['count'])->orderBy('updated_at','DESC')->get();
        }
        else 
        {
            $comment_collection = Comments::where('post_id', '=', $get_data['post_id'])->orderBy('updated_at','DESC')->get();
        }

        if($comment_collection->count() == 0)
        {
            return (new Response('No Comments Found!',404));    
        }

        $comment_data = array();
        foreach ($comment_collection as $key => $comment) 
        {
            $comment_details = $comment->getAttributes();
            $user_commented = User::find($comment_details['user_id']);
            if($user_commented == null) continue;

            $comment_data[$key] = $comment_details;
            $username = $user_commented->username;
            $comment_data[$key]['username'] = $username;
        }

        if(empty($comment_data))
        {
            return (new Response('No Comments Found!',404));    
        }
        $return_data = array(
            'comment_count' => count($comment_data),
            'comment_data' => $comment_data
        );

        return (new Response($return_data,200));
    }
}

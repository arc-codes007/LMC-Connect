<?php

namespace App\Http\Controllers;

use App\Models\Posts;
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
            $comment_data[$key] = $comment->getAttributes();
            $user_id = $comment_data[$key]['user_id'];
            $username = User::find($user_id)->get()->first()->username;
            $comment_data[$key]['username'] = $username;
        }

        $return_data = array(
            'comment_count' => Comments::where('post_id', '=', $get_data['post_id'])->count(),
            'comment_data' => $comment_data
        );

        return (new Response($return_data,200));
    }
}

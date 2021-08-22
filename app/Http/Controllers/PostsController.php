<?php

namespace App\Http\Controllers;


use App\Models\Posts;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Http\Request;

use Auth;
use Session;
use URL;
use Illuminate\Http\Response;


class PostsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function create()
    {
        Session::put('requestReferrer', URL::previous());

        return view('posts.create_edit_posts');
    }




    public function storeedit(Request $request, $id)
    {
        // Validate the request...
        if (isset($id) && !empty($id)) {

            $request->validate([
                'title' => 'required',
                'random_id' => 'required',
                'description' => '',
            ]);

            $post_data = $request->all();

            $posts = Posts::where('random_id', $id)->first();
            if ($post_data['title'] != null) {
                $posts->title = $post_data['title'];
            }
            if ($post_data['description'] != null) {
                $posts->description = $post_data['description'];
            }
        }

        if ($posts->save()) {
            return redirect(Session::get('requestReferrer'));
        }
    }




    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'post_image' => ['required', 'image'],
            'description' => '',
        ]);



        $post_data = $request->all();
        $logged_in_user = Auth::user();
        $logged_in_user_details = $logged_in_user->getAttributes();



        $post_imageName = '';
        if (isset($post_data['post_pic']) && !empty($post_data['post_pic'])) {
            if (!is_dir('images/posted_images/' . $logged_in_user_details['username'])) {
                mkdir('images/posted_images/' . $logged_in_user_details['username']);
            }
            $folderPath = public_path('images/posted_images/' . $logged_in_user_details['username'] . '/');

            $image_parts = explode(";base64,", $post_data['post_pic']);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $post_imageName = uniqid() . '_' . $logged_in_user_details['username'] . '.' . $image_type;

            $imageFullPath = $folderPath . $post_imageName;

            file_put_contents($imageFullPath, $image_base64);
        }



        $permitchar = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $random_id =  substr(str_shuffle($permitchar), 0, 6);


        $posts = new Posts;

        $posts->user_id = $logged_in_user_details['id'];
        $posts->department = $logged_in_user_details['department'];
        
        if ($post_imageName != '') {
            $posts->post_image = $post_imageName;
        }
        if ($post_data['title'] != null) {
            $posts->title = $post_data['title'];
        }
        if ($post_data['description'] != null) {
            $posts->description = $post_data['description'];
        }
        if ($random_id != ' ') {
            $posts->random_id = $random_id;
        }


        if ($posts->save()) {
            return redirect(Session::get('requestReferrer'));
        }
    }


    public function viewpost($post_random_id)
    {

        $post = Posts::where('random_id', '=', $post_random_id)->first();
        $postdata = $post->getAttributes();
        $username = User::find($post->user_id)->username;
        return view('posts.view_post', ['post' => $post, 'username' => $username]);        
    }

    public function storecomment(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'random_id' => 'required',
        ]);

        $data = $request->all();
        
        $post = Posts::where('random_id', $data['random_id'])->first();
        if($post == null)
        {
            return (new response('Something went wrong',404));
        }

        $storecom = $post->getAttributes();
        $comment = new Comments;
        $comment->post_id = $storecom['id'];
        $comment->user_id = $storecom['user_id'];
        if ($data['comment'] != null) 
        {
            $comment->comment = $data['comment'];
        }

        if ($comment->save()) 
        {
            return (new response('Success',201));
        }
    }

    public function edit($id)
    {


        if (isset($id) && !empty($id)) {
            $data = Posts::where('random_id', $id)->first();
            $username = User::find($data->user_id)->username;
            // $editdata = $data->getAttributes();
            return view('posts.create_edit_posts', ['data' => $data, 'username' => $username]);
        }
    }
}

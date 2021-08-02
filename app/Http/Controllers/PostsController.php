<?php

namespace App\Http\Controllers;


use App\Models\Posts;
use App\Models\Users;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Http\Response;


class PostsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('verified');
    }

    // public function index()
    // {
    //     $users = auth()->user()->following()->pluck('profiles.user_id');

    //     $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

    //     return view('posts.index', compact('posts'));
    // }

    public function create()
    {
        return view('posts.create');
    }




    public function store(Request $request)
    {
        // Validate the request...
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


        // $posts = Posts::where('user_id', $logged_in_user_details['id']);
        // dd($posts);
        // if ($posts == null) {
        $posts = new Posts;

        $posts->user_id = $logged_in_user_details['id'];

        if ($post_imageName != '') {
            $posts->post_image = $post_imageName;
        }
        if ($post_data['title'] != null) {
            $posts->title = $post_data['title'];
        }
        if ($post_data['description'] != null) {
            $posts->description = $post_data['description'];
        }
        // }

        if ($posts->save()) {
            return redirect('/profile');
        }
    }








    // public function show(\App\Post $post)
    // {
    //     return view('posts.show', compact('post'));
    // }
}

<?php

namespace App\Http\Controllers;


use App\Models\Posts;
use App\Models\User;
use App\Models\Comments;
use App\Models\UserSavedPosts;
use App\Models\Resume;
use Illuminate\Http\Request;
use App\Models\Notifications;


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

            if( isset($post_data['show_send_resume_button']) && !empty($post_data['show_send_resume_button']) && $post_data['show_send_resume_button'] = 'on'){
                $posts->show_send_resume_button = 1;
            }
            elseif($post_data['show_send_resume_button'] = 'off'){
                $posts->show_send_resume_button = 0;
            }
            
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

        if(isset($post_data['show_send_resume_button']) && !empty($post_data['show_send_resume_button']) && $post_data['show_send_resume_button'] = 'on'){
            $posts->show_send_resume_button = 1;
        }
        elseif($post_data['show_send_resume_button'] = 'off'){
            $posts->show_send_resume_button = 0;
        }
        
        
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
        $user = Auth::user();


        $post = Posts::where('random_id', '=', $post_random_id)->first();
        $post_owner_details = User::find($post->user_id);
        $post_owner_details->profile_pic = ($post_owner_details->profile()->first() != null)? $post_owner_details->profile()->first()->profile_pic:null;
        if($user->id == $post->user_id){
            $post_owner = true;
        }
        else
        {
            $post_owner = FALSE;

        }

        if($user->is_admin == 1)
        {
            $is_admin = true;
        }
        else
        {
            $is_admin = FALSE;

        }

        $data = array(
            'post' => $post, 
            'post_owner_details' => $post_owner_details ,
            'post_owner' => $post_owner,
            'is_admin' => $is_admin,
        );
        
        if($post->user_id == $user->id)
        {
            $resume = Resume::where('post_id',$post->id)->get()->all();
            foreach($resume as $key=>$value)
            {
                $resume[$key]->username = User::find($value->user_id)->username;
            }   
        }
        else
        {
            $resume = Resume::where('post_id',$post->id)->where('user_id',$user->id)->get()->first();
        }        if($resume != null)
        {
            $data['resume'] = $resume;
        }

        $is_post_saved_for_user = FALSE;
        if(UserSavedPosts::where('user_id',$user->id)->where('post_id',$post->id)->count() > 0)
        {
            $is_post_saved_for_user = TRUE;
        }
        $data['is_post_saved_for_user'] = $is_post_saved_for_user;

        return view('posts.view_post', $data);        
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

        $comment = new Comments;
        $comment->post_id = $post->id;
        $comment->user_id = Auth::user()->id;
        if ($data['comment'] != null) 
        {
            $comment->comment = $data['comment'];
        }

        if ($comment->save()) 
        {
            $notification = new Notifications;

            $notification->user_id = $post->user_id;
            $notification->type = 'comment';
            $notification_data = array(
                'post_id' => $post->id,
                'post_title' => $post->title,
                'post_random_id' => $post->random_id,
                'comment_by_id' => Auth::user()->id
            );
            $notification->details = json_encode($notification_data);
            $notification->save();
            return (new response('Success',201));
        }
    }

    public function edit($id)
    {


        if (isset($id) && !empty($id)) {
            $data = Posts::where('random_id', $id)->first();
            $username = User::find($data->user_id)->username;
            return view('posts.create_edit_posts', ['data' => $data, 'username' => $username]);
        }
    }

    public function save_unsave_post(Request $request)
    {
        $post_data = $request->all();
        $logged_in_user_id = Auth::user()->id;

        if(UserSavedPosts::where('user_id',$logged_in_user_id)->where('post_id',$post_data['post_id'])->count() > 0)
        {
            if(UserSavedPosts::where('user_id',$logged_in_user_id)->where('post_id',$post_data['post_id'])->delete())
            {
                return (new Response('unsaved',200));
            }
        }
        else
        {
            $user_saved_post = new UserSavedPosts();
            $user_saved_post->post_id = $post_data['post_id'];
            $user_saved_post->user_id = $logged_in_user_id;

            if($user_saved_post->save())
            {
                return (new Response('saved',200));
            }
        }

    }

    public function user_saved_posts()
    {
        $logged_in_user = Auth::user();

        $all_saved_posts = array();

        $posts = UserSavedPosts::where('user_id',$logged_in_user->id)->get()->all();
        
        if(!empty($posts))
        {
            foreach($posts as $key => $post_id)
            {
                $all_saved_posts[$key] = Posts::find($post_id->post_id);
                $all_saved_posts[$key] = Posts::find($post_id->post_id);
                $all_saved_posts[$key]->username = User::find($all_saved_posts[$key]->user_id)->username;
            }
        }

        $data = array(
            'all_saved_posts' => $all_saved_posts
        );

        return view('posts.user_saved_posts',$data);
    }

    public function delete_post(Request $request)
    {
        $post_data = $request->all();

        $post = Posts::find($post_data['post_id']);

        if(Auth::user()->id == $post->user_id || Auth::user()->is_admin)
        {
            if(Auth::user()->is_admin && Auth::user()->id != $post->user_id)
            {
                $notification = new Notifications;

                $notification->user_id = $post->user_id;
                $notification->type = 'post_deleted_by_admin';
                $notification_data = array(
                    'post_title' => $post->title,
                    'deleted_by_id' => Auth::user()->id
                );
                $notification->details = json_encode($notification_data);
                $notification->save();
            }
            if($post->delete())
            {
                return (new response('Success',200));
            }
        }
        else
        {
            return (new response('Unauthorized ',401));
        }
    }

}

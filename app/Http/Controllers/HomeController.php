<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        $data['username'] = $user->username;
        $data['name'] = $user->name;
        if(!empty($user->profile()->get()->all()))
            $data['profile_details'] = $user->profile()->get()->all()[0];

        $all_notifications = $user->notifications()->get()->all(); 
        if(!empty($all_notifications))
        {
            $notifications = array();

            foreach($all_notifications as $key=>$notification)
            {
                $notifications[$key] = $notification->getAttributes();
                $notifications[$key]['details'] = json_decode($notifications[$key]['details'],TRUE);
                $notifications[$key]['details']['requested_by_username'] = User::find($notifications[$key]['details']['requested_by'])->username;
            }

            $data['notifications'] = $notifications;
        }


        return view('home.main', $data);
    }

    public function get_posts(Request $request)
    {        
        $user = Auth::user();

        $posts = Posts::where('department',$user->department)->get()->all();
        $post_html_array = array();
        foreach($posts as $post)
        {
            $username = User::find($post->user_id)->username;
            if(Auth::user()->id == $post->user_id || Auth::user()->is_admin == 1){
                $valid_user = true;
            }
            else
            {
                $valid_user = false;
            }
            $post_html_array[] = view('posts.view_block', ['post' => $post, 'username' => $username ,'valid_user' => $valid_user])->renderSections()['post'];        
        }

        return (new response($post_html_array,200));
    }

    public function get_search_string(Request $request){
        $request->validate([
            'search_string' => 'required'
        ]);

        $get_data = $request->all();

        $user_list = User::where('name','like',$get_data['search_string'].'%')->where('username','like',$get_data['search_string'].'%')->where('id','!=',Auth::user()->id)->get()->all();

        if($user_list == null)
        {
            return (new response('No user found',204));            
        }
        $data = array();
        foreach($user_list as $key=>$user)
        {
            $profile_pic = $user->profile()->get()->first();
            if($profile_pic == null)
            {
                $data[$key]['profile_pic'] = null;
            }
            else
            {
                $data[$key]['profile_pic'] = $profile_pic->profile_pic;                
            }
            $data[$key]['name'] = $user->name;
            $data[$key]['username'] = $user->username;
        }

        return (new response($data,200));
    }
}

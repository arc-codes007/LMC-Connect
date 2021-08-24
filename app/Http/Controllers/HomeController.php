<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Notifications;
use App\Models\Resume;
use App\Models\User;
use App\Models\UserSavedPosts;
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
                switch($notification->type)
                {
                    case 'social_access_request':
                        $notification_data = $notification->getAttributes();
                        $user_details = User::find(json_decode($notification_data['details'],TRUE)['requested_by']);
                        if($user_details == null) break;
                        $notifications[$key] = $notification_data;
                        $notifications[$key]['details'] = json_decode($notifications[$key]['details'],TRUE);
                        $notifications[$key]['details']['requested_by_username'] = $user_details->username;
                    break;

                    case 'comment':
                        $notification_data = $notification->getAttributes();
                        $user_details = User::find(json_decode($notification_data['details'],TRUE)['comment_by_id']);
                        if($user_details == null) break;
                        $notifications[$key] = $notification_data;
                        $notifications[$key]['details'] = json_decode($notifications[$key]['details'],TRUE);
                        $notifications[$key]['details']['comment_by_username'] = $user_details->username;
                    break;

                    case 'post_deleted_by_admin';
                        $notifications[$key] = $notification->getAttributes();
                        $notifications[$key]['details'] = json_decode($notifications[$key]['details'],TRUE);
                    break;

                    case 'resume_recieved';
                        $notification_data = $notification->getAttributes();
                        $user_details = User::find(json_decode($notification_data['details'],TRUE)['resume_sent_by_id']);
                        if($user_details == null) break;
                        $notifications[$key] = $notification_data;
                        $notifications[$key]['details'] = json_decode($notifications[$key]['details'],TRUE);
                        $notifications[$key]['details']['resume_sent_by_username'] = $user_details->username;
                    break;

                }
            }

            $data['notifications'] = $notifications;
        }


        return view('home.main', $data);
    }

    public function get_posts(Request $request)
    {        
        $user = Auth::user();

        if($user->is_admin)
        {
            $posts = Posts::orderBy('updated_at','DESC')->paginate(5);
        }
        else
        {
            $posts = Posts::where('department',$user->department)->orderBy('updated_at','DESC')->paginate(5);
        }
        $post_html_array = array();
        foreach($posts as $post)
        {
            $post_owner_details = User::find($post->user_id);
            if($post_owner_details == null)
            {
                continue;
            }
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
                    $resume_posted_by_user = User::find($value->user_id);
                    if($resume_posted_by_user == null)
                    {
                        unset($resume[$key]);
                        continue;
                    }
                    $resume[$key]->username = $resume_posted_by_user->username;
                }   
            }
            else
            {
                $resume = Resume::where('post_id',$post->id)->where('user_id',$user->id)->get()->first();
            }

            if($resume != null)
            {
                $data['resume'] = $resume;
            }

            $is_post_saved_for_user = FALSE;
            if(UserSavedPosts::where('user_id',$user->id)->where('post_id',$post->id)->count() > 0)
            {
                $is_post_saved_for_user = TRUE;
            }
            $data['is_post_saved_for_user'] = $is_post_saved_for_user;

            $post_html_array[] = view('posts.view_block', $data)->renderSections()['post'];        
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
            $data[$key]['url'] = route('profile.view_user',$user->username);
        }

        return (new response($data,200));
    }

    function delete_notification(Request $request)
    {
        $post_data = $request->all();

        $notification = Notifications::find($post_data['notification_id']);

        if(Auth::user()->id == $notification->user_id)
        {
            if($notification->delete())
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

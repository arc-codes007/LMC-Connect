<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Resume;
use App\Models\UserSavedPosts;
use Illuminate\Http\Response;
use Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index(){
        $users_count = User::get()->count();
        $posts = Post::withCount('comments')->orderBy('comments_count', 'desc')->take(5)->get();
        $resumes_count = Resume::get()->count();
        
        foreach ($posts as $key=>$post) 
        {
            $posted_by = User::find($post->user_id);
            if($posted_by == null)
            {
               unset($posts[$key]);
               continue; 
            }
            $posts[$key]->posted_by_username = User::find($post->user_id)->username;
        }


        $admin_data = array();

        $admin_data['users_count'] = $users_count;
        $admin_data['posts'] = $posts;     
        $admin_data['resumes_count'] = $resumes_count;     

        return view('admin.panel',$admin_data);
    }

    public function open_all_user_list()
    {
        return view('admin.user_list');
    }

    public function get_users(Request $request)
    {

        $user = User::paginate(10);
        $users_array = array();

        foreach($user as $key=>$value)
        {
            $users_array[$key]['name'] = $value->name;
            $users_array[$key]['username'] = $value->username;
            $users_array[$key]['department'] = $value->departmentame;
            $users_array[$key]['user_view_url'] = route('profile.view_user',$value->username);
            $users_array[$key]['user_settings_url'] = route('show_update_account_form',$value->username);
        }

        return (new response($users_array,200));

    }

    public function open_deleted_user_list()
    {
        return view('admin.deleted_user_list');
    }

    public function get_deleted_users()
    {

        
        $user = User::onlyTrashed()->paginate(10);
        $users_array = array();

        foreach($user as $key=>$value)
        {
            $users_array[$key]['name'] = $value->name;
            $users_array[$key]['username'] = $value->username;
            $users_array[$key]['department'] = $value->departmentame;
            $users_array[$key]['restoring_url'] = route('admin_panel.restore_user',$value->username);
        }

        return (new response($users_array,200));

        
    }

    function restore_user($username)
    {
        if(Auth::user()->is_admin)
        {
            $user = User::onlyTrashed()->where('username',$username);
            
            if($user->restore())
            {
                return redirect(route('admin_panel.open_deleted_user_list'));
            }
        }
        else
        {
            abort(401);
        }
    }
}

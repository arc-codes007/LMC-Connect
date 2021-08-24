<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Resume;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Http\Response;

class ResumeController extends Controller
{
    public function save_resume(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'resume' => 'required|mimes:pdf|max:10240',
        ]);

        $post_data = $request->all();
        $post = Posts::find($post_data['post_id']);
        $logged_in_user = Auth::user();
        $logged_in_user_details = $logged_in_user->getAttributes();
        $resume_name = '';

        if(Resume::where('post_id',$post_data['post_id'])->where('user_id',$logged_in_user_details['id'])->count() > 0)
        {
            return (new response('Unauthorized',401));
        }
        
        if (isset($post_data['resume']) && !empty($post_data['resume'])) 
        {
                        
            $resume_file = $post_data['resume'];
            $folderPath = public_path('resumes/' . $logged_in_user_details['username'] . '/');
            $resume_name = uniqid().'_'.$logged_in_user_details['username'].'_resume.'.$resume_file->getClientOriginalExtension();
            
            $resume_file->storeAs('resumes', $resume_name);
             
            $resume = new resume;

            $resume->user_id = $logged_in_user_details['id'];
            $resume->post_id = $post_data['post_id'];
             
            
            if ($post_data['resume'] != null) 
            {
                $resume->resume = $resume_name;
            }  
            if ($resume->save())
            {
                $notification = new Notifications;

                $notification->user_id = $post->user_id;
                $notification->type = 'resume_recieved';
                $notification_data = array(
                    'post_id' => $post->id,
                    'post_title' => $post->title,
                    'post_random_id' => $post->random_id,
                    'resume_sent_by_id' => Auth::user()->id
                );
                $notification->details = json_encode($notification_data);
                $notification->save();

                $data = array(
                    'resume' => $resume_name,
                    'download_url' => route('downloadresume',$resume_name)
                );
                return (new Response($data,201));                             
            }
            
            
        }       
       
    } 
    public function download($file_name)
    {
        return response()->download(storage_path('app/resumes/'.$file_name));       
    }              
  
    
}

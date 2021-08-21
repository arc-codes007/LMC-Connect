<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Http\Response;

class ResumeUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'resume' => 'required|mimes:pdf|max:10240',
        ]);

        $post_data = $request->all();

        $logged_in_user = Auth::user();
        $logged_in_user_details = $logged_in_user->getAttributes();
        $resume_name = '';
        
        if (isset($post_data['resume']) && !empty($post_data['resume'])) 
        {
            
            if (!is_dir('resumes/' . $logged_in_user_details['username'])) 
            {
                mkdir('resumes/' . $logged_in_user_details['username']);
            }
            
            $resume_file = $post_data['resume'];
            $folderPath = public_path('resumes/' . $logged_in_user_details['username'] . '/');
            $resume_name = uniqid().'_'.$logged_in_user_details['username'].'_resume.'.$resume_file->getClientOriginalExtension();
            

            $resumePath = $folderPath . $resume_name;
             
            file_put_contents($resumePath,$resume_name);
            
            $resume = new resume;

            $resume->user_id = $logged_in_user_details['id'];
            $resume->post_id = $post_data['post_id'];
             
            
            if ($post_data['resume'] != null) 
            {
                $resume->resume = $post_data['resume'];
            }  
            if ($resume->save())
            {
                return back();
            }
            
            
        }       
       
    } 
        
  
    
}

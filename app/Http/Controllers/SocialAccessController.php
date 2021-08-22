<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\SocialAccessRequests;
use App\Models\Notifications;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notification;

class SocialAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    //


    public function create_social_access_request(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username'
        ]);

        $post_data = $request->all();

        $logged_in_user_id = Auth::id();
        $requested_to_id = User::where('username',$post_data['username'])->first()->getAttributes()['id'];

        $social_access_request = SocialAccessRequests::where('requested_by_user_id',$logged_in_user_id)->where('requested_to_user_id',$requested_to_id)->first();
        if($social_access_request != null)
        {
            $error = array(
                'type' => 'custom',
                'message' => 'Unauthorized Action'
            );
            return (new Response($error, 401));
        }

        $social_access_request = new SocialAccessRequests;

        $social_access_request->requested_by_user_id = $logged_in_user_id;
        $social_access_request->requested_to_user_id = $requested_to_id;
        $social_access_request->status = 'pending';

        if($social_access_request->save())
        {
            $notification = new Notifications;

            $notification->user_id = $requested_to_id;
            $notification->type = 'social_access_request';
            $notification_data = array(
                'title' => 'Social Links Access Request',
                'requested_by' => $logged_in_user_id,
            );
            $notification->details = json_encode($notification_data);

            if($notification->save())
                return (new Response('Success', 201));
        }

    }

    public function accept_decline_social_access_request(Request $request)
    {
        $request->validate([
            'requested_by' => 'required|numeric',
            'requested_to' => 'required|numeric',
            'notification_id' => 'required|numeric',
            'type' => 'required|in:accept,decline'
        ]);

        $post_data = $request->all();
        
        $requested_by = $post_data['requested_by'];
        $requested_to = $post_data['requested_to'];
        $notification_id = $post_data['notification_id'];
        $type = $post_data['type'];

        $social_access_request = SocialAccessRequests::where('requested_by_user_id',$requested_by)->where('requested_to_user_id',$requested_to)->first();

        if($social_access_request == null)
        {
            return (new response('Something Went Wrong',401));
        }

        if($type == 'accept')
        {
            $social_access_request->status = 'approved';

            if($social_access_request->save())
            {
                $notification = Notifications::find($notification_id);
                if($notification->delete())
                {
                    return (new response('Success',201));
                }
                else
                {
                    return (new response('Something Went Wrong',401));
                }
            }
            else
            {
                return (new response('Something Went Wrong',401));
            }
        }
        else if($type == 'decline')
        {

            if($social_access_request->delete())
            {
                $notification = Notifications::find($notification_id);
                if($notification->delete())
                {
                    return (new response('Success',201));
                }
                else
                {
                    return (new response('Something Went Wrong',401));
                }
            }
            else
            {
                return (new response('Something Went Wrong',401));
            }   
        }
    }
}

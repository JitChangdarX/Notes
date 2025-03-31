<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class DashbordController extends Controller
{
    public function dashbordaction()
    {
        $user_id = Session::get('user_id');


        if (!$user_id) {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }


        $user = DB::table('signup_account')->where('id', $user_id)->first();

        
        if (!$user) {
            abort(404);
        }

        $profilePhotos = $user->profile_photo ? json_decode($user->profile_photo, true) : null;
        $profilePhoto = is_array($profilePhotos) && !empty($profilePhotos) ? $profilePhotos[0] : 'default-profile.png';

        return view('dashbord', compact('user', 'profilePhoto'));
    }
}


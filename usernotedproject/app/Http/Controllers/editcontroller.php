<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class editcontroller extends Controller
{
    public function edit($id)
    {
        return view('edit', compact('id'));
        $user_id = Session::get('user_id');
        $user = User::find($user_id);
      
        return view('dashbord', compact('user', 'user_id'));
    }
}

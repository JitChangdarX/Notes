<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\signup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class editcontroller extends Controller
{
    // Show edit profile page
    public function edit($id)
    {
        return view('edit', compact('id'));
        $user_id = Session::get('user_id');
        $user = User::find($user_id);
      
        return view('dashbord', compact('user', 'user_id'));
    }

    // Handle profile update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'nullable|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user = signup::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // ✅ Password update (optional)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // ✅ Handle profile photo update
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $uploadLocation = 'uploads/profile';
            $file->move(public_path($uploadLocation), $fileName);

            // Delete old photo if it exists
            if ($user->profile_photo) {
                $oldPhotos = json_decode($user->profile_photo, true);
                foreach ($oldPhotos as $old) {
                    $oldPath = public_path($uploadLocation . '/' . $old);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }

            // Save new photo path
            $user->profile_photo = json_encode([$fileName]);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}

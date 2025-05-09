<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit profile</title>
    <link rel="stylesheet" href="{{ asset('asset/css/edit.css') }}">
</head>

<body>

    @php
        use Illuminate\Support\Facades\DB;
        $user = DB::table('signup_account')->where('id', session('user_id'))->first();

        $profilePhotos = $user ? json_decode($user->profile_photo, true) : null;
        $profilePhoto = is_array($profilePhotos) && !empty($profilePhotos) ? $profilePhotos[0] : 'default-profile.png';


    @endphp


    <div class="profile-header magnetic">
        <div class="photo-frame"></div>
        <img src="{{ asset($profilePhoto) }}" class="profile-photo" id="profilePhoto" alt="Profile">
        <h2>Edit Profile</h2>
    </div>

    <form action="{{ route('update_profile', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')
        <div class="form-group magnetic">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required value="{{ $user->name }}">
            <div class="input-line"></div>
        </div>
    
        <div class="form-group magnetic">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="{{ $user->email }}">
            <div class="input-line"></div>
        </div>
    
        <div class="form-group magnetic">
            <label for="password">New Password (leave blank to keep current)</label>
            <div class="password-container">
                <input type="password" name="password" id="password" value="{{ $user->password ?? '' }}" placeholder="Enter new password">
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
                <div class="input-line"></div>
            </div>
        </div>
    
        <div class="form-group magnetic">
            <label for="photo">Profile Photo</label>
            
            <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
            <div class="input-line"></div>
        </div>
    
        <button type="submit" id="updateButton" class="btn magnetic">Update Profile</button>
    </form>

    <div class="success-message" id="successMessage">
        Profile Updated Successfully!
    </div>
    </div>
    <script src="{{ asset('asset/js/edit.js') }}"></script>
</body>

</html>

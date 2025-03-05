<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dashbord</title>
    <link rel="stylesheet" href="{{ asset('asset/css/dashbord.css') }}">
    <script src="{{ asset('asset/js/dashbord.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<body>


    {{-- // create a logo logout my profile my notes --}}
    {{-- check screenshoet --}}
    {{-- create light and dark theme --}}

    {{-- create a nav bar --}}

    {{-- @php
        use App\Models\SignupAccount; // Correct model name

        $users = SignupAccount::all(); // Fetch all rows from `signup_account` table

        foreach ($users as $user) {
            echo $user->name; // Display column values
        }
    @endphp --}}

    @php
        $user = DB::table('signup_account')->where('id', session('user_id'))->first();
        $profilePhotos = json_decode($user->profile_photo, true);
        $profilePhoto = is_array($profilePhotos) ? $profilePhotos[0] : $profilePhotos;
    @endphp

    @if ($user)
        <p>User ID: {{ $user->id }}</p>
        {{-- <p>User Name: {{ $user->name }}</p> --}}
        <p>Email: {{ $user->email }}</p>
    @endif
    
        {{-- @if ($profilePhoto)
            <img src="{{ asset($profilePhoto) }}" alt="Profile Image" width="100">
        @else
            <p>No profile image available</p>
        @endif 
     @else
        <p>User not found.</p>
    @endif --}}





    <div class="header">
        <div class="logo-container">
            <div class="logo">
                <a href="{{ route('dashbord', ['id' => session('user_id')]) }}">
                    <img src="https://www.gstatic.com/images/branding/product/1x/keep_2020q4_48dp.png" alt="Logo">


                </a>
                <h1>My Notes</h1>


                <div class="profile-container">
                    <div class="profile-header">
                        <img src="{{ asset($profilePhoto) }}" class="profile-image" alt="Profile">
                        <span class="profile-name">{{ $user->name }}</span>
                        <span class="dropdown-icon">▼</span>
                    </div>

                    <div class="profile-dropdown">
                        <div class="dropdown-item">Settings</div>
                        <div class="dropdown-item delete-btn">Delete Chat History</div>
                    </div>
                </div>
                <script>
                    const profileHeader = document.querySelector('.profile-header');
                    const profileDropdown = document.querySelector('.profile-dropdown');

                    profileHeader.addEventListener('click', (e) => {
                        e.stopPropagation();
                        profileDropdown.classList.toggle('active');
                        profileHeader.classList.toggle('active');
                    });

                    document.addEventListener('click', () => {
                        profileDropdown.classList.remove('active');
                        profileHeader.classList.remove('active');
                    });

                    document.querySelector('.delete-btn').addEventListener('click', () => {
                        const confirmDelete = confirm('Are you sure you want to delete all chat history?');
                        if (confirmDelete) {
                            document.querySelectorAll('.chat-item').forEach(item => item.remove());
                            profileDropdown.classList.remove('active');
                        }
                    });

                    document.querySelectorAll('.dropdown-item').forEach(item => {
                        if (!item.classList.contains('delete-btn')) {
                            item.addEventListener('click', () => {
                                alert('Settings clicked');
                                profileDropdown.classList.remove('active');
                            });
                        }
                    });
                </script>
                <div id="showdiv"></div>
            </div>
        </div>

        <div class="searchbox">
            <form action="" method="get" class="search-box">
                <input type="text" placeholder="Search...">
            </form>
        </div>
    </div>


    {{-- cerate a logo --}}


    {{-- {{ create a div  multiple div }} --}}
    <div class="container">
        <div class="parent">
            <div class="div1">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
            </div>


            <div class="div2">
                <input type="text" contenteditable="true">
                <input type="text" class="custom-input" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
            </div>
            <div class="div3">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
            </div>

            <div class="div4">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
            </div>
        </div>
    </div>
</body>

</html>

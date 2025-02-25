<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dashbord</title>
    <link rel="stylesheet" href="{{ asset('asset/css/dashbord.css') }}">
    <script src="{{ asset('asset/js/dashbord.js') }}"></script>
<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<body>

    
    {{-- // create a logo logout my profile my notes --}}
    {{-- check screenshoet --}}
    {{-- create light and dark theme --}}

    {{-- create a nav bar --}}
    <div class="header">
        <div class="logo-container">
            <div class="logo">
                <a href="{{ route('dashbord') }}">
                    <img src="https://www.gstatic.com/images/branding/product/1x/keep_2020q4_48dp.png" alt="Logo">
                    
                 
                </a>
                <h1>My Notes</h1>
                <div class="profile-dropdown">
                    <div onclick="toggle()" class="profile-dropdown-btn">
                      <div class="profile-img">
                        <i class="fa-solid fa-circle"></i>
                      </div>
            
                      <span>Profile
                        <i class="fa-solid fa-angle-down"></i>
                      </span>
                    </div>
            
                    <ul class="profile-dropdown-list">
                      <li class="profile-dropdown-list-item">
                        <a href="#">
                            <i class="fa-solid fa-circle-user"></i>
                          Edit Profile
                        </a>
                      </li>
            
                      <li class="profile-dropdown-list-item">
                        <a href="#">
                          <i class="fa-regular fa-envelope"></i>
                          Inbox
                        </a>
                      </li>
            
                      <li class="profile-dropdown-list-item">
                        <a href="#">
                          <i class="fa-solid fa-chart-line"></i>
                          Analytics
                        </a>
                      </li>
            
                      <li class="profile-dropdown-list-item">
                        <a href="#">
                          <i class="fa-solid fa-sliders"></i>
                          Settings
                        </a>
                      </li>
            
                      <li class="profile-dropdown-list-item">
                        <a href="#">
                          <i class="fa-regular fa-circle-question"></i>
                          Help & Support
                        </a>
                      </li>
                      <hr />
            
                      <li class="profile-dropdown-list-item">
                        <a href="#">
                          <i class="fa-solid fa-arrow-right-from-bracket"></i>
                          Log out
                        </a>
                      </li>
                    </ul>
                  </div>
            
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

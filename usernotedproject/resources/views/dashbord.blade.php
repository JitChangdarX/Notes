<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dashbord</title>
    <link rel="stylesheet" href="{{ asset('asset/css/dashbord.css') }}">
</head>

<body>

    {{-- // create a logo my notes --}}

    {{-- create a nav bar --}}
    <div class="header">
        <div class="logo-container">
            <div class="logo">
                <a href="{{ route('dashbord') }}">
                    <img src="https://www.gstatic.com/images/branding/product/1x/keep_2020q4_48dp.png" alt="Logo">
                </a>
                <h1>My Notes</h1>
            </div>
        </div>

        <div class="searchbox">
            <form action="" method="get" class="search-box">
                <input type="text" placeholder="Search...">
            </form>
        </div>
    </div>


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

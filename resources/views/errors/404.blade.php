<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('asset/css/404.css') }}">
</head>

<body>
    <div class="background">
        <div class="stars"></div>
        <div class="yarn-container">
            <div class="yarn-ball red"></div>
            <div class="yarn-ball blue"></div>
            <div class="yarn-ball green"></div>
        </div>
        <div class="cat-wrapper">
            <div class="cat">
                <div class="cat-body"></div>
                <div class="cat-head">
                    <div class="eye left"></div>
                    <div class="eye right"></div>
                    <div class="nose"></div>
                    <div class="whisker left"></div>
                    <div class="whisker right"></div>
                </div>
                <div class="bell"></div>
                <div class="paw left"></div>
                <div class="paw right"></div>
                <div class="tail"></div>
            </div>
        </div>
        <div class="number">404</div>
        <div class="yarn-trail"></div>
    </div>
    <div class="content">
        <h1>404</h1>
        <p>Oops! The kitty lost this page!</p>
        <button class="home-button">Back to Home</button>
    </div>
    <script src="{{ asset('asset/js/404.js') }}"></script>
</body>

</html>

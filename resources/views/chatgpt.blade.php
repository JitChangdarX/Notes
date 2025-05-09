<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat with Grok AI | Code with Ross</title>
    <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- End JavaScript -->

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/chat.css') }}">
    <style>
        .message.error p {
            color: red;
            font-style: italic;
        }
    </style>
</head>

<body>
<div class="chat">
    <!-- Header -->
    <div class="top">
        <img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">
        <div>
            <p>Ross Edlin</p>
            <small>Online</small>
        </div>
    </div>
    <!-- End Header -->

    <!-- Chat -->
    <div class="messages">
        <div class="left message">
            <img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">
            <p>Start chatting with Grok AI below!!</p>
        </div>
    </div>
    <!-- End Chat -->

    <!-- Footer -->
    <div class="bottom">
        <form>
            <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
            <button type="submit"></button>
        </form>
    </div>
    <!-- End Footer -->
</div>

<script>
    // Broadcast messages
    $("form").submit(function (event) {
        event.preventDefault();

        // Stop empty messages
        if ($("form #message").val().trim() === '') {
            return;
        }

        // Disable form
        $("form #message").prop('disabled', true);
        $("form button").prop('disabled', true);

        $.ajax({
            url: "/chat",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                content: $("form #message").val()
            }
        }).done(function (res) {
            // Populate sending message
            $(".messages > .message").last().after(
                '<div class="right message">' +
                '<p>' + $('<div>').text($("form #message").val()).html() + '</p>' +
                '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
                '</div>'
            );

            // Populate receiving message
            $(".messages > .message").last().after(
                '<div class="left message">' +
                '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
                '<p>' + $('<div>').text(res).html() + '</p>' +
                '</div>'
            );

            // Cleanup
            $("form #message").val('');
            $(document).scrollTop($(document).height());

            // Enable form
            $("form #message").prop('disabled', false);
            $("form button").prop('disabled', false);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error('API Error:', textStatus, errorThrown, jqXHR.responseJSON);
            // Display error in chat
            $(".messages > .message").last().after(
                '<div class="left message error">' +
                '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
                '<p>Error: ' + (jqXHR.responseJSON?.error || 'Failed to communicate with Grok AI') + '</p>' +
                '</div>'
            );
            $(document).scrollTop($(document).height());

            // Enable form
            $("form #message").prop('disabled', false);
            $("form button").prop('disabled', false);
        });
    });
</script>
</body>
</html>
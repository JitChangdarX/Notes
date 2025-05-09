@php
    $data = $data ?? [];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
   <style>
    body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}
.container {
    max-width: 600px;
    margin: 20px auto;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
}
.header {
    background: #1c1c23;
    color: #ffffff;
    padding: 15px;
    text-align: center;
    border-radius: 8px 8px 0 0;
}
.header h1 {
    margin: 0;
    font-size: 24px;
}
.content {
    padding: 20px;
}
.content p {
    margin: 10px 0;
    line-height: 1.6;
}
.label {
    font-weight: bold;
    color: #1c1c23;
}
.message {
    background: #f9f9f9;
    padding: 15px;
    border-left: 4px solid #1c1c23;
    border-radius: 4px;
}
.footer {
    text-align: center;
    padding: 15px;
    font-size: 12px;
    color: #666;
    border-top: 1px solid #eee;
}
@media only screen and (max-width: 600px) {
    .container {
        width: 100%;
        margin: 10px;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Submission</h1>
        </div>
        <div class="content">
            <p><span class="label">Name:</span> {{ $data['name'] ?? 'Not provided' }}</p>
            <p><span class="label">Email:</span> {{ $data['email'] ?? 'Not provided' }}</p>
            <p><span class="label">Message:</span></p>
            <div class="message">
                <p>{{ $data['message'] ?? 'No message provided' }}</p>
            </div>
        </div>
        <div class="footer">
            <p>This email was sent from your website's contact form.</p>
            <p>© {{ date('Y') }} Your Website. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<link rel="stylesheet" type="text/css" href="{{asset('asset/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
</head>
<body>
    <form action="{{route('forgetpasswordaction')}}" method="post">
		@csrf
     	<h2>Change Password</h2>
     	<label>Old Password</label>
       
     	<input type="password"  name="op" id="password"  placeholder="Old Password" autocomplete="off">
		 <br>
     	<label>New Password</label>
     	<input type="password"  name="np" id="new_password"  placeholder="New Password" id="forgetpassword" autocomplete="off">
     	<br>
     	<label>Confirm New Password</label>
		<input type="password"  name="c_np" id="confirm_password"  placeholder="Confirm New Password" autocomplete="off">
     	<br>
     	<button type="submit">CHANGE</button>  
     </form>
</body>
</html>
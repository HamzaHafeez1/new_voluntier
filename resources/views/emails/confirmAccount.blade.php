<!DOCTYPE html>
<html lang="en">
<head>
    <title>Confirm your account</title>
</head>
<body>
<div style="text-align: center">
    <img src="<?=asset('img/logo/mvlogo.png')?>" style="width: 100px">
    <h2>Welcome to MyVoluntier.com</h2>
    <p>Thank you for signing up for MyVoluntier!</p>
    <p>Please verify your email address by clicking the link below.</p>
    <br/>
    <a href="{{url('/confirm_account')}}/{{$user->user_name}}/{{$user->confirm_code}}">Start MyVoluntier</a>
    <br/>
    <p>Thanks</p>
    <p>support@myvoluntier.com</p>
</div>
</body>
</html>

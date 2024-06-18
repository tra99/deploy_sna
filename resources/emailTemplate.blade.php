<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Send</title>
</head>
<body>
    <h2>{{$data['subject']}} </h2>
    <p>{{$data['body']}}</p>
    <p>OTP code will expire in 1 minute. OTP code <i>{{$data['otp']}}</i></p>
    <h4>{{$data['footer']}}</h4>

</body>
</html>

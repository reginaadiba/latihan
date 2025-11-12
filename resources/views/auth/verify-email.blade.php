<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h2>Hi, your verification link already sent to your email.</h2>
    <br>
    <form action="/email/verification-notification" method="POST">
        @csrf
        <input type="submit" value="Resend Verification Link">
    </form>
</body>
</html>
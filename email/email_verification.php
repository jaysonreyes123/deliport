<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<h1>Hello!</h1>
<p>Please click the button below to verify your email address.</p>

<a href="<?=$base_url."classes/Users.php?f=verify_email&email=".$email."&user_level=".$user_level.""?>">Verify Email Address</a>

</body>
</html>
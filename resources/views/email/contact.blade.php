<!DOCTYPE html>
<html>
<head>
    <title>{{ $mail['object'] }}</title>
</head>
<body>
<h1>{{ $mail['name'] }}</h1>
<h6>from : {{ $mail['email'] }}</h6>
<p>{{ $mail['message'] }}</p>
</body>
</html>

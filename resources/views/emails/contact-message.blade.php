<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Form</title>
</head>
<body>
    <h1>F Multi Stores</h1>
    <p>Name: {{ $contactContent['name'] }}</p>
    <p>Email: {{ $contactContent['email'] }}</p>
    <p>Subject: {{ $contactContent['subject'] }}</p>
    <p>Phone: {{ $contactContent['phone'] }}</p>
    <p>Message: {{ $contactContent['message'] }}</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Users</title>
</head>
<body>
<h1>Second Users</h1>
<ul>
    @foreach ($users as $user)
        <li>{{ $user->first_name }}</li>
    @endforeach
</ul>
</body>
</html>

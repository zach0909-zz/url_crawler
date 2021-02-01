<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Get Links</title>
</head>
<body>
    <h1>FIND ALL LINKS IN URL</h1>
    <form action="{{route('store')}}" method="POST">
        {{csrf_field()}}
        <label>Please insert the entire url, including http://</label>
        <input type="text" name='url'>
        <button type="submit">Submit</button>
    </form>    
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    </head>

    <body>
        <h1>These are the links:</h1>
        @if(count($links))
        <table>
            <thead>
              <tr>
                <th>URLs</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($links as $link)
                <tr>
                    <td>{{$link->id}}</td>
                    <td>{{$link->url}}</td>
                </tr>    
                @endforeach
            </tbody>

        @else 
            <h1>There were no links for the url provided</h1>
        @endif    
</html>
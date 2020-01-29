<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Artisan</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>

        </style>
    </head>
    <body>
        <form action="/artisan" method="post">
          @csrf
          php artisan ...<input type="text" name="command" style="width:100%;">
          <button type="submit">Execute</button>
        <form>
    </body>
</html>

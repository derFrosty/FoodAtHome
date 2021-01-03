<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Food@Home</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/vuetify/dist/vuetify.min.css">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

</head>
<body class="overflow-hidden">
<div class="container" id="app">
</div>
<script src="js/app.js"></script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Shop</title>





    @vite([
            'resources/css/client/client.css',
            'resources/css/client/bootstrap.min.css',
            'resources/css/client/templatemo.css',
            'resources/css/admin/app.css'
            ])
</head>
<body>
<div id="client"></div>
{{--<div id="admin"></div>--}}


@vite(['resources/js/client/client.js'])
@vite(['resources/js/admin/admin.js', 'resources/js/admin/scss/vertical-layout-light/style.scss'])
</body>
</html>

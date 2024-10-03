<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="./public/assets/css/bootstrap.min.css">
    @yield('link')
</head>
<body>
    <div class="container-fluid">
        @include('Components.Nav')
        @yield('content')
    </div>
    @yield('script')
    <script src="./public/assets/js/dangxuat.js"></script>
    <script src="./public/assets/js/popper.min.js"></script>
    <script src="./public/assets/js/bootstrap.min.js"></script>
</body>
</html>
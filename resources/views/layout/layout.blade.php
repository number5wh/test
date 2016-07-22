<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<link rel="stylesheet" href="{{url('css/book.css')}}">
<link rel="stylesheet" href="{{url('css/weui.css')}}">
<body>
@yield('content')
</body>
<script style="text/javascript" src="{{url('js/jquery-1.11.2.min.js')}}"></script>
@yield('js')
</html>
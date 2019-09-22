<html>

<head>
    <title>Laravel | @yield('title','HOME')</title>
</head>

<body>
    @section('sidebar')
    <p>メインのサイドバー（共通部分）</p>
    @show
    <div class="container">
        @yield('content')
    </div>

    @section('footer')
    <script src="app.js"></script>
    @show
</body>

</html>
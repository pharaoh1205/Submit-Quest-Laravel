<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Conduit</title>
    <!-- 安定して動作する Bootstrap 4とIonicons -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:700,600,400,200,800|Source+Serif+Pro:400,700|Merriweather+Sans:400,700|Source+Sans+Pro:400,300,600,700,300italic,400italic,600italic,700italic">
</head>

<body>

    <!-- ヘッダー (全画面共通) -->
    <nav class="navbar navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">conduit</a>
            <ul class="nav navbar-nav pull-xs-right">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="/editor">
                        <i class="ion-compose"></i>&nbsp;New Article
                    </a>
                </li> -->
                
                @auth
                <!-- ログインしている場合のみ表示 -->
                <li class="nav-item">
                    <a class="nav-link" href="">{{ Auth::user()->name }}</a>
                </li>
                <li class="nav-item">
                    <!-- ログアウトボタンなどを置く -->
                </li>
                @else
                <!-- 未ログインの場合に表示 -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('signin') }}">Sign in</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('signup') }}">Sign up</a>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- メインコンテンツ -->
    @yield('content')

    <!-- フッター (全画面共通) -->
    <footer>
        <div class="container">
            <a href="/" class="logo-font">conduit</a>
            <span class="attribution">
                An interactive learning project from <a href="https://thinkster.io">Thinkster</a>. Code &amp; design licensed under MIT.
            </span>
        </div>
    </footer>

</body>

</html>
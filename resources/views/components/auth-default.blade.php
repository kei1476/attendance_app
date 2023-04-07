<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/css/reset.css')  }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css')  }}">
    <link rel="stylesheet" href="{{ asset('/css/auth.css')  }}">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="header-title-area">
                <h1 class="header-title">Atte</h1>
            </div>
        </div>
    </header>
    @yield('content')
    @component('components.user_footer')
    @endcomponent
</body>
</html>

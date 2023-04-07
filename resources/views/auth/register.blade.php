@extends('components.auth-default')
@section('content')
<main>
    <h1 class="register-title">会員登録</h1>
    <div class="register-area">
        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf
            @error('name')
            {{$message}}
            @enderror
            <input type="text" name="name" placeholder="名前">
            @error('email')
            {{$message}}
            @enderror
            <input type="email" name="email" placeholder="メールアドレス">
            @error('password')
            {{$message}}
            @enderror
            <input type="password" name="password" placeholder="パスワード">
            <input type="password" name="password_confirmation" placeholder="確認用パスワード">
            <button>会員登録</button>
        </form>
        <div class="login-link-area">
            <p>アカウントをお持ちの方はこちらから</p>
            <a href="/login">ログイン</a>
        </div>
    </div>
</main>
@endsection

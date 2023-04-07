@extends('components.auth-default')
@section('content')
<main>
    <h1 class="register-title">ログイン</h1>
    <div class="register-area">
        <form method="POST" action="{{ route('login') }}" class="register-form">
            @csrf
            <input type="text" name="email" placeholder="メールアドレス">
            <input type="text" name="password" placeholder="パスワード">
            <button>ログイン</button>
        </form>
        <div class="login-link-area">
            <p>アカウントをお持ちでない方はこちらから</p>
            <a href="/register">会員登録</a>
        </div>
    </div>
</main>
@endsection

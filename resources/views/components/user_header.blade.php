<header>
    <div class="header-content">
        <div class="header-title-area">
            <h1 class="header-title">Atte</h1>
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="/stamp" class="header-page-link">ホーム</a></li>
                <li><a href="/attendances" class="header-page-link">日付一覧</a></li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="logout-btn">ログアウト</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</header>

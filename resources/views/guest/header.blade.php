<header>
    <nav class="navbar navbar-expand-sm navbar-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home')  }}">Mardikor</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guest.mardikor') }}">Мардикорам</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guest.search_vacancy') }}">Соискателям</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guest.search_resume') }}">Работодателям</a>
                    </li>
                    <li><a class="nav-link" href="{{ route('login') }}">Войти</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">Регистрация</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
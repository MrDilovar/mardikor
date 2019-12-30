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
                        <a class="nav-link" href="{{ route('applicant.negotiation.index') }}">
                            Отклики
                            <span class="badge badge-pill badge-dark">{{ session('notifications') }}</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                            {{ Auth::user()->email }}
                        </a>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href={{ route('applicant.resume.index') }}>
                                Мои резюме
                            </a>
                            <a class="dropdown-item" href={{ route('applicant.settings.applicant.index') }}>
                                Настройки
                            </a>
                            <hr class="m-2">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                Выход
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
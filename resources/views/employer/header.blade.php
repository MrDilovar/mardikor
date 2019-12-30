<header>
    <nav class="navbar navbar-expand-sm navbar-dark border-bottom bg-dark">
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
                        <a class="nav-link" href="{{ route('guest.search_resume') }}">Работодателям</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employer.negotiation.index') }}">
                            Отклики
                            <span class="badge badge-pill badge-light">{{ session('notifications') }}</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                            {{ Auth::user()->email }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-item text-muted">
                                {{ Auth::user()->data->brand }} – клиент {{ Auth::user()->data->id }}
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('employer.vacancy.index') }}">
                                Вакансии
                            </a>
                            <a class="dropdown-item" href="{{ route('employer.settings.index') }}">
                                Настройки
                            </a>
                            <div class="dropdown-divider"></div>
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
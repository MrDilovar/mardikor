@extends('layout')
@section('content')
    <div class="container">
        <h4 class="my-4 text-center text-lg-left">Найдено {{ $vacancies->total() }} вакансий</h4>
        <div class="row">
            <div class="col-lg-3 mb-3">
                <div class="searp-filter border text-center rounded d-block d-lg-none">
                    <div class="searp-filter-title">
                        <span>Фильтры <span class="badge badge-pill badge-dark">{{ count(array_diff_key(request()->query(), ['search'=>old('search') ? old('search') : request()->search, 'page'=>request()->page])) }}</span></span>
                        <span class="searp-filter-expander">
                            <span class="searp-filter-expander-icon up"></span>
                        </span>
                    </div>
                </div>
                <div class="search-preference d-none d-lg-block">
                    <div class="search-preference-item {{ !is_null($selected_specialization) ? '': 'search-preference-item-collapse' }}">
                        <div class="searp-item-title">
                            Специализация
                            <span class="searp-item-title-expander">
                                <span class="searp-item-title-expander-icon {{ !is_null($selected_specialization) ? 'down': 'up' }}"></span>
                            </span>
                        </div>
                        @if(!is_null($selected_specialization))
                            <ul class="searp-item-list">
                                <li class="searp-list-item">
                                    <a class="searp-value searp-value-selected" href="{{ "?" . http_build_query(array_diff_key(request()->merge(['page'=>1])->query(), ['specialization'=>$selected_specialization->id])) }}">
                                        <span class="searp-value-name">{{ $selected_specialization->name }}</span>
                                        <span class="searp-value-close">
                                            <span class="searp-value-close-icon">
                                                <span class="searp-value-close-icon-cancel"></span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        @else
                            <ul class="searp-item-list" style="display: none;">
                                @foreach($specializations as $specialization)
                                    @if(request()->specialization == $specialization->id)
                                        @continue
                                    @endif
                                    <li class="searp-list-item">
                                        <a class="searp-value" href="{{ request()->merge(['page'=>1])->fullUrlWithQuery(['specialization'=>$specialization->id]) }}">
                                            <span class="searp-value-name">{{ $specialization->name }}</span>
                                            <span class="searp-value-count">{{ $specialization->vacancies }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="search-preference-item {{ !is_null($selected_city) ? '': 'search-preference-item-collapse' }}">
                        <div class="searp-item-title">
                            Город
                            <span class="searp-item-title-expander">
                                <span class="searp-item-title-expander-icon {{ !is_null($selected_city) ? 'down': 'up' }}"></span>
                            </span>
                        </div>
                        @if(!is_null($selected_city))
                            <ul class="searp-item-list">
                                <li class="searp-list-item">
                                    <a class="searp-value searp-value-selected" href="{{ "?" . http_build_query(array_diff_key(request()->merge(['page'=>1])->query(), ['city'=>$selected_city->id])) }}">
                                        <span class="searp-value-name">{{ $selected_city->name }}</span>
                                        <span class="searp-value-close">
                                            <span class="searp-value-close-icon">
                                                <span class="searp-value-close-icon-cancel"></span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        @else
                            <ul class="searp-item-list" style="display: none;">
                                @foreach($cities as $city)
                                    @if(request()->city == $city->id)
                                        @continue
                                    @endif
                                    <li class="searp-list-item">
                                        <a class="searp-value" href="{{ request()->merge(['page'=>1])->fullUrlWithQuery(['city'=>$city->id]) }}">
                                            <span class="searp-value-name">{{ $city->name }}</span>
                                            <span class="searp-value-count">{{ $city->vacancies }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="search-preference-item">
                        <div class="searp-item-title">
                            Зарплата
                            <span class="searp-item-title-expander">
                                <span class="searp-item-title-expander-icon down"></span>
                            </span>
                        </div>
                        @if(!is_null($selected_salary))
                            <ul class="searp-item-list">
                                <li class="searp-list-item">
                                    <a class="searp-value searp-value-selected" href="{{ "?" . http_build_query(array_diff_key(request()->merge(['page'=>1])->query(), ['salary'=>$selected_salary->id])) }}">
                                        <span class="searp-value-name">{{ $selected_salary->name }}</span>
                                        <span class="searp-value-close">
                                            <span class="searp-value-close-icon">
                                                <span class="searp-value-close-icon-cancel"></span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        @else
                            <ul class="searp-item-list">
                                @foreach($salaries as $salary)
                                    @if(request()->salary == $salary->id)
                                        @continue
                                    @endif
                                    <li class="searp-list-item">
                                        <a class="searp-value" href="{{ request()->merge(['page'=>1])->fullUrlWithQuery(['salary'=>$salary->id]) }}">
                                            <span class="searp-value-name">{{ $salary->name }}</span>
                                            <span class="searp-value-count">{{ $salary->vacancies }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="search-preference-item">
                        <div class="searp-item-title">
                            Опыт работы
                            <span class="searp-item-title-expander">
                                <span class="searp-item-title-expander-icon down"></span>
                            </span>
                        </div>
                        @if(!is_null($selected_vacancy_experience))
                            <ul class="searp-item-list">
                                <li class="searp-list-item">
                                    <a class="searp-value searp-value-selected" href="{{ "?" . http_build_query(array_diff_key(request()->merge(['page'=>1])->query(), ['vacancy_experience'=>$selected_vacancy_experience->id])) }}">
                                        <span class="searp-value-name">{{ $selected_vacancy_experience->name }}</span>
                                        <span class="searp-value-close">
                                            <span class="searp-value-close-icon">
                                                <span class="searp-value-close-icon-cancel"></span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        @else
                            <ul class="searp-item-list">
                                @foreach($vacancy_experiences as $vacancy_experience)
                                    @if(request()->vacancy_experience == $vacancy_experience->id)
                                        @continue
                                    @endif
                                    <li class="searp-list-item">
                                        <a class="searp-value" href="{{ request()->merge(['page'=>1])->fullUrlWithQuery(['vacancy_experience'=>$vacancy_experience->id]) }}">
                                            <span class="searp-value-name">{{ $vacancy_experience->name }}</span>
                                            <span class="searp-value-count">{{ $vacancy_experience->vacancies }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div>
                    <form action="{{ route('guest.search_vacancy') }}" method="get">
                        <div class="row no-gutters">
                            <div class="col mr-3">
                                <input class="form-control form-control-sm" name="search" type="text" value="{{ old('search') ? old('search') : request()->search }}" >
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-primary">Найти</button>
                            </div>
                        </div>
                        <small class="d-none d-md-block"><b>Например:</b> Стажер в отдел продаж, Младший специалист технического отдела, Курьер</small>
                    </form>
                </div>
                <hr>
                <div>
                    @foreach($vacancies as $vacancy)
                        <div class="border px-3 py-2 mb-3">
                            <div class="row no-gutters">
                                <div>
                                    <a href="{{ route('guest.vacancy', $vacancy->id) }}">{{ $vacancy->name }}</a>
                                </div>
                                <div class="ml-auto">
                                    @isset($vacancy->compensation_from_visible)
                                        от {{ $vacancy->compensation_from_visible }}
                                    @endisset
                                    @isset($vacancy->compensation_to_visible)
                                        до {{ $vacancy->compensation_to_visible }}
                                    @endisset
                                    @if($vacancy->compensation_from_visible || $vacancy->compensation_to_visible)
                                        сом.
                                    @else
                                        з/п не указана
                                    @endif
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center mt-2">
                                <div class="col">
                                    <span class="small">{{ $vacancy->employer->brand }} г. {{ $vacancy->city->name }}</span>
                                    <div>{{ $vacancy->specialization->name }}</div>
                                </div>
                                @if(!is_null($vacancy->employer->photo))
                                    <div class="ml-auto my-2">
                                        <div>
                                            <img style="max-width: 70px;" src="/{{$PATH_TO_EMPLOYER_PHOTO . $vacancy->employer->photo }}" alt="...">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row no-gutters mt-2">
                                <div>
                                    @can('is_applicant')
                                        @if ($vacancy->responded())
                                            @if($vacancy->responded->hasStatus('invite'))
                                                <a class="text-success" href="{{ route('applicant.negotiation.show', $vacancy->responded->id) }}">{{ $vacancy->responded->status->name }}</a>
                                            @elseif($vacancy->responded->hasStatus('discard'))
                                                <a class="text-danger" href="{{ route('applicant.negotiation.show', $vacancy->responded->id) }}">{{ $vacancy->responded->status->name }}</a>
                                            @else
                                                <a class="text-secondary" href="{{ route('applicant.negotiation.show', $vacancy->responded->id) }}">{{ $vacancy->responded->status->name }}</a>
                                            @endif
                                        @else
                                            <a class="text-secondary" href="{{ route('applicant.negotiation.respond.show', $vacancy->id) }}">Откликнуться</a>
                                        @endif
                                    @endcan

                                    @guest
                                        <a class="text-secondary" href="{{ route('applicant.negotiation.respond.show', $vacancy->id) }}">Откликнуться</a>
                                    @endguest
                                </div>
                                <div class="ml-auto">
                                    {{ $vacancy->get_created_at() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
                <div class="ml-auto small">{{ $vacancies->appends(request()->input())->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
    <script>
        $('.search-preference-item').click(function (e) {
            let expanderIcon = $('.searp-item-title-expander-icon', this),
                ItemList = $('.searp-item-list', this),
                target = $(e.target),
                self = $(this);

            if  (target.hasClass('searp-item-title') || target.hasClass('searp-item-title-expander-icon')) {
                if(expanderIcon.hasClass('up')) {
                    expanderIcon.removeClass('up');
                    expanderIcon.addClass('down');
                    ItemList.slideDown(200);
                    self.removeClass('search-preference-item-collapse');
                } else if(expanderIcon.hasClass('down')) {
                    expanderIcon.removeClass('down');
                    expanderIcon.addClass('up');
                    ItemList.slideUp(200);
                    self.addClass('search-preference-item-collapse');
                }
            }
        });
        $('.searp-filter').click(function (e) {
            let self = $(this),
                searchPreference = $('.search-preference'),
                expanderIcon = $('.searp-filter-expander-icon');

            if(expanderIcon.hasClass('up')) {
                expanderIcon.removeClass('up');
                expanderIcon.addClass('down');
                searchPreference.removeClass('d-none');
                searchPreference.slideDown(200);
            } else if(expanderIcon.hasClass('down')) {
                expanderIcon.removeClass('down');
                expanderIcon.addClass('up');
                searchPreference.slideUp(200);
            }
        });
    </script>
@endsection
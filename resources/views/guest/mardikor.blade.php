@extends('layout')
@section('content')
    <div class="container">
        <div class="row mt-3 align-items-center">
            <div class="col-auto"><h4 class="font-weight-light">Найдено: {{ $mardikors->count() }}</h4></div>
            <div class="col-auto ml-0 ml-sm-auto d-flex">
                <div>
                    @if(is_null($selected_city))
                        <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle" data-toggle="collapse" data-target="#collapseMardikor" aria-expanded="false" aria-controls="collapseMardikor">Выбрать город</button>
                    @else
                        <a class="btn btn-sm btn-outline-dark d-flex justify-content-between" href="{{ "?" . http_build_query(array_diff_key(request()->merge(['page'=>1])->query(), ['city'=>$selected_city->id])) }}">
                            <div class="mr-1">
                                {{ $selected_city->name }}
                            </div>
                            <div>
                                <span class="badge badge-pill badge-dark">&minus;</span>
                            </div>
                        </a>
                    @endif
                </div>
                <div class="ml-2">
                    <a href="{{ route('guest.mardikor.create') }}" class="btn btn-sm btn-outline-primary">Подать объявление</a>
                </div>
            </div>
        </div>
        @if(is_null($selected_city))
            <div class="collapse" id="collapseMardikor">
                <hr>
                <div class="row no-gutters justify-content-between">
                    @foreach($cities as $city)
                        <a href="{{ request()->merge(['page'=>1])->fullUrlWithQuery(['city'=>$city->id]) }}" class="btn btn-sm btn-outline-dark d-flex justify-content-between m-2">
                            <div class="mr-1">{{ $city->name }}</div>
                            <div><span class="badge badge-pill badge-dark">{{ $city->mardikors }}</span></div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="row mt-3">
            @foreach($mardikors as $mardikor)
                <div class="col-md-6">
                    <div class="border px-3 py-2 mb-3">
                        <a href="{{ route('guest.mardikor.show', $mardikor->id) }}">{{ $mardikor->title }}</a>
                        <div class="font-weight-bold">
                            @if(!is_null($mardikor->salary))
                                {{ $mardikor->salary }} сомони
                            @else
                                з/п не указана
                            @endif
                        </div>
                        <p class="small mb-2">{!! $mardikor->description !!}</p>
                        <div class="row no-gutters">
                            <div>
                                <a class="text-secondary" href="{{ request()->fullUrlWithQuery(['city'=>$mardikor->city->id]) }}">{{ $mardikor->city->name }}</a>
                            </div>
                            <div class="ml-auto">
                                {{ $mardikor->get_created_at() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-auto ml-auto">
                <div class="small">{{ $mardikors->appends(request()->input())->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
@endsection
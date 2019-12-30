@extends('layout')
@section('content')
    <div class="container">
        <h3 class="font-weight-light my-4">Отклики и приглашения</h3>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="d-none d-md-block">
            <div class="row">
                <div class="col-md-4"><h5>Резюме</h5></div>
                <div class="col-md-6"><h5>Вакансия</h5></div>
                <div class="col-md-2"><h5>Дата</h5></div>
            </div>
        </div>
        @foreach($negotiations as $negotiation)
            <div class="p-2 {{ $negotiation->vacancy_notification == 'on' ? 'border bg-light' : 'border-top' }}">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('employer.negotiation.show', $negotiation->id) }}" class="text-dark">
                            {{ $negotiation->resume->applicant->first_name }}
                            {{$negotiation->resume->applicant->last_name}}
                        </a>
                        –
                        <a href="{{ route('guest.resume', $negotiation->resume->id) }}">
                            {{ $negotiation->resume->title }}
                        </a>
                        <div class="my-1">
                            @if($negotiation->status->id == 3 || $negotiation->status->id == 4)
                                <span class="font-weight-bold">{{ $negotiation->status->name }}</span>
                                –
                                <a href="{{ route('employer.negotiation.cancel', $negotiation->id) }}" class="text-success">Отменить</a>
                            @else
                                <a href="{{ route('employer.negotiation.discard.show', $negotiation->id) }}" class="text-danger">Отказ</a>
                                –
                                <a href="{{ route('employer.negotiation.invite.show', $negotiation->id) }}" class="text-success">Приглашение</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('guest.vacancy', $negotiation->vacancy->id) }}">{{ $negotiation->vacancy->name }}</a>
                    </div>
                    <div class="col-md-2">
                        {{ $negotiation->date }}
                        <div class="mt-2">
                            <form class="d-inline" action="{{ route('employer.negotiation.destroy', $negotiation->id)}}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete" />
                                <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

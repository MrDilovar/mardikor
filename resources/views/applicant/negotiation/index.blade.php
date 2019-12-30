@extends('layout')
@section('content')
    <div class="container">
        <h3 class="font-weight-light my-4">Отклики и приглашения</h3>
        @if(session()->get('success'))
            <div class="alert alert-success small">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="d-none d-md-block">
            <div class="row">
                <div class="col-md-4"><h5>Статус</h5></div>
                <div class="col-md-6"><h5>Вакансия</h5></div>
                <div class="col-md-2"><h5>Дата</h5></div>
            </div>
        </div>
        @foreach($negotiations as $negotiation)
        <div class="p-2 {{ $negotiation->resume_notification == 'on' ? 'border bg-light' : 'border-top' }}">
            <div class="row">

                <div class="col-md-4">
                    @if($negotiation->status->id == 3)
                        <a class="text-success font-weight-bold" href="{{ route('applicant.negotiation.show', $negotiation->id) }}">{{ $negotiation->status->name }}</a>
                    @elseif($negotiation->status->id == 4)
                        <a class="text-danger font-weight-bold" href="{{ route('applicant.negotiation.show', $negotiation->id) }}">{{ $negotiation->status->name }}</a>
                    @else
                        <a class="text-secondary" href="{{ route('applicant.negotiation.show', $negotiation->id) }}">{{ $negotiation->status->name }}</a>
                    @endif
                </div>
                <div class="col-md-6">
                    <a href="{{ route('guest.vacancy', $negotiation->vacancy->id) }}">{{ $negotiation->vacancy->name }}</a>
                    <div>в <a class="text-secondary" href="{{ route('guest.employer', $negotiation->vacancy->employer->id) }}">{{ $negotiation->vacancy->employer->brand }}</a></div>
                </div>
                <div class="col-md-2">
                    {{ $negotiation->date }}
                    <div class="mt-2">
                        <form class="d-inline" action="{{ route('applicant.negotiation.destroy', $negotiation->id)}}" method="post">
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

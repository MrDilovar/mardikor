@extends('layout')
@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success mt-4">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="mt-4">
            <h3 class="font-weight-normal">{{ $mardikor->title }}</h3>
            <span class="font-weight-bold text-success">
                @if(!is_null($mardikor->salary))
                    {{ $mardikor->salary }} сомони
                @else
                    з/п не указана
                @endif
            </span>
        </div>
        <h5 class="mt-3">{{ $mardikor->employer_name }}</h5>
        <div class="mt-2">{!! $mardikor->description !!}</div>
        <div class="mt-2">
            <button class="btn btn-sm btn-outline-primary" id="showNumber" data-number="{{ $mardikor->phone }}">Показать телефон</button>
        </div>
        <div class="mt-4">
            <span class="font-italic font-weight-bold">
                Вакансия опубликована <span class="text-lowercase">{{ $mardikor->get_created_at() }}</span>
                <br>
                г. {{ $mardikor->city->name }}
            </span>
        </div>
    </div>
    <script>
        $(function () {
            let showNumber = $('#showNumber'),
            number = showNumber.data().number,
            defaultText = showNumber.text();

            showNumber.click(function () {
                let self = $(this);
                if(self.hasClass('show')) self.removeClass('show').text(defaultText);
                else self.addClass('show').text(number);
            });
        });
    </script>
@endsection
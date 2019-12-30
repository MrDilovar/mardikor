@extends('layout')
@section('content')
    <div class="container">
        <h3 class="font-weight-light my-4">Отправить отклик на резюме</h3>
        <div>
            <a class="text-secondary" href="{{ route('guest.resume', $negotiation->resume->id) }}">{{ $negotiation->resume->title }}</a>
            в вакансию
            <a href="{{ route('guest.vacancy', $negotiation->vacancy->id) }}">{{ $negotiation->vacancy->name }}</a>
        </div>
        <div class="row mt-4">
            <div class="col-8">
                @if(!is_null($negotiation->resume_letter))
                    <div class="row">
                        <div class="col-md-8">
                            <div class="bg-light small p-3">
                                {!! $negotiation->resume_letter !!}
                            </div>
                            <div class="mt-2 text-muted small">
                                <span>Соискатель</span><br>
                                <span>{{ $negotiation->date }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row mt-3">
                    <div class="col-md-8 offset-md-2">
                        <form id="form_invite" action="{{ route('employer.negotiation.invite.store', $negotiation->id) }}" method="post">
                            {{ csrf_field() }}

                            <div class="mb-1 text-danger">Сопроводительное письмо</div>
                            <div class="form-group">
                                <input type="hidden" name="letter">
                                <div id="letter_editor" class="h-auto" style="min-height: 100px;">
                                    <p>Здравствуйте, {{ $negotiation->resume->applicant->first_name . ' ' . $negotiation->resume->applicant->last_name }}!</p>
                                    <p>Благодарим Вас за отклик на вакансию "{{ $negotiation->vacancy->name }}".</p>
                                    <p>Приглашаем Вас на встречу в офис нашей Компании по адресу г. {{ $negotiation->vacancy->employer->city->name }}, {{ $negotiation->vacancy->employer->address }}.</p>
                                    <p>Для подтверждения своей заинтересованности перезвоните, пожалуйста, в рабочее время по телефону {{ $negotiation->vacancy->employer->phone }}.</p>
                                    <p>С уважением, {{ $negotiation->vacancy->employer->brand }}.</p>
                                </div>
                            </div>
                            <div class="form-group my-4">
                                <button type="submit" class="btn btn-sm btn-success w-25">Приглашение</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        new Quill('#letter_editor', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': '' }, { 'align': 'center' }, { 'align': 'right' }],
                ]
            },
            theme: 'snow'
        });

        $('#form_invite').submit(function() {
            $('input[name=letter]').val($('#letter_editor .ql-editor').html());
        });
    </script>
@endsection
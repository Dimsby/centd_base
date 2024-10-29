@extends('layouts.publicbase')

@php
    $arr = range(1870, 1950);
    $originYears = array_combine($arr, $arr);
    $originYears = ['' => '-'] + $originYears;
    $arr = range(1988, date('Y'));
    $foundYears = array_combine($arr, $arr);
    $foundYears = ['' => '-'] + $foundYears;
@endphp

@section('js')
    <script src="{{ asset('js/publicpages/person/index.js?v=4') }}" defer></script>
@endsection

@section('content-header')

@endsection

@section('content')
    <div class="row justify-content-center">

        <div class="col-12">
                    {{ Form::open(['method' => 'get', 'class' => '', 'id' => 'formFilter']) }}
                        <div class="form-row">

                            <div class="form-group col-sm-3 col-12">
                                <label>Фамилия</label>
                                {{ Form::Text('surname', Request::old('surname'), ['class' => 'form-control', 'id' => 'surname']) }}
                            </div>

                            <div class="form-group col-sm-3 col-12">
                                <label>Имя</label>
                                {{ Form::Text('name', Request::old('name'), ['class' => 'form-control', 'id' => 'name']) }}
                            </div>

                            <div class="form-group col-auto">
                                <label>Год рождения</label>
                                {{ Form::select('year', $originYears, Request::old('year'), ['class' => 'form-control', 'id' => 'year']) }}
                            </div>

                            <div class="form-group col-auto">
                                <label>Год обнаружения</label>
                                {{ Form::select('foundat', $foundYears, Request::old('foundat'), ['class' => 'form-control', 'id' => 'foundat']) }}
                            </div>

                            <div class="form-group col-auto">
                                <label>&nbsp;</label>
                                {{ Form::submit('Поиск', ['class' => 'form-control btn btn-secondary']) }}
                            </div>

                            <div class="form-group col-auto">
                                <label>&nbsp;</label>
                                <a href="/base" class="form-control btn material-icons">clear</a>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-auto">
                                {{ $persons->links() }}
                            </div>
                        </div>
                    {{ Form::close() }}

                    @if ($persons->first())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ФИО</th>
                                <th>Год Рождения</th>
                                <th>Год Обнаружения</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($persons as $person)
                                <tr>
                                    <td><a href="{{route('search', ['id' => $person->id ])}}">{{ $person->last_name }} {{ $person->first_name }} {{ $person->sur_name }}</a></td>
                                    <td>{{ $person->origin_year ?: '-' }}</td>
                                    <td>{{ $person->found_date?date('Y', strtotime($person->found_date)):'' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Записей не найдено</p>
                    @endif
            </div>
        </div>
@endsection

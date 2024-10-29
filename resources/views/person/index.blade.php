@extends('layouts.inner')

@php
    $arr = range(1870, 1950);
    $originYears = array_combine($arr, $arr);
    $originYears = ['' => '-'] + $originYears;
    $arr = range(1988, date('Y'));
    $foundYears = array_combine($arr, $arr);
    $foundYears = ['' => '-'] + $foundYears;
@endphp

@section('js')
    <script src="{{ asset('js/pages/person/index.js?v=4') }}" defer></script>
@endsection

@section('content-header')
    <h1>Архив</h1>
@endsection

@section('content')

    <div class="card">

        <div class="card-header">
            {{ Form::open(['method' => 'get', 'class' => '', 'id' => 'formFilter']) }}

                <div class="form-row">

                    <div class="form-group col-3">
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

                    @if(Auth::user()->isAdmin())
                        <div class="form-group col-auto">
                        <label>Добавлено</label>
                        {{ Form::select('user', $users, Request::old('user'), ['class' => 'form-control ', 'id' => 'user']) }}
                        </div>

                        <div class="form-group col-auto">
                            <label>&nbsp;</label>
                            {{ Form::select('filter_is_published', ['' => 'Все записи', 0 => 'Не опубликованные', 1 => 'Опубликованные'], Request::old('filter_is_published'), ['class' => 'form-control', 'id' => 'filter_is_published']) }}
                        </div>
                    @endif

                </div>

                <div class="form-row">
                    <div class="col-auto">
                        {{ $persons->links() }}
                    </div>
                </div>

            {{ Form::close() }}
        </div>

        <div class="card-body">

           @if ($persons->first())
           <table class="table">
               <thead>
                   <tr>
                       <th>#</th>
                       <th>ФИО</th>
                       <th>Ранг</th>
                       <th>Год<br/>Рождения</th>
                       <th>Год<br/>Обнаружения</th>
                       @if(Auth::user()->isAdmin())
                        <th>Создан</th>
                        <th>Опубликовано</th>
                       @endif
                       <th></th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($persons as $person)
                        @if(Auth::user()->isAdmin() || $person->author_id == Auth::user()->id || $person->is_published)
                            <tr data-id="{{ $person->id }}" @if(!$person->is_published)class="table-danger"@endif>
                                <td>{{ $person->id }}</td>
                                <td>{{ $person->last_name }} {{ $person->first_name }} {{ $person->sur_name }}</td>
                                <td>{{ $person->military_rank }}</td>
                                <td>{{ $person->origin_year ?: '-' }}</td>
                                <td>{{ $person->found_date?date('Y', strtotime($person->found_date)):'' }}</td>
                                @if(Auth::user()->isAdmin())
                                    <td>
                                        @if(isset($person->author)) 
                                            {{ $person->author->name }}
                                        @else
                                            автор удален
                                        @endif 
                                            <br/><small>{{$person->created_at}}</small>
                                    </td>
                                    <td><input type="checkbox" name="isPublished" value="1" @if($person->is_published) checked @endif /></td>
                                @endif
                                <td>
                                    @if(Auth::user()->isAdmin() || Auth::user()->id == $person->author_id)
                                    <a href="{{ route('person.edit', $person->id) }}"><i class="material-icons" title="редактировать">create</i></a>
                                    <a href="#" name="lnkDelete"><i class="material-icons" title="удалить">delete</i></a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            @else
               <p>Записей не найдено</p>
            @endif

        </div>
    </div>


@endsection
	
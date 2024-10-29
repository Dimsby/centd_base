@extends('layouts.inner')

@section('js')
    <script src="{{ asset('js/pages/user/index.js') }}" defer></script>
@endsection

@section('content-header')
    <h1>Пользователи</h1>
@endsection

@section('content')

    <div class="row">

        <div class="col-8">

            <div class="card">
                <div class="card-body">

                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Администратор</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>@if($user->id != 1)<input type="checkbox" name="checkAdmin" value="1" @if($user->isAdmin())checked @endif />@else да @endif</td>
                                <td>@if($user->id != 1)<a href="#" name="lnkDelete"><i class="material-icons" title="удалить">delete</i></a> @endif</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>

        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Добавить
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'user.store', 'id' => 'userForm', '@submit.prevent' => 'onSubmit']) }}

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        {{ Form::Text('name', Request::old('name'), ['class' => 'form-control', 'placeholder' => 'Имя']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::Email('email', Request::old('email'), ['class' => 'form-control', 'placeholder' => 'Почта']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Пароль']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::password('password2',  ['class' => 'form-control', 'placeholder' => 'Повторить пароль']) }}
                    </div>
                    <div class="form-group form-check">
                        <input name="is_admin" value="1" type="checkbox" class="form-check-input" id="userCheck">
                        <label class="form-check-label" for="userCheck">Администратор</label>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">Сохранить</button>

                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </div>


@endsection

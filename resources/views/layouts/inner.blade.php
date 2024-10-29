<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Центрдолг - Редактор БД</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <script src="{{ asset('js/init.js') }}" defer></script>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>

<div id="app" class="wrapper">

    <loader :is-visible="isLoading"></loader>

    <nav id="sidebar">

        <ul class="list-unstyled">
            <li>
                <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" >{{ Auth::user()->name }}</a>
                <ul class="collapse list-unstyled" id="userSubmenu">
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#personsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" >Архив</a>
                <ul class="collapse list-unstyled" id="personsSubmenu">
                    <li>
                        <a href="/base/public/person">Список</a>
                    </li>
                    <li>
                        <a href="/base/public/person/create">Добавить</a>
                    </li>
                </ul>
            </li>
            @if(Auth::user()->isAdmin())
                <li>
                    <a href="{{route('user.index')}}">Пользователи</a>
                </li>
            @endif
        </ul>

    </nav>

    <div id="content">
        <div class="container-fluid">
            @yield('content-header')
            @yield('content')
        </div>
    </div>

</div>

    @yield('js')
</body>
</html>

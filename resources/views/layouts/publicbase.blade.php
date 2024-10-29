<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

{{--<script src="{{ asset('js/init.js') }}" defer></script>--}}

 <!-- Styles -->
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link href="{{ asset('css/papp.css') }}" rel="stylesheet">
 @yield('css')
</head>
<body>

<div id="app">

 <loader :is-visible="isLoading"></loader>

 <div class="header" onclick="window.location='/base'">
     <div class="header-content"></div>
 </div>

 <div class="content-wrapper">
     <div class="content container-lg">
         <div class="content-header">
             @yield('content-header')
         </div>
         <div class="content-body">
             @yield('content')
         </div>
     </div>
 </div>

 <div class="footer">
     <div class="container-lg mt-5">
         <p>Всего записей в базе: @php echo \Cache::get('totalPublishedPersons') @endphp</p>
         <p><a href="http://центр-долг.рф">Смоленская областная общественная организация «Поисковое объединение «Долг»</a></p>
     </div>
 </div>

</div>

@yield('js')
{{--<script src="{{ asset('js/app.js') }}" defer></script>--}}
</body>
</html>

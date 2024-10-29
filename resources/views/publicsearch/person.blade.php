@extends('layouts.publicbase')


@section('js')
@endsection

@section('content-header')
    <div class="clearfix">
        <h1 class="float-left">{{ $person->last_name }} {{ $person->first_name }} {{ @$person->sur_name }}</h1>
        <button onclick="window.print()" class="btn material-icons float-right">print</button>
    </div>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    Сведения о рождении
                </div>

                <div class="card-body">

                    <dl class="row">
                        <dt class="col-sm-4">Год</dt>
                        <dd class="col-auto">{{$person->origin_year?:'-'}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Месяц</dt>
                        <dd class="col-auto">{{$person->origin_month?:'-'}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">День</dt>
                        <dd class="col-auto">{{$person->origin_day?:'-'}}</dd>
                    </dl>

                    <hr/>

                    <dl class="row">
                        <dt class="col-sm-4">Республика</dt>
                        <dd class="col-auto">
                            {{$person->origin_republic?:'-'}}
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Область (край)</dt>
                        <dd class="col-auto">
                            {{$person->origin_region?:'-'}}
                        </dd>
                    </dl>

                    @if (!$person->origin_city_checkbox)
                        <dl class="row">
                            <dt class="col-sm-4">Город</dt>
                            <dd class="col-auto">
                                {{$person->origin_city?:'-'}}
                            </dd>
                        </dl>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-4">Район</dt>
                        <dd class="col-auto">
                            {{$person->origin_area?:'-'}}
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Населенный пункт</dt>
                        <dd class="col-sm-8">
                            {{$person->origin_place?:'-'}}
                        </dd>
                    </dl>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    Сведения о семье
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Республика</dt>
                        <dd class="col-auto">
                            {{$person->family_republic?:'-'}}
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Область (край)</dt>
                        <dd class="col-auto">
                            {{$person->family_region?:'-'}}
                        </dd>
                    </dl>

                    @if(!$person->family_city_checkbox)
                        <dl class="row">
                            <dt class="col-sm-4">Город</dt>
                            <dd class="col-auto">
                                {{$person->family_city?:'-'}}
                            </dd>
                        </dl>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-4">Район</dt>
                        <dd class="col-auto">
                            {{$person->family_area?:'-'}}
                        </dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Населенный пункт</dt>
                        <dd class="col-sm-8">
                            {{$person->family_place?:'-'}}
                        </dd>
                    </dl>

                    @if(!$person->family_other_checkbox)
                        <dl class="row">
                            <dt class="col-sm-4">Улица/Дом/Иное</dt>
                            <dd class="col-sm-8">
                                {{$person->family_other?:'-'}}
                            </dd>
                        </dl>
                    @endif

                    <hr/>

                    Родственники @if(!$person->relatives_found) не @endif найдены

                </div>

            </div>

        </div>


    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    Найден
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Дата</dt>
                        <dd class="col-auto">{{$person->found_date_formatted ?: '-'}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Область (край)</dt>
                        <dd class="col-auto">{{$person->found_region?:'-'}}</dd>
                    </dl>
                    @if(!$person->found_city_checkbox)
                        <dl class="row">
                            <dt class="col-sm-4">Район</dt>
                            <dd class="col-sm-8">{{$person->found_city?:'-'}}</dd>
                        </dl>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-4">Село/Поселение</dt>
                        <dd class="col-sm-8">{{$person->found_place?:'-'}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Местоположение</dt>
                        <dd class="col-sm-8">{{$person->found_coords?:'-'}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Поисковый отряд</dt>
                        <dd class="col-sm-8">{{$person->found_unit?:'-'}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Местонахождение отряда</dt>
                        <dd class="col-sm-8">{{$person->found_unit_address?:'-'}}</dd>
                    </dl>

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Перезахоронен
                </div>
                <div class="card-body">

                    <dl class="row">
                        <dt class="col-sm-4">Дата</dt>
                        <dd class="col-sm-8">{{$person->burial_date_formatted?:'-'}}</dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-4">Место</dt>
                        <dd class="col-sm-8">{{$person->burial_address?:'-'}}</dd>
                    </dl>

                </div>
            </div>

            @if (@$person->immortalization)
                <div class="card">
                    <div class="card-header">
                        Сведения об увековечении
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Дата</dt>
                            <dd class="col-auto">{{$person->immortalization->date ? \Carbon\Carbon::parse($person->immortalization->date)->format('Y-m-d') : '-'}}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Дата</dt>
                            <dd class="col-auto">{{$person->immortalization->place ?? '-'}}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-4">Организация</dt>
                            <dd class="col-auto">{{$person->immortalization->organization ?? '-'}}</dd>
                        </dl>
                        @if (@$person->immortalization->additional)
                            <p>{{$person->immortalization->additional}}</p>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    Сведения о призыве
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Каким ВК</dt>
                        <dd class="col-auto">{{$person->service_vk?:'-'}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-4">Год</dt>
                        <dd class="col-auto">{{$person->service_year?:'-'}}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Сведения о выбытии
                </div>
                <div class="card-body">
                    @if(!$person->end_year_checkbox)
                        <dl class="row">
                            <dt class="col-sm-4">Год</dt>
                            <dd class="col-auto">{{$person->end_year?:'-'}}</dd>
                        </dl>
                    @endif
                    @if(!$person->end_date_checkbox)
                        <dl class="row">
                            <dt class="col-sm-4">Дата</dt>
                            <dd class="col-auto">{{$person->end_date ? \Carbon\Carbon::parse($person->end_date)->format('d/m') : '-'}}</dd>
                        </dl>
                    @endif
                    @if(!$person->end_reason_checkbox)
                        <dl class="row">
                            <dt class="col-sm-4">Причина</dt>
                            <dd class="col-sm-8">{{$person->end_reason?:'-'}}</dd>
                        </dl>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-4">Место</dt>
                        <dd class="col-sm-8">{{$person->end_place?:'-'}}</dd>
                    </dl>

                    @if($person->end_text)
                        <dl class="row">
                            <dt class="col-sm-4">Дополнительно</dt>
                            <dd class="col-sm-8">{{$person->end_text}}</dd>
                        </dl>
                    @endif

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Ссылки
                </div>
                <div class="card-body">
                    <p>ЦАМО</p>
                    @if($person->camolink)
                        <p>Фонд № {{$person->camolink->fond_no?:'-'}}, опись № {{$person->camolink->opis_no?:'-'}}. дело №{{$person->camolink->delo_no?:'-'}}</p>
                    @else
                        <p>-</p>
                    @endif
                    <hr />
                    <p>ОБД Мемориал @if($person->memoriallink and $person->memoriallink->show and $person->memoriallink->link) <a target="_blank" href="{{$person->memoriallink->link}}"><span class="material-icons">link</span></a> @endif</p>
                    @if($person->memoriallink)
                        <p>{{$person->memoriallink->description}}</p>
                    @else
                        <p>-</p>
                    @endif
                    <hr />
                    <p>Книга памяти</p>
                    <p>{{$person->memorybook?:'-'}}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Установление имени
                </div>
                <div class="card-body">
                    @if ($nameSources)
                        @foreach ($nameSources as $ns)
                            <div class="row">
                                <div class="col-md-8">
                                    <p>{{$ns->type}}</p>
                                    <p>{{$ns->description}}</p>
                                </div>
                                <div class="col-md-4">
                                    @if ($ns->files)
                                        @foreach ($ns->files as $file)
                                            <a target="_blank" href="{{route('file', ['id' => $file->id ])}}">[{{$file->ext}}]</a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <hr />
                        @endforeach
                    @else
                        Сведений нет
                    @endif
                </div>
            </div>
        </div>

    </div>

    <small>
        Обновлено {{\Carbon\Carbon::parse($person->updated_at)->format('d-m-Y')}}
    </small>

@endsection

@extends('layouts.inner')

@php
    // years selector
    $arr = range(1850, 1950);
    $originYears = ['-'] + array_combine($arr, $arr);
  //  $originYears[0] = '-';
  //  array_unshift($originYears, '-');

    // months selector
    $arr = range(0, 12);
    $originMonths = array_combine($arr, array_map(function($i) {
        if ($i == 0) return '-';
            else return Carbon\Carbon::createFromFormat('m', $i)->translatedFormat('F');
    }, $arr));

    // days selector
    $arr = range(0, 31);
    $originDays = array_combine($arr, $arr);
    $originDays[0] = '-';
@endphp

@section('js')
    <script src="{{ asset('js/pages/person/form.js?v=5') }}" defer></script>
    <script src="{{ asset('js/app.js?v=4') }}" defer></script>
@endsection

@section('content')
    <div class="row justify-content-center">

        <div class="row">
            <div v-if="success" class="alert alert-success">
                Сохранено
            </div>
            <div v-if="formerrors.length != 0" class="alert alert-danger">
                Ошибка
            </div>
        </div>

        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a  class="nav-link active" :class="{ 'text-danger' : formerrors.last_name || formerrors.first_name}" data-toggle="tab" href="#tab1">Общее</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab2">Установление имени</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab3">Ссылки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" :class="{ 'text-danger' : formerrors.found_date}" href="#tab4">Найден</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab5">Дополнительно</a>
                </li>
            </ul>

            @if(isset($person))
                {{ Form::model($person, ['route' => ['person.update', $person->id], 'id' => 'personForm', 'files' => true, '@submit.prevent' => 'onSubmit']) }}
            @else
                {{ Form::open(['route' => 'person.store', 'id' => 'personForm', 'files' => true, '@submit.prevent' => 'onSubmit']) }}
            @endif

            @if(isset($person))
                {{ method_field('PUT') }}
            @endif

            <div class="card">

                <div class="card-body">


                 <div class="tab-content mb-2">
                     <div class="tab-pane active" id="tab1">

                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Фамилия</label>
                            <div class="col-md-5">
                                {{ Form::Text('last_name', Request::old('last_name'), ['class' => 'form-control']) }}
                                <div v-if="formerrors.last_name" :class="['invalid-feedback d-block']">@{{ formerrors.last_name[0] }}</div>
                            </div>
                        </div>


                            <div class="form-group form-row">
                                <label class="col-md-3 col-form-label text-right">Имя</label>
                                <div class="col-md-5">
                                    {{ Form::Text('first_name', Request::old('first_name'), ['class' => 'form-control']) }}
                                    <div v-if="formerrors.first_name" :class="['invalid-feedback d-block']">@{{ formerrors.first_name[0] }}</div>
                                </div>
                            </div>

                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Отчество</label>
                            <div class="col-md-5">
                                {{ Form::Text('sur_name', Request::old('sur_name'), ['class' => 'form-control']) }}
                            </div>
                        </div>

                         <hr />

                         <p class="form-text">Сведения о рождении</p>

                         <div class="form-group form-row">
                             <label class="col-md-3  col-form-label text-right">Год</label>
                             <div class="col-auto">
                                 {{ Form::select('origin_year', $originYears, Request::old('origin_year'), ['class' => 'form-control']) }}
                             </div>
                             <label class="col-form-label text-right">Месяц</label>
                             <div class="col-auto">
                                 {{ Form::select('origin_month', $originMonths, Request::old('origin_month'), ['class' => 'form-control']) }}
                             </div>
                             <label class="col-form-label text-right">День</label>
                             <div class="col-auto">
                                 {{ Form::select('origin_day', $originDays, Request::old('origin_day'), ['class' => 'form-control']) }}
                             </div>
                             <label class="col-form-label text-right">Воинское звание</label>
                             <div class="col-md-2">
                                 {{ Form::select('military_rank_id', App\Archive\Rank::pluck('title', 'id'), Request::old('military_rank'), ['class' => 'form-control']) }}
                             </div>
                         </div>

                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Республика</label>
                            <div class="col-5">
                                {{ Form::Text('origin_republic', Request::old('origin_republic'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Область (край)</label>
                            <div class="col-5">
                                {{ Form::Text('origin_region', Request::old('origin_region'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group form-row">
                            {{ Form::bsCheckboxText('origin_city', 'Город', Request::old('origin_city'), ['class' => 'form-control', 'check' => @$person->origin_city_checkbox]) }}
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Район</label>
                            <div class="col-5">
                                {{ Form::Text('origin_area', Request::old('origin_area'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Населенный пункт</label>
                            <div class="col-5">
                                {{ Form::Text('origin_place', Request::old('origin_place'), ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <hr />

                        <p class="form-text">Сведения о призыве</p>

                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Каким ВК</label>
                            <div class="col-md-5">
                                {{ Form::Text('service_vk', Request::old('service_vk'), ['class' => 'form-control']) }}
                            </div>
                            <label class="col-form-label">Год</label>
                            <div class="col-md-auto">
                                {{ Form::number('service_year', Request::old('service_year'), ['class' => 'form-control', 'min' => '1900', 'max' => '1946']) }}
                            </div>
                        </div>

                        <hr />

                        <p class="form-text">Адрес семьи</p>

                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Республика</label>
                            <div class="col-5">
                                {{ Form::Text('family_republic', Request::old('family_republic'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Область (край)</label>
                            <div class="col-5">
                                {{ Form::Text('family_region', Request::old('family_region'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group form-row">
                            {{ Form::bsCheckboxText('family_city', 'Город', Request::old('family_city'), ['class' => 'form-control', 'check' => @$person->family_city_checkbox]) }}
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Район</label>
                            <div class="col-5">
                                {{ Form::Text('family_area', Request::old('family_area'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label text-right">Населенный пункт</label>
                            <div class="col-5">
                                {{ Form::Text('family_place', Request::old('family_place'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group form-row">
                            {{ Form::bsCheckboxText('family_other', 'Улица/дом/иное', Request::old('family_other'), ['class' => 'form-control','check' => @$person->family_other_checkbox]) }}
                        </div>

                        <hr />

                         <p class="form-text">Сведения о выбытии</p>

                         <div class="form-group form-row">
                             {{ Form::bsCheckboxText('end_year', 'Год', Request::old('end_year'), ['obj' => 'number', 'controlSize' => 'col-auto','class' => 'form-control', 'min' => '1900', 'max' => '1947', 'check' => @$person->end_year_checkbox]) }}
                         </div>

                         <div class="form-group form-row">
                             {{ Form::bsCheckboxText('end_date', 'Дата', Request::old('end_date'), ['obj' => 'date', 'controlSize' => 'col-auto','class' => 'form-control', 'check' => @$person->end_date_checkbox]) }}
                         </div>

                         <div class="form-group form-row">
                             {{ Form::bsCheckboxText('end_reason', 'Причина', Request::old('end_reason'), ['class' => 'form-control', 'check' => @$person->end_reason_checkbox]) }}
                         </div>

                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Место</label>
                             <div class="col-md-5">
                                 {{ Form::text('end_place', Request::old('end_place'), ['class' => 'form-control']) }}
                             </div>
                         </div>

                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Дополнительно</label>
                             <div class="col-md-5">
                                 {{ Form::textarea('end_text', Request::old('end_text'), ['class' => 'form-control']) }}
                             </div>
                         </div>

                     </div>

                     <div id="tab2" class="tab-pane fade">
                         <p class="form-text">Сведения об установленном имени</p>

                          <person-name-source ref="namesource" @if(isset($person) && !$person->nameSources->isEmpty()) :rows-data="{{ json_encode($person->nameSources()->with('files')->get()->toArray()) }}" @endif  :source-types="{{ json_encode($nameSourceTypes) }}"></person-name-source>

                     </div>

                     <div id="tab3" class="tab-pane fade">

                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Информация в ЦАМО</label>
                             <div class="form-check form-check-inline">
                                 <input name="camolink[available]" value="1" type="checkbox" class="form-check-input" href="#camo_wrapper" @if(@$person->camolink) checked @endif data-toggle="collapse">
                             </div>
                         </div>
                         <div class="collapse @if(@$person->camolink) show @endif " id="camo_wrapper">
                             <div class="form-group form-row">
                                 <label class="col-md-3 col-form-label text-right">Фонд №</label>
                                 <div class="col-5">
                                     {{ Form::Text('camolink[fond_no]', null, ['class' => 'form-control']) }}
                                 </div>
                             </div>
                             <div class="form-group form-row">
                                 <label class="col-md-3 col-form-label text-right">Опись №</label>
                                 <div class="col-5">
                                     {{ Form::Text('camolink[opis_no]', null, ['class' => 'form-control']) }}
                                 </div>
                             </div>
                             <div class="form-group form-row">
                                 <label class="col-md-3 col-form-label text-right">Дело №</label>
                                 <div class="col-5">
                                     {{ Form::Text('camolink[delo_no]', null, ['class' => 'form-control']) }}
                                 </div>
                             </div>
                         </div>

                         <hr />

                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">ОБД Мемориал</label>
                             <div class="form-check form-check-inline">
                                <input name="memoriallink[available]" value="1" type="checkbox" class="form-check-input" href="#memorial_wrapper" @if(@$person->memoriallink) checked @endif data-toggle="collapse">
                             </div>
                         </div>

                         <div class="collapse @if(@$person->memoriallink) show @endif " id="memorial_wrapper">

                             <div class="form-group form-row">
                                 <label class="col-md-3 col-form-label text-right">Ссылка</label>
                                 <div class="col-md-5">
                                     {{ Form::text('memoriallink[link]', null, ['class' => 'form-control']) }}
                                 </div>
                                 <div class="form-check form-check-inline">
                                    <input type="hidden" name="memoriallink[show]" value="0" />
                                    <input name="memoriallink[show]" value="1" type="checkbox" class="form-check-input"  @if(@$person->memoriallink->show) checked @endif />
                                     <label class="form-check-label">Отображать</label>
                                 </div>
                             </div>

                             <div class="form-group form-row">
                                 <label class="col-md-3 col-form-label text-right">Сведения из ОБД</label>
                                 <div class="col-5">
                                     {{ Form::Textarea('memoriallink[description]', Request::old('memorybook'), ['class' => 'form-control']) }}
                                 </div>
                             </div>

                         </div>

                         <hr />

                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Книга памяти</label>
                             <div class="col-5">
                                 {{ Form::Textarea('memorybook', Request::old('memorybook'), ['class' => 'form-control']) }}
                             </div>
                         </div>

                     </div>

                     <div id="tab4" class="tab-pane fade">

                         <p class="form-text">Найден</p>

                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Дата</label>
                             <div class="col-auto">
                                 <input v-if="found_date_type == 0" type="date" name="found_date" value="{{ @$person->found_date  }}" class='form-control' />
                                 <input v-else-if="found_date_type == 1" type="month" name="found_date" value="{{ @$person->found_date ? (date('Y-m', strtotime($person->found_date))) : ''  }}" class='form-control' />
                                 <input v-else type="number" name="found_date" value="{{ @$person->found_date ? (date('Y', strtotime($person->found_date))) : ''  }}" class='form-control' maxlength="4" minlength="4" max="{{ date('Y') }}" />
                                 <div v-if="formerrors.found_date" :class="['invalid-feedback d-block']">@{{ formerrors.found_date[0] }}</div>
                             </div>
                             <div class="col-auto">
                                 {{ Form::select('found_date_type', ['Полная дата', 'Месяц и год', 'Год'], Request::old('found_date_type'), ['id' => 'found_date_type', 'class' => 'form-control', 'v-model' => 'found_date_type']) }}
                             </div>
                         </div>

                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Область (край)</label>
                             <div class="col-5">
                                 {{ Form::Text('found_region', Request::old('found_region'), ['class' => 'form-control']) }}
                             </div>
                         </div>
                         <div class="form-group form-row">
                             {{ Form::bsCheckboxText('found_city', 'Район', Request::old('found_city'), ['class' => 'form-control', 'check' => @$person->found_city_checkbox]) }}

                         </div>
                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Село/Поселение</label>
                             <div class="col-5">
                                 {{ Form::Text('found_place', Request::old('found_place'), ['class' => 'form-control']) }}
                             </div>
                         </div>
                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Местоположение</label>
                             <div class="col-5">
                                 {{ Form::Text('found_coords', Request::old('found_coords'), ['class' => 'form-control']) }}
                             </div>
                         </div>
                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Поисковый отряд</label>
                             <div class="col-5">
                                 {{ Form::Text('found_unit', Request::old('found_unit'), ['class' => 'form-control']) }}
                             </div>
                         </div>
                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Местонахождение отряда</label>
                             <div class="col-5">
                                 {{ Form::Text('found_unit_address', Request::old('found_unit_address'), ['class' => 'form-control']) }}
                             </div>
                         </div>

                         <hr />

                         <p class="form-text">Перезахоронен</p>

                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Дата</label>
                             <div class="col-auto">
                                 <input v-if="burial_date_type == 0" type="date" name="burial_date" value="{{ @$person->burial_date  }}" class='form-control' />
                                 <input v-else-if="burial_date_type == 1" type="month" name="burial_date" value="{{ @$person->burial_date ? (date('Y-m', strtotime($person->burial_date))) : ''  }}" class='form-control' />
                                 <input v-else type="number" name="burial_date" value="{{ @$person->burial_date ? (date('Y', strtotime($person->burial_date))) : ''  }}" class='form-control' maxlength="4" minlength="4" max="{{ date('Y') }}" />
                             </div>
                             <div class="col-auto">
                                 {{ Form::select('burial_date_type', ['Полная дата', 'Месяц и год', 'Год'], Request::old('burial_date_type'), ['id' => 'burial_date_type', 'class' => 'form-control', 'v-model' => 'burial_date_type']) }}
                             </div>
                         </div>
                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Место</label>
                             <div class="col-5">
                                 {{ Form::Text('burial_address', Request::old('burial_address'), ['class' => 'form-control']) }}
                             </div>
                         </div>

                         <hr />
                         <p class="form-text">Сведения о родственниках</p>
                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">Найдены</label>
                             <div class="form-check form-check-inline">
                                 {{Form::hidden('relatives_found', false)}}
                                 {{Form::checkbox('relatives_found', 1, Request::old('relatives_found'), ["class"=>"form-check-input"]) }}
                             </div>
                         </div>
                         <div class="form-group form-row">
                             <label class="col-md-3 col-form-label text-right">&nbsp;</label>
                             <div class="col-md-9">
                                 {{ Form::textarea('relatives_text', Request::old('relatives_text'), ['class' => 'form-control']) }}
                             </div>
                         </div>
                     </div>

                    <div id="tab5" class="tab-pane fade">

                        <div class="form-group form-row">
                            <label class="col-3 col-form-label text-right">Протокол эксгумации</label>
                            <div class="col-3">
                                {{ Form::Text('exhumation[protocol_no]', Request::old('exhumation[protocol_no]'), ['class' => 'form-control']) }}
                                <small class="form-text">Номер</small>
                            </div>
                            <div class="col-auto">
                                {{ Form::date('exhumation[protocol_date]', Request::old('exhumation[date]'), ['class' => 'form-control']) }}
                                <small class="form-text">Дата</small>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label class="col-3 col-form-label text-right">Место хранения протокола</label>
                            <div class="col">
                                {{ Form::Text('exhumation[storage_fond]', Request::old('exhumation[storage_fond]'), ['class' => 'form-control']) }}
                                <small class="form-text">Фонд</small>
                            </div>
                            <div class="col">
                                {{ Form::Text('exhumation[storage_opis]', Request::old('exhumation[storage_opis]'), ['class' => 'form-control']) }}
                                <small class="form-text">Опись</small>
                            </div>
                            <div class="col">
                                {{ Form::Text('exhumation[storage_chain]', Request::old('exhumation[storage_chain]'), ['class' => 'form-control']) }}
                                <small class="form-text">Связка</small>
                            </div>
                            <div class="col">
                                {{ Form::Text('exhumation[storage_file]', Request::old('exhumation[storage_file]'), ['class' => 'form-control']) }}
                                <small class="form-text">Дело</small>
                            </div>
                            <div class="col">
                                {{ Form::Text('exhumation[storage_list]', Request::old('exhumation[storage_list]'), ['class' => 'form-control']) }}
                                <small class="form-text">Лист</small>
                            </div>
                        </div>

                        <hr />

                        <div class="form-group form-row">
                            <label class="col-3 col-form-label text-right">Сведения об увековечении</label>
                            <div class="col-auto">
                                {{ Form::date('immortalization[date]', Request::old('immortalization[date]'), ['class' => 'form-control']) }}
                                <small class="form-text">Дата</small>
                            </div>
                            <div class="col">
                                {{ Form::Text('immortalization[place]', Request::old('immortalization[place]'), ['class' => 'form-control']) }}
                                <small class="form-text">Место</small>
                            </div>
                            <div class="col">
                                {{ Form::Text('immortalization[organization]', Request::old('immortalization[organization]'), ['class' => 'form-control']) }}
                                <small class="form-text">РВК (Организация)</small>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label class="col-3 col-form-label text-right">Иные сведения об увековечении </label>
                            <div class="col-9">
                                {{ Form::textarea('immortalization[additional]', Request::old('immortalization[additional]'), ['class' => 'form-control', 'rows' => 3]) }}
                            </div>
                        </div>

                        <hr />

                        <div class="form-group form-row">
                            <div class="col-12"><label class='col-form-label'>Дополнительно</label></div>
                            <div class="col">
                                {{ Form::textarea('description', Request::old('description'), ['class' => 'form-control']) }}
                            </div>
                        </div>

                    </div>

                </div>


                </div>

            </div>

            <div class="row mt-3">
                <div class="col-6">

                </div>
                <div class="col-6 text-right">
                    {{ Form::submit('Сохранить', ['name' => 'submit', 'class' => 'btn btn-primary']) }}
                </div>
            </div>

            {{ Form::close() }}

        </div>
    </div>
@endsection

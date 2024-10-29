<?php
if (@$attributes)
    $attributes =  array_merge(['class' => 'form-control'], $attributes);
else
    $attributes = ['class' => 'form-control'];

    $obj = @$attributes['obj']?:'text';
    $controlSize = @$attributes['controlSize']?:'col-md-5';

?>

{{ Form::label($label, null, ['class' => 'col-md-3 col-form-label text-md-right']) }}
<div class="<?=$controlSize?> collapse <?=@$attributes['check']?:'show'?>" id="{{$name}}_wrapper">
    {{ Form::$obj($name, $value, $attributes) }}
</div>
<div class="form-check form-check-inline">
    {{ Form::hidden($name.'_checkbox', false) }}
    <label class="form-check-label">
        {{Form::hidden($name.'_checkbox', false)}}
        {{Form::checkbox($name.'_checkbox', 1, @$attributes['check']?:false, ["class"=>"form-check-input", 'href'=>'#'.$name.'_wrapper', 'data-toggle'=>'collapse'])}}
        Нет</label>
</div>


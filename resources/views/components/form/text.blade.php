<?php
    if ($attributes)
        $attributes =  array_merge(['class' => 'form-control'], $attributes);
    else
        $attributes = ['class' => 'form-control'];
?>
<div class="form-group">
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    {{ Form::text($name, $value, $attributes) }}
</div>

<div class="form-group row">
    {!! Form::label('description', 'Description *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('description', $value = null, ['class' => 'form-control', 'placeholder' => 'Description', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('sla', 'SLA *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4 input-group">
        {!! Form::number('sla', $value = null, ['class' => 'form-control', 'placeholder' => 'SLA (Response Time)', 'required' => true, 'aria-describedby' => 'addon']) !!}
        <div class="input-group-append">
            <span class="input-group-text" id="addon">Day(s)</span>
        </div>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('base_cost', 'Operating Cost *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4 input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="addon1">=N=</span>
        </div>
        {!! Form::number('base_cost', $value = null, ['class' => 'form-control', 'placeholder' => 'Operating Cost', 'required' => true, 'aria-describedby' => 'addon1', 'step' => 0.01]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

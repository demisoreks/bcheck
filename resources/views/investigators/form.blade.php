<div class="form-group row">
    {!! Form::label('username', 'Username *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('username', $employee->username, ['class' => 'form-control', 'placeholder' => 'Username', 'required' => true, 'maxlength' => 100, 'readonly' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('first_name', 'First Name *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('first_name', $value = null, ['class' => 'form-control', 'placeholder' => 'First Name', 'required' => true, 'maxlength' => 50]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('surname', 'Surname *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('surname', $value = null, ['class' => 'form-control', 'placeholder' => 'Surname', 'required' => true, 'maxlength' => 50]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('gender', 'Gender *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('gender', ['M' => 'Male', 'F' => 'Female'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('phone1', 'Mobile Number *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('phone1', $value = null, ['class' => 'form-control', 'placeholder' => 'Mobile Number', 'required' => true, 'maxlength' => 20]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('phone2', 'Alternate Number', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('phone2', $value = null, ['class' => 'form-control', 'placeholder' => 'Alternate Number', 'maxlength' => 20]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('region', 'Region *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('region', ['Lagos' => 'Lagos', 'North Central' => 'North Central', 'North East' => 'North East', 'North West' => 'North West', 'South South' => 'South South', 'South East' => 'South East', 'South West' => 'South West'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<?php
if ($investigator) {
    $comps = [];
    foreach (explode(',', str_replace(['[', ']'], '', $investigator->competencies)) as $c) {
        $comps[] = (int) str_replace('"', '', $c);
    }
} else {
    $comps = [];
}
?>
<div class="form-group row">
    {!! Form::label('competencies', 'Competencies', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('competencies[]', App\BchService::where('active', true)->orderBy('description')->pluck('description', 'id'), $value = $comps, ['class' => 'form-control selectpicker w-100', 'placeholder' => '- Select Competencies -', 'multiple' => true]) !!}
    </div>
    Hold CTRL to select multiple
</div>
<div class="form-group row">
    {!! Form::label('bank', 'Bank', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('bank', $value = null, ['class' => 'form-control', 'placeholder' => 'Bank', 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('account_number', 'Account Number', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::number('account_number', $value = null, ['class' => 'form-control', 'placeholder' => 'Account Number', 'maxlength' => 10]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('picture', 'Picture', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::file('picture', $value = null, ['class' => 'form-control', 'placeholder' => 'Picture']) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<script>
    $('.select2').select2();
</script>
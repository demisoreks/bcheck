@extends('app', ['page_title' => 'Investigators', 'open_menu' => 'settings'])

@section('content')
<div class="row">
    <div class="col-12">
        <legend>Edit Investigator</legend>
        <?php
        $investigators = App\BchInvestigator::where('employee_id', $employee->id);
        if ($investigators->count() > 0) {
            $investigator = $investigators->first();
        }
        ?>
        @if ($investigators->count() > 0)
        {!! Form::model($investigator, ['route' => ['investigators.store'], 'class' => 'form-group', 'files' => true]) !!}
            @include('investigators/form', ['submit_text' => 'Update Details'])
        {!! Form::close() !!}
        @else
        {!! Form::model(new App\BchInvestigator, ['route' => ['investigators.store'], 'class' => 'form-group', 'files' => true]) !!}
            @include('investigators/form', ['submit_text' => 'Update Details'])
        {!! Form::close() !!}
        @endif
    </div>
</div>
@endsection
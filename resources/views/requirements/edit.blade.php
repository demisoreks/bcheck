@extends('app', ['page_title' => 'Service Requirements', 'open_menu' => 'settings'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="alert alert-primary alert-dismissible">
            Service: <strong>{{ $service->description }}</strong>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('services.requirements.index', $service->slug()) }}"><i class="fas fa-list"></i> Existing Requirements</a>
        <a class="btn btn-primary" href="{{ route('services.index') }}"><i class="fas fa-arrow-left"></i> Back to Services</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Requirement</legend>
        {!! Form::model($requirement, ['route' => ['services.requirements.update', $service->slug(), $requirement->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('requirements/form', ['submit_text' => 'Update Requirement'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
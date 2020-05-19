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
        <legend>New Requirement</legend>
        {!! Form::model(new App\BchRequirement, ['route' => ['services.requirements.store', $service->slug()], 'class' => 'form-group']) !!}
            @include('requirements/form', ['submit_text' => 'Create Requirement'])
        {!! Form::close() !!}
    </div>
</div>
@endsection

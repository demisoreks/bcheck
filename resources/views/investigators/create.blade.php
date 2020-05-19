@extends('app', ['page_title' => 'Courses', 'open_menu' => 'cadets'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('courses.index') }}"><i class="fas fa-list"></i> Existing Courses</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Course</legend>
        {!! Form::model(new App\CdtCourse, ['route' => ['courses.store'], 'class' => 'form-group']) !!}
            @include('courses/form', ['submit_text' => 'Create Course'])
        {!! Form::close() !!}
    </div>
</div>
@endsection

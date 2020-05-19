@extends('app', ['page_title' => 'Treat Task'])

@section('content')
<div class="row">
    <div class="col-md-6">
        <legend>Treat Task</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="40%"><strong>Requested Service</strong></td>
                <td>{{ $request_service->service->description }}</td>
            </tr>
            @foreach (App\BchRequestRequirement::where('request_service_id', $request_service->id)->get() as $request_requirement)
            <tr>
                <td><strong>{{ $request_requirement->requirement->description }}</strong></td>
                <td>
                    @if ($request_requirement->requirement->type == 'Document')
                    <a href="{{ config('app.url') }}{{ Storage::url('public/requests/requirements/'.$request_requirement->id.'.'.$request_requirement->information) }}" class="btn btn-link" target="_blank">Click to view</a>
                    @else
                    {{ $request_requirement->information }}
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        {!! Form::model(null, ['route' => ['tasks.complete', $request_service->slug()], 'class' => 'form-group', 'files' => true]) !!}
        <div class="form-group row">
            {!! Form::label('result', 'Result *', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('result', ['Passed' => 'Passed', 'Failed' => 'Failed', 'Inconclusive' => 'Inconclusive'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('comment', 'Comment *', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::textarea('comment', $value = null, ['class' => 'form-control', 'placeholder' => 'Comment', 'required' => true, 'maxlength' => 1000, 'rows' => 5]) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('evidence', 'Evidence', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-6">
                {!! Form::file('evidence', $value = null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('report', 'Additional Report', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-6">
                {!! Form::file('report', $value = null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10 offset-md-4">
                {!! Form::submit('Complete', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-6">
        <legend>Client Information</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="45%" class="font-weight-bold">Name</td>
                <td>{{ $request_service->request->client->name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Contact Person</td>
                <td>{{ $request_service->request->client->contact_person }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Mobile Number</td>
                <td>{{ $request_service->request->client->mobile_no }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Email Address</td>
                <td>{{ $request_service->request->client->email }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection

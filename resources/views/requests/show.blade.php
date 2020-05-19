@extends('app', ['page_title' => 'Service Requests', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('requests.index') }}"><i class="fas fa-list"></i> Initiated Requests</a>
        <a class="btn btn-success" href="{{ route('requests.submit', $request->slug()) }}" onclick="return confirmSubmit()"><i class="fas fa-check"></i> Submit Request</a>
        <a class="btn btn-danger" href="{{ route('requests.cancel', $request->slug()) }}" onclick="return confirmCancel()"><i class="fas fa-trash"></i> Cancel Request</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <legend>Available Services</legend>
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\BchService::where('active', true)->orderBy('description')->get() as $service)
            <tr>
                <td width="70%">{{ $service->description }}</td>
                <td><a class="btn btn-block btn-sm btn-primary" data-toggle="modal" data-target="#service-modal-{{ $service->id }}">Add</a></td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="col-md-6">
        <legend>Client Information</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="45%" class="font-weight-bold">Name</td>
                <td>{{ $request->client->name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Contact Person</td>
                <td>{{ $request->client->contact_person }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Mobile Number</td>
                <td>{{ $request->client->mobile_no }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Email Address</td>
                <td>{{ $request->client->email }}</td>
            </tr>
        </table>
        <legend>Request Services</legend>
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\BchRequestService::where('request_id', $request->id)->get() as $request_service)
            <tr>
                <td width="70%" class="font-weight-bold">{{ App\BchService::find($request_service->service_id)->description }}</td>
                <td><a onclick="return confirmRemove()" href="{{ route('requests.remove_service', [$request_service->slug()]) }}" class="btn btn-primary btn-sm btn-block">Remove Service</a></td>
            </tr>
            <tr>
                <td colspan="2">
                    @foreach (App\BchRequestRequirement::where('request_service_id', $request_service->id)->get() as $request_requirement)
                    {{ App\BchRequirement::find($request_requirement->requirement_id)->description }}: 
                    @if (App\BchRequirement::find($request_requirement->requirement_id)->type == 'Document')
                    <a href="{{ config('app.url') }}{{ Storage::url('public/requests/requirements/'.$request_requirement->id.'.'.$request_requirement->information) }}" class="btn btn-link" target="_blank">Click to view</a>
                    @else
                    {{ $request_requirement->information }}
                    @endif
                    <br />
                    @endforeach
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@foreach (App\BchService::where('active', true)->get() as $service)
<div class="modal fade" id="service-modal-{{ $service->id }}" tabindex="-1" role="dialog" aria-labelledby="service-modal-{{ $service->id }}Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Add {{ $service->description }}</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">Each uploaded file must be under 4MB.</div>
                {!! Form::model(null, ['route' => ['requests.add_service', $request->slug()], 'class' => 'form-group', 'files' => true]) !!}
                <div class="form-group row" hidden>
                    {!! Form::label('service_id', 'Service ID *', ['class' => 'col-md-4 col-form-label']) !!}
                    <div class="col-md-6">
                        {!! Form::hidden('service_id', $service->id, ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
                @foreach (App\BchRequirement::where('service_id', $service->id)->where('active', true)->get() as $requirement)
                <div class="form-group row">
                    {!! Form::label('requirement'.$requirement->id, $requirement->description, ['class' => 'col-md-4 col-form-label']) !!}
                    <div class="col-md-6">
                        @if ($requirement->type == 'Text')
                        {!! Form::text('requirement'.$requirement->id, $value = null, ['class' => 'form-control', 'required' => true]) !!}
                        @elseif ($requirement->type == 'Document')
                        {!! Form::file('requirement'.$requirement->id, $value = null, ['class' => 'form-control', 'required' => true]) !!}
                        @endif
                    </div>
                </div>
                @endforeach
                <div class="form-group row">
                    <div class="col-md-10 offset-md-4">
                        {!! Form::submit('Add Service', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@extends('app', ['page_title' => 'Attach Invoice', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-md-6">
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
        <legend>Attach Invoice</legend>
        {!! Form::model($request, ['route' => ['requests.attach_invoice', $request->slug()], 'class' => 'form-group']) !!}
            <div class="form-group row">
                {!! Form::label('invoice', 'Invoice Link *', ['class' => 'col-md-4 col-form-label']) !!}
                <div class="col-md-8">
                    {!! Form::text('invoice', $value = null, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 offset-md-4">
                    {!! Form::submit('Attach Invoice', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

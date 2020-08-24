@extends('app', ['page_title' => 'Task Details', 'open_menu' => 'reports'])

@section('content')
<div class="row">
    <div class="col-md-6">
        <legend>Task Details</legend>
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
            <tr>
                <td>
                    <strong>Status</strong>
                </td>
                <td>{{ $request_service->status }}</td>
            </tr>
            <tr>
                <td>
                    <strong>Result</strong>
                </td>
                <td>{{ $request_service->result }}</td>
            </tr>
            <tr>
                <td>
                    <strong>Comment</strong>
                </td>
                <td>{{ $request_service->comment }}</td>
            </tr>
            <tr>
                <td>
                    <strong>Evidence</strong>
                </td>
                <td>
                    @if (Storage::exists('public/requests/results/evi'.$request_service->id.'.'.$request_service->evidence_ext))
                    <a href="{{ config('app.url') }}{{ Storage::url('public/requests/results/evi'.$request_service->id.'.'.$request_service->evidence_ext) }}" class="btn btn-link" target="_blank">Click to view</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Additional Information</strong>
                </td>
                <td>
                    @if (Storage::exists('public/requests/results/rep'.$request_service->id.'.'.$request_service->report_ext))
                    <a href="{{ config('app.url') }}{{ Storage::url('public/requests/results/rep'.$request_service->id.'.'.$request_service->report_ext) }}" class="btn btn-link" target="_blank">Click to view</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Treated By</strong>
                </td>
                <td>{{ App\BchInvestigator::select(DB::raw('CONCAT(first_name, " ", surname) AS full_name, employee_id'))->where('employee_id', $request_service->employee_id)->first()->full_name }}</td>
            </tr>
            <tr>
                <td>
                    <strong>Date/Time Submitted</strong>
                </td>
                <td>{{ $request_service->request->request_date_time }}</td>
            </tr>
            <tr>
                <td>
                    <strong>Date/Time Treated</strong>
                </td>
                <td>{{ $request_service->treated_at }}</td>
            </tr>
        </table>
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

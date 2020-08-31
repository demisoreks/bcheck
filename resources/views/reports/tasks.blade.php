@extends('app', ['page_title' => 'Task List', 'open_menu' => 'reports'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="alert alert-info">Search dates are based on request date.</div>
    </div>
</div>
<div class="row" style="margin-bottom: 20px;">
    <div class="col-12">
        {!! Form::model($param, ['route' => ['reports.tasks'], 'class' => 'form-inline']) !!}
        <div class="form-row align-items-center">
            <div class="col-auto">
                {!! Form::label('investigator_id', 'Investigator', []) !!}
            </div>
            <div class="col-auto">
                {!! Form::select('investigator_id', App\BchInvestigator::whereNotNull('first_name')->select(DB::raw("CONCAT(first_name, ' ', surname) AS full_name"), 'id')->pluck('full_name', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Investigator -']) !!}
            </div>
            <div class="col-auto">
                {!! Form::label('service_id', 'Service', []) !!}
            </div>
            <div class="col-auto">
                {!! Form::select('service_id', App\BchService::all()->pluck('description', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Service -']) !!}
            </div>
            <div class="col-auto">
                {!! Form::label('status', 'Status', []) !!}
            </div>
            <div class="col-auto">
                {!! Form::select('status', ['Open' => 'Open', 'In Progress' => 'In Progress', 'Closed' => 'Closed'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Status -']) !!}
            </div>
            <div class="col-auto">
                {!! Form::label('client_name', 'Client Name', []) !!}
            </div>
            <div class="col-auto">
                {!! Form::text('client_name', $value = null, ['class' => 'form-control', 'placeholder' => 'Client Name']) !!}
            </div>
            <div class="col-auto">
                {!! Form::label('sector', 'Sector', []) !!}
            </div>
            <div class="col-auto">
                {!! Form::text('sector', $value = null, ['class' => 'form-control', 'placeholder' => 'Sector']) !!}
            </div>
        </div>
        <br />
        @include('reports/date_form', ['submit_text' => 'Search'])
        {!! Form::close() !!}
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>TASK LIST</strong>
            </div>
            <div class="card-body bg-white">
                <table id="myTable4" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>DATE/TIME SUBMITTED</strong></th>
                            <th><strong>DATE/TIME TREATED</strong></th>
                            <th><strong>CLIENT (SECTOR)</strong></th>
                            <th><strong>REQUESTED SERVICE</strong></th>
                            <th><strong>INVESTIGATOR</strong></th>
                            <th><strong>SLA</strong></th>
                            <th><strong>STATUS</strong></th>
                            <th data-priority="1">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($task_list as $task)
                        <tr>
                            <td>{{ $task->request->request_date_time }}</td>
                            <td>{{ $task->treated_at }}</td>
                            <td>{{ $task->request->client->name }} ({{ $task->request->client->sector }})</td>
                            <td>{{ $task->service->description }}</td>
                            <td>@if ($task->employee_id) {{ App\BchInvestigator::select(DB::raw('CONCAT(first_name, " ", surname) AS full_name, employee_id'))->where('employee_id', $task->employee_id)->first()->full_name }} @endif</td>
                            <td>{{ $task->service->sla }} Day(s)</td>
                            <td>{{ $task->status }}</td>
                            <td class="text-center">
                                <a title="Details" href="{{ route('reports.task', [$task->slug()]) }}" class="btn btn-primary btn-block btn-sm">Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

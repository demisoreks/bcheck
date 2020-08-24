@extends('app', ['page_title' => 'Investigator Report', 'open_menu' => 'reports'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="alert alert-info">Search dates are based on request date.</div>
    </div>
</div>
<div class="row" style="margin-bottom: 20px;">
    <div class="col-12">
        {!! Form::model($param, ['route' => ['reports.investigator'], 'class' => 'form-inline']) !!}
        <div class="form-row align-items-center">
            <div class="col-auto">
                {!! Form::label('investigator_id', 'Investigator', []) !!}
            </div>
            <div class="col-auto">
                {!! Form::select('investigator_id', App\BchInvestigator::whereNotNull('first_name')->select(DB::raw("CONCAT(first_name, ' ', surname) AS full_name"), 'id')->pluck('full_name', 'id'), $value = null, ['class' => 'form-control', 'required' => true, 'placeholder' => '- Select Investigator -']) !!}
            </div>
        </div>
        @include('reports/date_form', ['submit_text' => 'Search'])
        {!! Form::close() !!}
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-body text-center text-info">
                <h2>{{ $total }}</h2>
                Total Tasks
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-body text-center text-success">
                <h2>{{ $completed }}</h2>
                Completed Tasks
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-body text-center text-warning">
                <h2>{{ $pending }}</h2>
                Pending Tasks
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-body text-center text-danger">
                <h2>{{ $overdue }}</h2>
                Overdue Tasks
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>STATUS OF TASKS</strong>
            </div>
            <div class="card-body bg-white">
                {!! $status_chart->container() !!}
                {!! $status_chart->script() !!}
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>INVESTIGATION TYPES</strong>
            </div>
            <div class="card-body bg-white">
                {!! $service_chart->container() !!}
                {!! $service_chart->script() !!}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>TASK LIST</strong>
            </div>
            <div class="card-body bg-white">
                <table id="myTable4" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th width="10%"><strong>DATE/TIME SUBMITTED</strong></th>
                            <th width="10%"><strong>DATE/TIME TREATED</strong></th>
                            <th><strong>CLIENT INFORMATION</strong></th>
                            <th width="20%"><strong>REQUESTED SERVICE</strong></th>
                            <th width="10%"><strong>SLA</strong></th>
                            <th width="10%"><strong>AGE</strong></th>
                            <th width="10%"><strong>STATUS</strong></th>
                            <th width="10%" data-priority="1">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->request->request_date_time }}</td>
                            <td>{{ $task->treated_at }}</td>
                            <td>{{ $task->request->client->name }}<br />{{ $task->request->client->mobile_no }}<br />{{ $task->request->client->email }}</td>
                            <td>{{ $task->service->description }}</td>
                            <td>{{ $task->service->sla }} Day(s)</td>
                            <td>{{ Carbon\Carbon::now()->diffInDays($task->request->request_date_time) }} Day(s) @if (Carbon\Carbon::now()->diffInDays($task->request->request_date_time) > $task->service->sla && $task->status != 'Closed') <span class="text-danger"><i class="fas fa-exclamation-circle" title="Overdue"></i></span> @endif </td>
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

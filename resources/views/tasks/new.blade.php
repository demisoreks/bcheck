@extends('app', ['page_title' => 'New Tasks'])

@section('content')
<div class="row">
    <div class="col-12">
        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
            <thead>
                <tr class="text-center">
                    <th width="10%"><strong>DATE/TIME SUBMITTED</strong></th>
                    <th><strong>CLIENT INFORMATION</strong></th>
                    <th width="20%"><strong>REQUESTED SERVICE</strong></th>
                    <th width="10%"><strong>SLA</strong></th>
                    <th width="10%"><strong>AGE</strong></th>
                    <th width="10%"><strong>STATUS</strong></th>
                    <th width="10%"><strong>ASSIGNED TO</strong></th>
                    <th width="15%" data-priority="1">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->request->request_date_time }}</td>
                    <td>{{ $task->request->client->name }}<br />{{ $task->request->client->mobile_no }}<br />{{ $task->request->client->email }}</td>
                    <td>{{ $task->service->description }}</td>
                    <td>{{ $task->service->sla }} Day(s)</td>
                    <td>{{ Carbon\Carbon::now()->diffInDays($task->request->request_date_time) }} Day(s) @if (Carbon\Carbon::now()->diffInDays($task->request->request_date_time) > $task->service->sla) <span class="text-danger"><i class="fas fa-exclamation-circle" title="Overdue"></i></span> @endif </td>
                    <td>{{ $task->status }}</td>
                    <td>@if ($task->status == "In Progress") {{ App\BchInvestigator::where('employee_id', $task->employee_id)->first()->first_name.' '.App\BchInvestigator::where('employee_id', $task->employee_id)->first()->surname }} @endif</td>
                    <td class="text-center">
                        @if ($task->status == "Open")
                        <a title="Assign" href="{{ route('tasks.assign', [$task->slug()]) }}" class="btn btn-primary btn-block btn-sm">Assign</a>
                        @elseif ($task->status == "In Progress")
                        <a title="Assign" href="{{ route('tasks.assign', [$task->slug()]) }}" class="btn btn-info btn-block btn-sm">Re-assign</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

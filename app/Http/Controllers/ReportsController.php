<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\AccEmployee;
use App\AccEmployeeRole;
use App\AccRole;
use App\BchClient;
use App\BchInvestigator;
use App\BchRequest;
use App\BchService;
use App\BchRequestService;
use App\Charts\BCheckChart;

class ReportsController extends Controller
{
    public function investigators() {
        $investigators = BchInvestigator::whereIn('employee_id', AccEmployee::where('active', true)->whereIn('id', AccEmployeeRole::where('role_id', AccRole::where('privileged_link_id', config('var.link_id'))->where('title', 'Investigator')->where('active', true)->first()->id)->pluck('employee_id')->toArray())->pluck('id')->toArray())->get();

        $competency_chart = new BCheckChart();
        $competency_labels = [];
        $competency_counts = [];
        foreach (BchService::where('active', true)->get() as $service) {
            array_push($competency_labels, $service->description);
            $count = 0;
            foreach ($investigators as $investigator) {
                $competencies = explode(",", $investigator->competencies);
                if (in_array($service->id, $competencies)) {
                    $count ++;
                }
            }
            array_push($competency_counts, $count);
        }
        $competency_chart->labels($competency_labels)->dataset('No. of Investigators', 'bar', $competency_counts);

        return view('reports.investigators', compact('investigators', 'competency_chart'));
    }

    public function investigator(Request $request) {
        $input = $request->all();
        if (isset($input['from_date']) && isset($input['to_date'])) {
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
            $investigator_id = $input['investigator_id'];
        } else {
            $to_date = date("Y-m-d");
            $from_date = date("Y-m-d", strtotime('-7 days', strtotime($to_date)));
            $investigator_id = 0;
        }
        $param = [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'investigator_id' => $investigator_id
        ];

        $investigator = BchInvestigator::find($investigator_id);
        if ($investigator) {
            $employee_id = $investigator->employee_id;
        } else {
            $employee_id = 0;
        }
        $date_range = [date($from_date)." 00:00:00", date($to_date)." 23:59:59"];
        $tasks = BchRequestService::where('employee_id', $employee_id)->whereBetween('created_at', $date_range)->get();
        $total = BchRequestService::where('employee_id', $employee_id)->whereBetween('created_at', $date_range)->count();
        $completed = BchRequestService::where('employee_id', $employee_id)->whereBetween('created_at', $date_range)->where('status', 'Closed')->count();
        $pending = BchRequestService::where('employee_id', $employee_id)->whereBetween('created_at', $date_range)->where('status', '<>', 'Closed')->count();
        $overdue = 0;
        $pending_tasks = BchRequestService::where('employee_id', $employee_id)->whereBetween('created_at', $date_range)->where('status', '<>', 'Closed')->get();
        foreach ($pending_tasks as $pending_task) {
            if (Carbon::now()->diffInDays($pending_task->created_at) > BchService::find($pending_task->service_id)->sla) {
                $overdue ++;
            }
        }

        $status_chart = new BCheckChart();
        $status_labels = ['In Progress', 'Completed'];
        $status_counts = [$pending, $completed];
        $status_chart->labels($status_labels)->dataset('Status of Tasks', 'pie', $status_counts)->backgroundColor(['orange', 'green']);

        $service_chart = new BCheckChart();
        $service_labels = [];
        $service_counts = [];
        $service_colors = [];
        $services = BchService::where('active', true)->get();
        foreach ($services as $service) {
            array_push($service_labels, $service->description);
            array_push($service_counts, BchRequestService::where('employee_id', $employee_id)->whereBetween('created_at', $date_range)->where('service_id', $service->id)->count());
            array_push($service_colors, $this->randomColor());
        }
        $service_chart->labels($service_labels)->dataset('Investigation Types', 'doughnut', $service_counts)->backgroundColor($service_colors);

        return view('reports.investigator', compact('param', 'total', 'completed', 'pending', 'overdue', 'status_chart', 'service_chart', 'tasks'));
    }

    static function randomColor() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function task(BchRequestService $request_service) {
        return view('reports.task', compact('request_service'));
    }

    public function tasks(Request $request) {
        $input = $request->all();
        if (isset($input['from_date']) && isset($input['to_date'])) {
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
            $investigator_id = $input['investigator_id'];
            $service_id = $input['service_id'];
            $status = $input['status'];
            $client_name = $input['client_name'];
            $sector = $input['sector'];
        } else {
            $to_date = date("Y-m-d");
            $from_date = date("Y-m-d", strtotime('-7 days', strtotime($to_date)));
            $investigator_id = null;
            $service_id = null;
            $status = null;
            $client_name = null;
            $sector = null;
        }
        $param = [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'investigator_id' => $investigator_id,
            'service_id' => $service_id,
            'status' => $status,
            'client_name' => $client_name,
            'sector' => $sector
        ];

        $date_range = [date($from_date)." 00:00:00", date($to_date)." 23:59:59"];
        $tasks = BchRequestService::whereBetween('created_at', $date_range);
        if ($investigator_id) {
            $investigator = BchInvestigator::find($investigator_id);
            if ($investigator) {
                $employee_id = $investigator->employee_id;
                $tasks = $tasks->where('employee_id', $employee_id);
            }
        }
        if ($service_id) {
            $tasks = $tasks->where('service_id', $service_id);
        }
        if ($status) {
            $tasks = $tasks->where('status', $status);
        }
        if ($client_name) {
            $tasks = $tasks->whereIn('request_id', BchRequest::whereIn('client_id', BchClient::where('name', 'like', '%'.$client_name.'%')->pluck('id')->toArray())->pluck('id')->toArray());
        }
        if ($sector) {
            $tasks = $tasks->whereIn('request_id', BchRequest::whereIn('client_id', BchClient::where('sector', 'like', '%'.$sector.'%')->pluck('id')->toArray())->pluck('id')->toArray());
        }

        $task_list = $tasks->get();

        return view('reports.tasks', compact('param', 'task_list'));
    }
}

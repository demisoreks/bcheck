<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Storage;
use App\BchRequestService;

class TasksController extends Controller
{
    public function pending() {
        $tasks = BchRequestService::where('status', 'In Progress')->where('employee_id', UtilsController::getEmployee()->id)->get();
        return view('tasks.pending', compact('tasks'));
    }
    
    public function treat(BchRequestService $request_service) {
        $request_service->update([
            'status' => 'In Progress',
            'employee_id' => UtilsController::getEmployee()->id
        ]);
        return view('tasks.treat', compact('request_service'));
    }
    
    public function complete(BchRequestService $request_service, Request $request) {
        $evidence_ext = "";
        $report_ext = "";
        if ($request->hasFile('evidence')) {
            if ($request->file('evidence')->getSize() > 5000000) {
                return Redirect::back()
                        ->with('error', UtilsController::response('Oops!', 'Your evidence file is too large.'))
                        ->withInput();
            }
            $evidence_ext = $request->file('evidence')->getClientOriginalExtension();
        }
        
        if ($request->hasFile('report')) {
            if ($request->file('report')->getSize() > 5000000) {
                return Redirect::back()
                        ->with('error', UtilsController::response('Oops!', 'Your report file is too large.'))
                        ->withInput();
            }
            $report_ext = $request->file('report')->getClientOriginalExtension();
        }
        
        $input = $request->input();
        $request_service->update([
            'status' => 'Closed',
            'result' => $input['result'],
            'comment' => $input['comment'],
            'result' => $input['result'],
            'employee_id' => UtilsController::getEmployee()->id,
            'treated_at' => now(),
            'evidence_ext' => $evidence_ext,
            'report_ext' => $report_ext
        ]);
        
        if ($request->hasFile('evidence')) {
            Storage::put('public/requests/results/evi'.$request_service->id.'.'.$request->file('evidence')->getClientOriginalExtension(), file_get_contents($request->file('evidence')->getRealPath()));
        }
        
        if ($request->hasFile('report')) {
            Storage::put('public/requests/results/rep'.$request_service->id.'.'.$request->file('report')->getClientOriginalExtension(), file_get_contents($request->file('report')->getRealPath()));
        }
        
        if (BchRequestService::where('service_id', $request_service->service_id)->where('status', '<>', 'Closed')->count() == 0) {
            $request_service->request->update([
                'status' => 'Completed'
            ]);
        }
        
        ActivitiesController::log('Task was completed for '.$request_service->request->client->name.'.');
        return Redirect::route('tasks.pending')
                ->with('success', UtilsController::response('Completed!', 'Task completed successfully.'));
    }
    
    public function new_tasks() {
        $tasks = BchRequestService::whereIn('status', ['Open', 'In Progress'])->get();
        return view('tasks.new', compact('tasks'));
    }
    
    public function assign(BchRequestService $request_service) {
        return view('tasks.assign', compact('request_service'));
    }
    
    public function mark_assigned(BchRequestService $request_service, Request $request) {
        $input = $request->input();
        $request_service->update([
            'status' => 'In Progress',
            'employee_id' => $input['employee_id'],
            'cost' => $input['cost']
        ]);
        
        ActivitiesController::log('Task was assigned for '.$request_service->request->client->name.'.');
        return Redirect::route('tasks.new')
                ->with('success', UtilsController::response('Completed!', 'Task assigned successfully.'));
    }
}

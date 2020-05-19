<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Storage;
use File;
use App\BchRequest;
use App\BchClient;
use App\BchRequestService;
use App\BchRequestRequirement;
use App\BchRequirement;

class RequestsController extends Controller
{
    public function index() {
        $requests = BchRequest::where('status', 'Initiated')->get();
        return view('requests.index', compact('requests'));
    }
    
    public function create() {
        return view('requests.create');
    }
    
    public function initiate(BchClient $client) {
        $input = [
            'client_id' => $client->id,
            'status' => 'Initiated',
            'employee_id' => UtilsController::getEmployee()->id,
            'request_date_time' => now()
        ];
         
        $request = BchRequest::create($input);
        if ($request) {
            ActivitiesController::log('Request was initiated for '.$client->name.'.');
            return Redirect::route('requests.show', $request->slug());
        } else {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', 'Request could not be initiated.'));
        }
    }
    
    public function show(BchRequest $request) {
        return view('requests.show', compact('request'));
    }
    
    public function add_service(BchRequest $request, Request $req) {
        $input = $req->input();
        
        foreach (BchRequirement::where('service_id', $input['service_id'])->where('active', true)->get() as $requirement) {
            if ($req->hasFile('requirement'.$requirement->id)) {
                if ($req->file('requirement'.$requirement->id)->getSize() > 5000000) {
                    return Redirect::back()
                            ->with('error', UtilsController::response('Oops!', 'Service addition failed. One of your files is too large.'));
                }
            }
        }
        
        $data1 = [
            'request_id' => $request->id,
            'service_id' => $input['service_id'],
            'cost' => 0.0
        ];
        
        $request_service = BchRequestService::create($data1);
        
        foreach (BchRequirement::where('service_id', $input['service_id'])->where('active', true)->get() as $requirement) {
            if ($requirement->type == "Text") {
                $information = $input['requirement'.$requirement->id];
            } else if ($requirement->type == "Document") {
                $information = $req->file('requirement'.$requirement->id)->getClientOriginalExtension();
            }
            $data2 = [
                'request_service_id' => $request_service->id,
                'requirement_id' => $requirement->id,
                'information' => $information
            ];
            $request_requirement = BchRequestRequirement::create($data2);
            if ($req->hasFile('requirement'.$requirement->id)) {
                Storage::put('public/requests/requirements/'.$request_requirement->id.'.'.$req->file('requirement'.$requirement->id)->getClientOriginalExtension(), file_get_contents($req->file('requirement'.$requirement->id)->getRealPath()));
            }
        }
        
        return Redirect::route('requests.show', $request->slug())
                ->with('success', UtilsController::response('Completed!', 'Service added successfully.'));
    }
    
    public function remove_service(BchRequestService $request_service) {
        $request = BchRequest::find($request_service->request_id);
        
        foreach (BchRequestRequirement::where('request_service_id', $request_service->id)->get() as $request_requirement) {
            if (File::exists('storage/requests/requirements/'.$request_requirement->id.'.'.$request_requirement->information)) {
                File::delete('storage/requests/requirements/'.$request_requirement->id.'.'.$request_requirement->information);
            }
            $request_requirement->delete();
        }
        $request_service->delete();
        
        return Redirect::route('requests.show', $request->slug())
                ->with('success', UtilsController::response('Completed!', 'Service removed successfully.'));
    }
    
    public function cancel(BchRequest $request) {
        $client = $request->client;
        
        foreach (BchRequestService::where('request_id', $request->id)->get() as $request_service) {
            foreach (BchRequestRequirement::where('request_service_id', $request_service->id)->get() as $request_requirement) {
                if (File::exists('storage/requests/requirements/'.$request_requirement->id.'.'.$request_requirement->information)) {
                    File::delete('storage/requests/requirements/'.$request_requirement->id.'.'.$request_requirement->information);
                }
                $request_requirement->delete();
            }
            $request_service->delete();
        }
        $request->delete();
        ActivitiesController::log('Request was cancelled for '.$client->name.'.');
        return Redirect::route('requests.index')
                ->with('success', UtilsController::response('Completed!', 'Request cancelled successfully.'));
    }
    
    public function submit(BchRequest $request) {
        $request->update([
            'status' => 'Submitted',
            'employee_id' => UtilsController::getEmployee()->id,
            'request_date_time' => now()
        ]);
        BchRequestService::where('request_id', $request->id)->update(['status' => 'Open']);
        ActivitiesController::log('Request was submitted for '.$request->client->name.'.');
        return Redirect::route('requests.index')
                ->with('success', UtilsController::response('Completed!', 'Request submitted successfully.'));
    }
    
    public function billing() {
        $requests = BchRequest::where('status', 'Completed')->whereNull('invoice')->get();
        return view('requests.billing', compact('requests'));
    }
    
    public function invoice(BchRequest $request) {
        return view('requests.invoice', compact('request'));
    }
    
    public function attach_invoice(BchRequest $request, Request $req) {
        $request->update([
            'invoice' => $req->input('invoice')
        ]);
        ActivitiesController::log('Invoice was attached to request for '.$request->client->name.'.');
        return Redirect::route('requests.billing')
                ->with('success', UtilsController::response('Completed!', 'Invoice attached successfully.'));
    }
}

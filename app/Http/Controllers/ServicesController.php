<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use App\BchService;


class ServicesController extends Controller
{
    public function index() {
        $services = BchService::all();
        return view('services.index', compact('services'));
    }
    
    public function create() {
        return view('services.create');
    }
    
    public function store(Request $request) {
        $input = $request->input();
        $error = "";
        $existing_services = BchService::where('description', $input['description']);
        if ($existing_services->count() != 0) {
            $error .= "Service description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            $service = BchService::create($input);
            if ($service) {
                ActivitiesController::log('Service was created - '.$service->description.'.');
                return Redirect::route('services.index')
                        ->with('success', UtilsController::response('Successful!', 'Service has been created.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function edit(BchService $service) {
        return view('services.edit', compact('service'));
    }
    
    public function update(BchService $service, Request $request) {
        $input = $request->input();
        $error = "";
        $existing_services = BchService::where('description', $input['description'])->where('id', '<>', $service->id);
        if ($existing_services->count() != 0) {
            $error .= "Service description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            if ($service->update($input)) {
                ActivitiesController::log('Service was updated - '.$service->description.'.');
                return Redirect::route('services.index')
                        ->with('success', UtilsController::response('Successful!', 'Service has been updated.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function disable(BchService $service) {
        $input['active'] = false;
        $service->update($input);
        ActivitiesController::log('Service was disabled - '.$service->description.'.');
        return Redirect::route('services.index')
                ->with('success', UtilsController::response('Successful!', 'Service has been disabled.'));
    }
    
    public function enable(BchService $service) {
        $input['active'] = true;
        $service->update($input);
        ActivitiesController::log('Service was enabled - '.$service->description.'.');
        return Redirect::route('services.index')
                ->with('success', UtilsController::response('Successful!', 'Service has been enabled.'));
    }
}

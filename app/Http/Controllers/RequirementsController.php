<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use App\BchService;
use App\BchRequirement;

class RequirementsController extends Controller
{
    public function index(BchService $service) {
        $requirements = BchRequirement::where('service_id', $service->id)->get();
        return view('requirements.index', compact('requirements', 'service'));
    }
    
    public function create(BchService $service) {
        return view('requirements.create', compact('service'));
    }
    
    public function store(BchService $service, Request $request) {
        $input = $request->input();
        $error = "";
        $existing_requirements = BchRequirement::where('service_id', $service->id)->where('description', $input['description']);
        if ($existing_requirements->count() != 0) {
            $error .= "Requirement description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            $input['service_id'] = $service->id;
            $requirement = BchRequirement::create($input);
            if ($requirement) {
                ActivitiesController::log('Requirement was created - '.$requirement->description.'.');
                return Redirect::route('services.requirements.index', $service->slug())
                        ->with('success', UtilsController::response('Successful!', 'Requirement has been created.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function edit(BchService $service, BchRequirement $requirement) {
        return view('requirements.edit', compact('service', 'requirement'));
    }
    
    public function update(BchService $service, BchRequirement $requirement, Request $request) {
        $input = $request->input();
        $error = "";
        $existing_requirements = BchRequirement::where('service_id', $service->id)->where('description', $input['description'])->where('id', '<>', $requirement->id);
        if ($existing_requirements->count() != 0) {
            $error .= "Requirement description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            if ($requirement->update($input)) {
                ActivitiesController::log('Requirement was updated - '.$requirement->description.'.');
                return Redirect::route('services.requirements.index', $service->slug())
                        ->with('success', UtilsController::response('Successful!', 'Requirement has been updated.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function disable(BchService $service, BchRequirement $requirement) {
        $input['active'] = false;
        $requirement->update($input);
        ActivitiesController::log('Requirement was disabled - '.$requirement->plate_number.'.');
        return Redirect::route('services.requirements.index', $service->slug())
                ->with('success', UtilsController::response('Successful!', 'Requirement has been disabled.'));
    }
    
    public function enable(BchService $service, BchRequirement $requirement) {
        $input['active'] = true;
        $requirement->update($input);
        ActivitiesController::log('Requirement was enabled - '.$requirement->plate_number.'.');
        return Redirect::route('services.requirements.index', $service->slug())
                ->with('success', UtilsController::response('Successful!', 'Requirement has been enabled.'));
    }
}

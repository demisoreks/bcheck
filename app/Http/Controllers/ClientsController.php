<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use App\BchClient;

class ClientsController extends Controller
{
    public function index() {
        $clients = BchClient::all();
        return view('clients.index', compact('clients'));
    }
    
    public function create() {
        return view('clients.create');
    }
    
    public function store(Request $request) {
        $input = $request->input();
        $error = "";
        $existing_clients = BchClient::where('email', $input['email']);
        if ($existing_clients->count() != 0) {
            $error .= "Client email already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            $client = BchClient::create($input);
            if ($client) {
                ActivitiesController::log('Client was created - '.$client->name.'.');
                return Redirect::route('clients.index')
                        ->with('success', UtilsController::response('Successful!', 'Client has been created.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function edit(BchClient $client) {
        return view('clients.edit', compact('client'));
    }
    
    public function update(BchClient $client, Request $request) {
        $input = $request->input();
        $error = "";
        $existing_clients = BchClient::where('email', $input['email'])->where('id', '<>', $client->id);
        if ($existing_clients->count() != 0) {
            $error .= "Client email already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            if ($client->update($input)) {
                ActivitiesController::log('Client was updated - '.$client->name.'.');
                return Redirect::route('clients.index')
                        ->with('success', UtilsController::response('Successful!', 'Client has been updated.'));
            } else {
                return Redirect::back()
                        ->with('error', UtilsController::response('Unknown error!', 'Please contact administrator.'))
                        ->withInput();
            }
        }
    }
    
    public function disable(BchClient $client) {
        $input['active'] = false;
        $client->update($input);
        ActivitiesController::log('Client was disabled - '.$client->name.'.');
        return Redirect::route('clients.index')
                ->with('success', UtilsController::response('Successful!', 'Client has been disabled.'));
    }
    
    public function enable(BchClient $client) {
        $input['active'] = true;
        $client->update($input);
        ActivitiesController::log('Client was enabled - '.$client->name.'.');
        return Redirect::route('clients.index')
                ->with('success', UtilsController::response('Successful!', 'Client has been enabled.'));
    }
}

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$link_id = (int) config('var.link_id');

Route::get('/', [
    'as' => 'welcome', 'uses' => 'WelcomeController@index'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator']);

Route::get('investigators', [
    'as' => 'investigators.index', 'uses' => 'InvestigatorsController@index'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('investigators/{employee_id}/edit', [
    'as' => 'investigators.edit', 'uses' => 'InvestigatorsController@edit'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::post('investigators/store', [
    'as' => 'investigators.store', 'uses' => 'InvestigatorsController@store'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('investigators', function($value, $route) {
    return App\BchInvestigator::findBySlug($value)->first();
});

Route::get('services/{service}/disable', [
    'as' => 'services.disable', 'uses' => 'ServicesController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('services/{service}/enable', [
    'as' => 'services.enable', 'uses' => 'ServicesController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('services', 'ServicesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('services', function($value, $route) {
    return App\BchService::findBySlug($value)->first();
});

Route::get('services/{service}/requirements/{requirement}/disable', [
    'as' => 'services.requirements.disable', 'uses' => 'RequirementsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('services/{service}/requirements/{requirement}/enable', [
    'as' => 'services.requirements.enable', 'uses' => 'RequirementsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('services.requirements', 'RequirementsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('requirements', function($value, $route) {
    return App\BchRequirement::findBySlug($value)->first();
});

Route::get('clients/{client}/disable', [
    'as' => 'clients.disable', 'uses' => 'ClientsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::get('clients/{client}/enable', [
    'as' => 'clients.enable', 'uses' => 'ClientsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::resource('clients', 'ClientsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::bind('clients', function($value, $route) {
    return App\BchClient::findBySlug($value)->first();
});

Route::get('requests/{request}/cancel', [
    'as' => 'requests.cancel', 'uses' => 'RequestsController@cancel'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::get('requests/{request}/submit', [
    'as' => 'requests.submit', 'uses' => 'RequestsController@submit'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::get('requests/{request_service}/remove_service', [
    'as' => 'requests.remove_service', 'uses' => 'RequestsController@remove_service'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::post('requests/{request}/add_service', [
    'as' => 'requests.add_service', 'uses' => 'RequestsController@add_service'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::get('requests/{client}/initiate', [
    'as' => 'requests.initiate', 'uses' => 'RequestsController@initiate'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::resource('requests', 'RequestsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::bind('requests', function($value, $route) {
    return App\BchRequest::findBySlug($value)->first();
});

Route::post('tasks/{request_service}/mark_assigned', [
    'as' => 'tasks.mark_assigned', 'uses' => 'TasksController@mark_assigned'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Manager']);
Route::get('tasks/{request_service}/assign', [
    'as' => 'tasks.assign', 'uses' => 'TasksController@assign'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Manager']);
Route::get('tasks/new', [
    'as' => 'tasks.new', 'uses' => 'TasksController@new_tasks'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Manager']);
Route::get('tasks/pending', [
    'as' => 'tasks.pending', 'uses' => 'TasksController@pending'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Investigator,Manager']);
Route::get('tasks/{request_service}/treat', [
    'as' => 'tasks.treat', 'uses' => 'TasksController@treat'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Investigator']);
Route::post('tasks/{request_service}/complete', [
    'as' => 'tasks.complete', 'uses' => 'TasksController@complete'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Investigator']);
Route::bind('request_services', function($value, $route) {
    return App\BchRequestService::findBySlug($value)->first();
});
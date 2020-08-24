@extends('app', ['page_title' => config('app.name')])

<?php
use GuzzleHttp\Client;

if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];

$client = new Client();
$res = $client->request('GET', DB::table('acc_config')->whereId(1)->first()->master_url.'/api/getRoles', [
    'query' => [
        'username' => $halo_user->username,
        'link_id' => config('var.link_id')
    ]
]);
$permissions = json_decode($res->getBody());
?>
@section('content')
@include('commons.message')
<div class="row">
    <div class="col-12">
        <h4 class="page-header text-primary" style="border-bottom: 1px solid #999; padding-bottom: 20px; margin-bottom: 20px;">Task Management</h4>
    </div>
    @if (count(array_intersect($permissions, ['Manager'])) != 0)
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('tasks.new') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-tasks"></i></h1>
                    <h5 class="text-primary">Pending Tasks</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
    @if (count(array_intersect($permissions, ['Investigator'])) != 0)
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('tasks.pending') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-tasks"></i></h1>
                    <h5 class="text-primary">My Tasks</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
    @if (count(array_intersect($permissions, ['Admin', 'Investigator', 'Manager'])) != 0)
    <div class="col-12">
        <h4 class="page-header text-primary" style="border-bottom: 1px solid #999; padding-bottom: 20px; margin-bottom: 20px;">Client Management</h4>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('clients.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-users"></i></h1>
                    <h5 class="text-primary">Clients</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('requests.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-stream"></i></h1>
                    <h5 class="text-primary">Service Requests</h5>
                </div>
            </div>
        </a>
    </div>
    @if (count(array_intersect($permissions, ['Admin'])) != 0)
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('requests.billing') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-money-bill"></i></h1>
                    <h5 class="text-primary">Billing</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
    @endif
    @if (count(array_intersect($permissions, ['Admin'])) != 0)
    <div class="col-12">
        <h4 class="page-header text-primary" style="border-bottom: 1px solid #999; padding-bottom: 20px; margin-bottom: 20px;">Administration</h4>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('services.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-handshake"></i></h1>
                    <h5 class="text-primary">Services</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('investigators.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-user"></i></h1>
                    <h5 class="text-primary">Investigators</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
</div>
@endsection

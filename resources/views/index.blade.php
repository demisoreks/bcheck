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
    
</div>
@endsection
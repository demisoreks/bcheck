@extends('app', ['page_title' => 'Billing', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <strong>Completed Requests Not Yet Billed</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%"><strong>DATE/TIME INITIATED</strong></th>
                                    <th><strong>CLIENT INFORMATION</strong></th>
                                    <th width="20%"><strong>INITIATED BY</strong></th>
                                    <th width="20%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    
                                <tr>
                                    <td>{{ $request->created_at }}</td>
                                    <td>{{ $request->client->name }}<br />{{ $request->client->mobile_no }}<br />{{ $request->client->email }}</td>
                                    <td>{{ App\AccEmployee::whereId($request->employee_id)->first()->username }}</td>
                                    <td><a class="btn btn-primary btn-block btn-sm" href="{{ route('requests.invoice', [$request->slug()]) }}"><i class="fas fa-paperclip"></i> Attach Invoice</a></td>
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
@extends('app', ['page_title' => 'Investigator List', 'open_menu' => 'reports'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>INVESTIGATORS BY COMPETENCY</strong>
            </div>
            <div class="card-body bg-white">
                {!! $competency_chart->container() !!}
                {!! $competency_chart->script() !!}
            </div>
        </div>
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>LIST OF INVESTIGATORS</strong>
            </div>
            <div class="card-body bg-white">
                <table id="myTable4" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>NAME</strong></th>
                            <th><strong>GENDER</strong></th>
                            <th><strong>MOBILE NUMBER</strong></th>
                            <th><strong>ALTERNATE NUMBER</strong></th>
                            <th><strong>REGION</strong></th>
                            <th><strong>COMPETENCIES</strong></th>
                            <th><strong>BANK</strong></th>
                            <th><strong>ACCOUNT NUMBER</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($investigators as $investigator)
                        <tr>
                            <td>{{ $investigator->first_name.' '.$investigator->first()->surname }}</td>
                            <td>{{ $investigator->gender }}</td>
                            <td>{{ $investigator->first()->phone1 }}</td>
                            <td>{{ $investigator->first()->phone2 }}</td>
                            <td>{{ $investigator->first()->region }}</td>
                            <td>
                                @foreach (explode(',', str_replace(['[', ']'], '', $investigator->first()->competencies)) as $c)
                                @if (App\BchService::find((int) str_replace('"', '', $c))) {{ App\BchService::find((int) str_replace('"', '', $c))->description }} @endif<br />
                                @endforeach
                            </td>
                            <td>{{ $investigator->first()->bank }}</td>
                            <td>{{ $investigator->first()->account_number }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

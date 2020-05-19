@extends('app', ['page_title' => 'Investigators', 'open_menu' => 'settings'])

@section('content')
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <strong>Active</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th><strong>USERNAME</strong></th>
                                    <th><strong>NAME</strong></th>
                                    <th><strong>PICTURE</strong></th>
                                    <th><strong>GENDER</strong></th>
                                    <th><strong>MOBILE NUMBER</strong></th>
                                    <th><strong>ALTERNATE NUMBER</strong></th>
                                    <th><strong>REGION</strong></th>
                                    <th><strong>COMPETENCIES</strong></th>
                                    <th><strong>BANK</strong></th>
                                    <th><strong>ACCOUNT NUMBER</strong></th>
                                    <th data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($investigators as $investigator)
                                <?php
                                $inv = App\BchInvestigator::where('employee_id', $investigator->id);
                                ?>
                                <tr>
                                    <td>{{ $investigator->username }}</td>
                                    <td>@if ($inv->count() > 0) {{ $inv->first()->first_name.' '.$inv->first()->surname }} @endif</td>
                                    <td class="text-center">@if ($inv->count() > 0) @if (File::exists('storage/pictures/'.$inv->first()->id.'.jpg')) {{ Html::image('storage/pictures/'.$inv->first()->id.'.jpg', 'Investigator\'s picture', ['height' => '100px', 'class' => 'rounded-circle']) }} @endif @endif</td>
                                    <td>@if ($inv->count() > 0) {{ $inv->first()->gender }} @endif</td>
                                    <td>@if ($inv->count() > 0) {{ $inv->first()->phone1 }} @endif</td>
                                    <td>@if ($inv->count() > 0) {{ $inv->first()->phone2 }} @endif</td>
                                    <td>@if ($inv->count() > 0) {{ $inv->first()->region }} @endif</td>
                                    <td>
                                        @if ($inv->count() > 0)
                                        @foreach (explode(',', str_replace(['[', ']'], '', $inv->first()->competencies)) as $c)
                                        @if (App\BchService::find((int) str_replace('"', '', $c))) {{ App\BchService::find((int) str_replace('"', '', $c))->description }} @endif<br />
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>@if ($inv->count() > 0) {{ $inv->first()->bank }} @endif</td>
                                    <td>@if ($inv->count() > 0) {{ $inv->first()->account_number }} @endif</td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('investigators.edit', [$investigator->slug()]) }}"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr
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
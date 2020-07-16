<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccEmployee;
use App\AccEmployeeRole;
use App\AccRole;
use App\BchInvestigator;
use App\BchService;
use App\Charts\BCheckChart;

class ReportsController extends Controller
{
    public function investigators() {
        $investigators = BchInvestigator::whereIn('employee_id', AccEmployee::where('active', true)->whereIn('id', AccEmployeeRole::where('role_id', AccRole::where('privileged_link_id', config('var.link_id'))->where('title', 'Investigator')->where('active', true)->first()->id)->pluck('employee_id')->toArray())->pluck('id')->toArray())->get();

        $competency_chart = new BCheckChart();
        $competency_labels = [];
        $competency_counts = [];
        foreach (BchService::where('active', true)->get() as $service) {
            array_push($competency_labels, $service->description);
            $count = 0;
            foreach ($investigators as $investigator) {
                $competencies = explode(",", $investigator->competencies);
                if (in_array($service->id, $competencies)) {
                    $count ++;
                }
            }
            array_push($competency_counts, $count);
        }
        $competency_chart->labels($competency_labels)->dataset('No. of Investigators', 'bar', $competency_counts);

        return view('reports.investigators', compact('investigators', 'competency_chart'));
    }
}

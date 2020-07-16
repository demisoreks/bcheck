<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Image;
use Storage;
use Redirect;
use App\AccEmployee;
use App\AccEmployeeRole;
use App\AccRole;
use App\BchInvestigator;

class InvestigatorsController extends Controller
{
    public function index() {
        $investigators = AccEmployee::where('active', true)->whereIn('id', AccEmployeeRole::where('role_id', AccRole::where('privileged_link_id', config('var.link_id'))->where('title', 'Investigator')->where('active', true)->first()->id)->pluck('employee_id')->toArray())->get();
        return view('investigators.index', compact('investigators'));
    }

    public function edit($employee_slug) {
        $employee = AccEmployee::findBySlug($employee_slug);
        return view('investigators.edit', compact('employee'));
    }

    public function store(Request $request) {
        $input = $request->input();
        $error = "";
        if ($request->hasFile('picture')) {
            if (!in_array($request->file('picture')->getClientOriginalExtension(), ['jpg'])) {
                $error .= "Invalid file type. Only jpg is allowed.<br />";
            }
            if ($request->file('picture')->getSize() > 1048576) {
                $error .= "File too large. File must be less than 1MB.<br />";
            }
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', UtilsController::response('Oops!', $error))
                    ->withInput();
        } else {
            unset($input['picture']);
            $input['competencies'] = implode(",", $input['competencies']);
            $employee = AccEmployee::where('username', $input['username'])->first();
            $investigators = BchInvestigator::where('employee_id', $employee->id);
            unset($input['username']);
            if ($investigators->count() == 0) {
                $input['employee_id'] = $employee->id;
                $investigator = BchInvestigator::create($input);
                if (!$investigator) {
                    return Redirect::route('investigators.index')
                            ->with('error', UtilsController::response('Cannot create investigator!', 'Please contact administrator.'));
                }
            } else {
                $investigator = $investigators->first();
                if (!$investigator->update($input)) {
                    return Redirect::route('investigators.index')
                            ->with('error', UtilsController::response('Cannot update investigator!', 'Please contact administrator.'));
                }
            }
            if ($request->hasFile('picture')) {
                $img = Image::make($request->file('picture')->getRealPath());
                if ($img->width() > $img->height()) {
                    $img->resize(null, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $img->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $img->crop(300, 300);
                Storage::put('public/pictures/'.$investigator->id.'.jpg', $img->encode());
            }
            return Redirect::route('investigators.index')
                    ->with('success', UtilsController::response('Successful!', 'Investigator has been updated.'));
        }
    }
}

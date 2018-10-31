<?php

namespace App\Http\Controllers;

use App\Course;
use App\VueTables\EloquentVueTables;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function courses(){
        return view('admin.courses');
    }

    public function coursesJson(){
        if(request()->ajax()) {
            $vueTables = new EloquentVueTables();
            $data = $vueTables->get(new Course, ['id', 'name', 'status'], ['reviews']);
            //$data = dd($data);
            return response()->json($data);
        }
        return abort(401);

    }
}

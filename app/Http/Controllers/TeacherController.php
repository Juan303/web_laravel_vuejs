<?php

namespace App\Http\Controllers;

use App\Mail\MessageToStudent;
use App\Student;
use App\User;
use App\Course;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;

class TeacherController extends Controller
{
    public function courses(){
        $courses = Course::withCount(['students'])
            ->with('category', 'reviews')
            ->where('teacher_id', auth()->user()->teacher->id)
            ->paginate(4);
        return view('teachers.courses')->with(compact('courses'));
    }
    public function students(){
        $students = Student::with('user', 'courses.reviews')
            ->whereHas('courses', function($q){
                $q->where('teacher_id', auth()->user()->teacher->id)->select('teacher_id', 'name')->withTrashed();
            })->get();

        $actions = 'students.datatables.actions';
        //raw columns respeta el HTML que lo carga de la vista de la linea de arriba
        return \DataTables::of($students)->addColumn('actions', $actions)->rawColumns(['actions', 'courses_formatted'])->make(true);
    }
    public function sendMessageToStudent(Request $request){
        $info = $request->get('info');
        $data = [];
        parse_str($info, $data);
        $user = User::findOrFail($data['user_id']);
        $success = true;
        try{
            \Mail::to($user)->send(new MessageToStudent(auth()->user()->name, $data['message']));
        }catch(\Exception $exception){
            $success = false;
        }
        return  response()->json(['res' => $success]);
    }

}

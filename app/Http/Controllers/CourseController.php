<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CourseRequest;
use App\Review;
use Illuminate\Http\Request;

use App\Course;
use App\Mail\NewStudentInCourse;

class CourseController extends Controller
{
    public function show(Course $course){
        $course->load([
            'category' => function($q){
                $q->select('id', 'name');
            },
            'goals' => function($q){
                $q->select('id', 'course_id', 'goal');
            },
            'level' => function($q) {
                $q->select('id', 'name');
            },
            'requirements' => function($q){
                $q->select('id', 'course_id', 'requirement');
            },
            'reviews.user',
            'teacher'
        ])->get();

        $related = $course->relatedCourses();

        return view('courses.detail', compact('course', 'related'));
    }

    public function inscribe(Course $course){

        $course->students()->attach(auth()->user()->student->id);
        \Mail::to($course->teacher->user)->send(new NewStudentInCourse($course, auth()->user()->name));
        return back()->with('message', ['type'=>'success','text' => __('Inscrito correctamente al curso')]);

    }

    public function subscribed(){
        $courses = Course::whereHas('students', function($q){
            $q->where('user_id', auth()->id());
        })->get();
        //lo de arriba seria igual a esto tambien
        //$courses = auth()->user()->student->courses;
        return view('courses.subscribed')->with(compact('courses'));
    }

    public function addReview(Request $request){
        Review::create([
            'user_id' => auth()->id(),
            'course_id' => $request->get('course_id'),
            'rating' => (int) $request->get('rating_input'),
            'comment' => $request->get('message')
        ]);

        return back()->with('message', ['type' => 'success', 'text' => __('Gracias por valorar el curso')]);
    }

    //CRUD
    public function create(){
        $course = new Course;
        $btnText = __("Enviar curso para revision");
        return view('courses.form')->with(compact('course', 'btnText'));
    }

    public function store(CourseRequest $course_request){
        $image = Helper::uploadFile('image', 'courses');

        //Esto sirve para formatear adecuadamente el request y luego poder insertarlo de golpe en la base de datos
        $course_request->merge(['image' => $image]);
        $course_request->merge(['teacher_id' => auth()->user()->teacher->id]);
        $course_request->merge(['status' => Course::PENDING]);

        //asignacion masiva de los campos input del formulario
        //Los requisitos y las metas se añaden automaticamente cuando se actualiza o se crea el curso (mediante eventos)e
        Course::create($course_request->input());

        return back()->with('message', ['type' => 'success', 'text' => __('Curso enviado correctamente. En breve recibirá un mail con información')]);
    }
    public function edit($slug){
        $course = Course::with(['requirements', 'goals'])->withCount('requirements', 'goals')->where('slug', $slug)->first();
        $btnText = __('Actualizar curso');
        return view('courses.form')->with(compact('course','btnText'));
    }

    public function update(CourseRequest $courseRequest, Course $course){
        if($courseRequest->hasFile('image')){
            \Storage::delete('courses/', $course->image);
            $image = Helper::uploadFile('image', 'courses');
            $courseRequest->merge(['image'=> $image]);
        }
        $course->fill($courseRequest->input())->save();
        return back()->with('message', ['type'=>'success', 'text'=> __('El curso ha sido actualizado correctamente')]);
    }

    public function destroy(Course $course){
        try{
            $course->delete();
            return back()->with('message', ['type' => 'success', 'text' => __('El curso se ha eliminado correctamente')]);
        }
        catch (\Exception $exception){
            return back()->with('message', ['type' => 'danger', 'text' => $exception->getMessage()]);
        }

    }

}

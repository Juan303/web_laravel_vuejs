@component('mail::message')
# {{ __('Nuevo estudiante en tu curso') }}
{{ __('El estudiante :student se ha inscrito en tu curso :course, FELICIDADES', ['student'=>$student, 'course'=> $course->name]) }}
<img src="{{ url('storage/courses/'.$course->image) }}" class="img-responsive" alt="{{ $course->name }}">

@component('mail::button', ['url' => url('/courses/'.$course->slug)])
    {{ __('Ir al curso') }}
@endcomponent

{{ __('Gracias') }},<br/>
{{ config('app.name') }}
@endcomponent
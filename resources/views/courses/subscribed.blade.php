@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron', ['title' => 'Cursos a los que me he suscrito', 'icon' => 'table'])
@endsection

@section('content')
    <div class="pl-5, pr-5">
        <div class="row justify-content-center">
            @forelse($courses as $course)
                <div class="col-md-3">
                    @include('partials.courses.card_course')
                </div>
            @empty
                <div class="alert-dark alert">{{ __('Aún no te has suscrito a ningún curso') }}</div>
            @endforelse
        </div>
    </div>
@endsection
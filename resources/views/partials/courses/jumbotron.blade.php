<div class="row mb-4">
    <div class="col-md-12">
        <div class="card" style="background-image: url('{{ asset('images/jumbotron.png') }}')">
            <div class="my-5 py-5 px-4 align-items-center d-flex text-center text-white">
                <div class="col-5">
                    <img src="{{ $course->pathAttachment() }}" class="img-fluid" alt="imagen {{ $course->name }}">
                </div>
                <div class="col-5 text-left">
                    <h1>{{ __('Curso') }}: {{ $course->name }}</h1>
                    <h4>{{ __('Profesor') }}: {{ $course->teacher->user->name}} </h4>
                    <h4>{{__('Categoria')}}: {{ $course->category->name }}</h4>
                    <h5>{{__('Fecha de publicación')}}: {{ $course->created_at->format('d/m/Y') }}</h5>
                    <h5>{{__('Ultima actualización')}}: {{ $course->updated_at->format('d/m/Y') }}</h5>
                    <h6>{{__('Estudiantes inscritos')}}: {{ $course->students_count }}</h6>
                    <h6>{{__('Número de valoraciones')}}: {{ $course->reviews_count }}</h6>
                    @include('partials.courses.rating', ['rating'=>$course->rating])
                </div>

                @include('partials.courses.action_button')

            </div>
        </div>
    </div>
</div>
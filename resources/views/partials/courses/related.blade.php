<div class="col-12 pt-0 mt-4">
    <h2 class="text-muted">
        {{ __('Cursos similares') }}
    </h2>
    <hr />
</div>
<div class="container-fluid">
    <div class="row">
        @forelse($related as $relatedCourse)
           {{-- <div class="col-md-3">
                @include('partials.courses.card_course', ['course' => $relatedCourse])
            </div>--}}

            <div class="col-md-5 listing-block">
                <div class="media">
                    <div class="fav-box">
                        <i class="fa fa-hearth-o" aria-hidden="true"></i>
                    </div>
                    <a href="{{ route('course.detail', $relatedCourse->slug) }}">
                        <img src="{{ $relatedCourse->pathAttachment() }}" class="d-flex align-self-start img-fluid" alt="{{ $relatedCourse->name }}">
                    </a>
                    <div class="media-body pl-3">
                        <div class="price">
                            <small>{{ $relatedCourse->name }}</small>
                        </div>
                        <div class="stats">
                            @include('partials.courses.rating', ['rating' => $relatedCourse->rating])
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-dark">
                {{ __('No existe ningún curso similar') }}
            </div>
        @endforelse
    </div>
</div>
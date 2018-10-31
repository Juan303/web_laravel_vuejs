@cannot('inscribe', $course)
    @can('review', $course)
        <div class="col-12 pt-0 mt-0 text-center">
            <h2 class="text-muted">
                {{ __('Escribe una valoración') }}
            </h2>
            <hr />
        </div>
        <div class="container-fluid">
            <form id="rating_form" class="form-inline justify-content-center" action="{{ route('course.add_review') }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="col-12">
                        <ul id="list_rating" class="list-inline" style="font-size: 40px">
                            <li class="list-inline-item star" data-number="1"><i class="fa fa-star yellow"></i></li>
                            <li class="list-inline-item star" data-number="2"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item star" data-number="3"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item star" data-number="4"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item star" data-number="5"><i class="fa fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                <br />
                <input type="hidden" name="rating_input" value="1" />
                <input type="hidden" name="course_id" value="{{ $course->id }}" />
                <div class="form-group">
                    <div class="col-12">
                        <textarea class="form-control" placeholder="{{ __('Escribe una reseña') }}" name="message" id="message" cols="100" rows="8"></textarea>
                    </div>
                </div>
                <button class="btn btn-warning text-white">
                    <i class="fa fa-space-shuttle"></i> {{ __('Valorar curso') }}
                </button>
            </form>
        </div>
    @endcan
@endcannot

@push('scripts')
    <script>
       $(document).ready(function(){
           $('.fa-star').click(function(){
               const number = $(this).parent('li').data('number');
               $('input[name=rating_input]').val(number);
               $('#list_rating').find('li i').removeClass('yellow').each(function(){
                   if($(this).parent('li').data('number')<= number){
                       $(this).addClass('yellow')
                   }
               });
           })
       })
    </script>
@endpush
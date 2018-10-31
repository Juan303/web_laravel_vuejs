@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron', ['title' => 'Configurar tu perfil', 'icon' => 'user-circle'])
@endsection

@push('styles')
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Actualiza tus datos') }}
                    </div>
                    <div class="card-body">
                        <form method="post" class="" action="{{ route('profile.update') }}" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-light">{{ __('Correo electrónico') }}</label>
                                <div class="col-md-6">
                                    <input type="email" id="email" readonly class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required autofocus>
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label text-md-light">{{ __('Contraseña') }}</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    @if($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-sm-4 col-form-label text-md-light">{{ __('Confirmar contraseña') }}</label>
                                <div class="col-md-6">
                                    <input type="password" id="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>
                                    @if($errors->has('password_confirmation'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mb-0 row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Actualizar datos') }}</button>
                                </div>
                              </div>

                        </form>
                    </div>
                </div>
                @if( ! $user->teacher)
                    <div class="card">
                        <div class="card-header">
                            {{ __('Convertirme en profesor') }}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('solicitude.teacher') }}" class="" method="post">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-block">
                                    <i class="fa fa-graduation-cap"></i> {{ __('Solicitar') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            {{ __('Administrar mis cursos') }}
                        </div>
                        <div class="card-body">
                            <a href="{{ route('teacher.courses') }}" class="btn btn-secondary btn-block">
                                <i class="fab fa-leanpub"></i> {{ __('Administrar ahora') }}
                            </a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ __('Mis estudiantes') }}
                        </div>
                        <div class="card-body">
                           <table class="table table-striped table-bordered nowrap" cellpadding="0" id="students-table">
                               <thead>
                                   <tr>
                                       <th>{{ __('ID') }}</th>
                                       <th>{{ __('Nombre') }}</th>
                                       <th>{{ __('Email') }}</th>
                                       <th>{{ __('Cursos') }}</th>
                                       <th>{{ __('Acciones') }}</th>
                                   </tr>
                               </thead>
                           </table>
                        </div>
                    </div>
                @endif
                @if($user->social_account)
                    <div class="card">
                        <div class="card-header">
                            {{ __('Acceso con Socialite') }}
                        </div>
                        <div class="card-body">
                            <button class="btn btn-outline-dark btn-block">
                                {{ __('Registrado con') }}: <i class="fab fa-{{ $user->social_account->provider }}"></i>
                                {{ $user->social_account->provider }}
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('partials.modal')
@endsection

@push('scripts')
    <script src="http://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        let dt;
        let modal= $('#appModal');
        $(document).ready(function(){
            dt = $('#students-table').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 75, 100],
                procesing: true,
                serverSide: true,
                ajax: '{{ route('teacher.students') }}',
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
                },
                columns: [
                    {data: 'user.id', visible:false},
                    {data: 'user.name'},
                    {data: 'user.email'},
                    {data: 'courses_formatted'},
                    {data: 'actions'},
                ]
            });
            $(document).on('click', '.btnEmail', function(e){
                e.preventDefault();
                const id = $(this).data('id');
                const name = $(this).data('name');
                modal.find('.modal-title').text('{{__('Enviar mensaje a ')}}'+name);
                modal.find('#modalAction').text('{{__('Enviar mensaje')}}').show();
                let $form = $('<form id="studentMessage"></form>');
                $form.append(`<input type="hidden" name="user_id" value="${id}" />`);
                $form.append(`<textarea class="form-control" name="message"></textarea>`);
                modal.find('.modal-body').html($form);
                modal.modal('show');
            });
            $('#modalAction').click(function(e){
               e.preventDefault();
               $.ajax({
                   url: '{{ route('teacher.send_message_to_student') }}',
                   type: 'post',
                   headers: {
                       'x-csrf-token': $("meta[name=csrf-token]").attr("content")
                   },
                   data: {
                       info: $("#studentMessage").serialize()
                   },
                   success: (res) =>{
                       if(res.res){
                           modal.find("#modalAction").hide();
                           modal.find('.modal-body').html('<div class="alert alert-success">{{ __('Mensaje enviado correctamente') }}</div>');
                       }
                       else{
                           modal.find('.modal-body').html('<div class="alert alert-danger">{{ __('Error al enviar el mensaje') }}</div>');
                       }
                   }
               })
            });
        });
    </script>
@endpush
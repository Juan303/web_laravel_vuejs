@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron', ['title' => 'Dar de alta un nuevo curso', 'icon' => 'edit']);
@endsection

@section('content')
    <div class="pl-5 pr-5">
        <form action="{{ !$course->id ? route('courses.store'): route('courses.update', ['slug' => $course->slug]) }}" method="post" novalidate enctype="multipart/form-data">
            @csrf
            @if($course->id)
                @method('put')
            @endif
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Informacion del curso') }}
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del curso') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="name" name="name" class="form-control{{$errors->has('name') ? ' is-invalid' : ''}}" value="{{ old('name', $course->name) }}" required autofocus>
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="level_id" class="col-md-4 col-form-label text-md-right">{{ __('Nivel del curso') }}</label>
                                <div class="col-md-6">
                                    <select name="level_id" id="level_id" class="form-control">
                                        @foreach(\App\Level::pluck('id', 'name') as $name => $id)
                                            <option {{ ((int)old('level_id') === $id || $course->level_id === $id) ? 'selected' : ''  }} value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                                <div class="col-md-6">
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach(\App\Category::groupBy('name')->pluck('name', 'id') as $id => $name)
                                            <option {{ ((int)old('category_id') === $id || $course->category_id === $id) ? 'selected' : ''  }} value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ml-3 mr-2">
                                <div class="col-md-6 offset-4">
                                    <input type="file" class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" name="image">
                                    <label for="image" class="custom-file-label">{{ __('Selecciona una imagen para tu curso') }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion del curso') }}</label>
                                <div class="col-md-6">
                                    <textarea required name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" cols="30" rows="6">{{ old('description', $course->description) }}</textarea>
                                    @if($errors->has('description'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Requisitos del curso') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="requirement1" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Requisito 1') }}
                                </label>
                                <div class="col-md-6">
                                    <input
                                       type="text"
                                       id="requirement1"
                                       class="form-control{{ $errors->has('requirements.0') ? ' is-invalid' : '' }}"
                                       name="requirements[]"
                                       value="@if(old('requirements.0')) {{ old('requirements.0') }} @elseif($course->requirements_count > 0) {{ $course->requirements[0]->requirement }} @else {{ '' }} @endif"
                                    />
                                    @if($errors->has('requirements.0'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('requirements.0') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if($course->requirement_count > 0)
                                    <input type="hidden" name="requirement_id0" value="{{ $course->requirements[0]->id }}">
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="requirement2" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Requisito 2') }}
                                </label>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        id="requirement2"
                                        class="form-control{{ $errors->has('requirements.1') ? ' is-invalid' : '' }}"
                                        name="requirements[]"
                                        value="@if(old('requirements.1')) {{ old('requirements.1') }} @elseif($course->requirements_count > 1) {{ $course->requirements[1]->requirement }} @else {{ '' }} @endif"
                                    />
                                    @if($errors->has('requirements.1'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('requirements.1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if($course->requirement_count > 1)
                                    <input type="hidden" name="requirement_id1" value="{{ $course->requirements[1]->id }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Metas del curso') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="goal" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Meta 1') }}
                                </label>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        id="goal"
                                        class="form-control{{ $errors->has('goals.0') ? ' is-invalid' : '' }}"
                                        name="goals[]"
                                        value="@if(old('goals.0')) {{ old('goals.0') }} @elseif($course->goals_count > 0) {{ $course->goals[0]->goal }} @else {{ '' }} @endif"
                                    >
                                    @if($errors->has('goals.0'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('goals.0') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if($course->goal_count > 0)
                                    <input type="hidden" name="goal_id0" value="{{ $course->goals[0]->id }}">
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="goal1" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Meta 2') }}
                                </label>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        id="goal1"
                                        class="form-control{{ $errors->has('goals.1') ? ' is-invalid' : '' }}"
                                        name="goals[]"
                                        value="@if(old('goals.1')) {{ old('goals.1') }} @elseif($course->goals_count > 1) {{ $course->goals[1]->goal }} @else {{ '' }} @endif"
                                    >
                                    @if($errors->has('goals.1'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('goals.1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if($course->goal_count > 1)
                                    <input type="hidden" name="goal_id1" value="{{ $course->goals[1]->id }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body text-center">
                            <button type="submit" name="revision" class="btn btn-danger">{{ __($btnText) }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
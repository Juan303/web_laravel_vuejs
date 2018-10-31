<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- parte izquierda -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                    </li>

                </ul>
                <!-- parte derecha -->
                <ul class="navbar-nav ml-auto">
                    @if(auth()->user())
                        @include('partials.navigations.logged')
                    @else
                        @include('partials.navigations.guest')
                    @endif

                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Idioma') }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('set_language', ['es'])  }}">{{ __("Español") }}</a>
                                <a class="dropdown-item" href="{{ route('set_language', ['en']) }}">{{ __("Ingles") }}</a>
                            </div>
                        </div>


                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>
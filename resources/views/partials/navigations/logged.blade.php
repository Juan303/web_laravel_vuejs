<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ auth()->user()->name }} <span class="caret"></span>
    </a>
    <div class="dropdown-menu" v-bind:aria-labelledby="navbarDropdown">
        @include('partials.navigations.' . \App\User::navigation())
        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Cerrar sesión') }}

        </a>
        <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
            @csrf
        </form>


    </div>
</li>
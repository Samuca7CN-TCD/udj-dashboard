<nav>
    <div class="nav-wrapper container">
        <a href="#" class="brand-logo">
            <img src="{{ asset('storage/logo/udj.svg') }}" />
        </a>
        <ul id="nav" class="right">
        @if (Route::has('register') && Auth::check())
            <li title="Botão ainda não implementado">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a :href="route('logout-register')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Registrar novo usuário') }}
                    </a>
                </form>
            </li>
        @endif
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="orange-text">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </li>
        </ul>
    </div>
</nav>
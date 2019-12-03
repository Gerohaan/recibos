<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                <h5 class="my-0 mr-md-auto font-weight-normal">Sistema de Autogestón de RRHH</h5>
                    <nav class="my-2 my-md-0 mr-md-3">
                    @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                                <a href="{{ url('/home') }}">Home</a>
                            @else
                                <a href="{{ route('login') }}">Login</a>
                            @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a>
                            @endif
                            @endauth
                        </div>
                    @endif
                    </nav>
                <a class="btn btn-outline-primary" href="#">Ingresar</a>
</div>
<nav class="navbar navbar-expand-lg">
                    <div class="container">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <i class="bi-back"></i>
                            <span>{{env('APP_NAME')}}</span>
                        </a>

                        <div class="d-lg-none ms-auto me-4">
                            @guest
                                <div class="d-flex align-items-center">
{{--                                    <a href="{{ route('login') }}" class="nav-link fw-bold me-3">Login</a>--}}
                                    <a href="{{ route('login') }}" class="btn custom-btn btn-sm">Book Now</a>
                                </div>
                            @else
                                <div class="dropdown">
                                    <a href="#" class="navbar-icon bi-person" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li><span class="dropdown-item-text">{{ Auth::user()->name }}</span></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endguest
                        </div>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ url('/') }}">Home</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#section_2">Rooms</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#section_3">Contact</a>
                                </li>
                            </ul>

                            <div class="d-none d-lg-block">
                                @guest
                                    <div class="d-flex align-items-center">
{{--                                        <a href="{{ route('login') }}" class="nav-link fw-bold me-3">Login</a>--}}
                                        <a href="{{ route('login') }}" class="btn custom-btn btn-sm">Book Now</a>
                                    </div>
                                @else
                                    <div class="dropdown">
                                        <a href="#" class="navbar-icon bi-person" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li><span class="dropdown-item-text">{{ Auth::user()->name }}</span></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                                document.getElementById('logout-form-desktop').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </nav>

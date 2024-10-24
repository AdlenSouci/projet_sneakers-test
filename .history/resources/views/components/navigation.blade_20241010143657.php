<nav class="navbar navbar-expand-lg navbar-light shadow bg-custom">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand text-success logo h1 align-self-center" href="{{ route('index') }}">
            Zay
        </a>

        <!-- Toggler Button for mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">{{ __('Accueil') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">{{ __('À propos') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop') }}">{{ __('Boutique') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.form') }}">{{ __('Contact') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Right section: search, cart, user -->
            <div class="navbar align-self-center d-flex">
                <!-- Search form for small screens -->
                <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                    <form action="{{ route('search') }}" method="GET" class="input-group">
                        <input type="search" name="query" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                        <div class="input-group-text">
                            <i class="fa fa-fw fa-search"></i>
                        </div>
                    </form>
                </div>

                <!-- Search icon for larger screens -->
                <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                    <i class="fa fa-fw fa-search text-dark mr-2"></i>
                </a>

                <!-- Cart icon -->
                <a class="nav-icon position-relative text-decoration-none" href="{{ route('basket') }}">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">
                        {{ Cart::count() }}
                    </span>
                </a>

                <!-- User icon or login link -->
                @auth
                <a class="nav-icon position-relative text-decoration-none" href="{{ route('profile.edit') }}">
                    <i class="fa fa-fw fa-user text-dark mr-3"></i>
                    <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">
                        {{ Auth::user()->name }}
                    </span>
                </a>
                @else
                <a class="nav-icon position-relative text-decoration-none" href="{{ route('login') }}">
                    <i class="fa fa-fw fa-user text-dark mr-3"></i>
                    <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">Login</span>
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@vite (['resources/css/fontawesome.css', 'resources/css/fontawesome.min.css', 'resources/css/templatemo.css', 'resources/css/'])

<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-success logo h1 align-self-center" href="{{ route('index') }}">
            Zay
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <x-nav-link :href="route('index')" :active="request()->routeIs('index')" class="nav-link">
                            {{ __('Accueil') }}
                        </x-nav-link>
                    </li>
                    <li class="nav-item">
                        <x-nav-link :href="route('about')" :active="request()->routeIs('about')" class="nav-link">
                            {{ __('À propos') }}
                        </x-nav-link>
                    </li>
                    <li class="nav-item">
                        <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')" class="nav-link">
                            {{ __('Boutique') }}
                        </x-nav-link>
                    </li>
                    <li class="nav-item">
                        <x-nav-link :href="route('basket')" :active="request()->routeIs('basket')" class="nav-link">
                            {{ __('Panier') }}
                        </x-nav-link>
                    </li>
                    <li class="nav-item">
                        <x-nav-link :href="route('contact.form')" :active="request()->routeIs('contact.form')" class="nav-link">
                            {{ __('Contact') }}
                        </x-nav-link>
                    </li>
                    @guest
                    <li class="nav-item">
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="nav-link">
                            {{ __('Connexion') }}
                        </x-nav-link>
                    </li>
                    @endguest
                </ul>
            </div>

            <div class="navbar align-self-center d-flex">
                @guest
                <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                @else
                <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                    <i class="fa fa-fw fa-search text-dark mr-2"></i>
                </a>
                <a class="nav-icon position-relative text-decoration-none" href="#">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">7</span>
                </a>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="nav-icon position-relative text-decoration-none" aria-label="User Menu">
                            <i class="fa fa-fw fa-user text-dark mr-3"></i>
                            <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">+99</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endguest
            </div>
        </div>
    </div>
</nav>

@vite([
    'resources/css/custom.css',
    'resources/css/fontawesome.css',
    'resources/css/fontawesome.min.css',
    'resources/css/templatemo.css',
    'resources/css/templatemo.min.css',
    'resources/css/bootstrap.min.css', 
    'js/jquery-1.11.0.min.js,
])

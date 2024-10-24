<nav x-data="{ open: false }" class="navbar navbar-expand-lg navbar-light shadow bg-light">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- Logo -->
        <a class="navbar-brand text-success logo h1 align-self-center" href="{{ route('index') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>

        <!-- Hamburger -->
        <button @click="open = ! open" class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div :class="{'collapse': !open, 'show': open}" class="collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="navbarNav">
            <div class="flex-fill">
                <ul class="navbar-nav d-flex justify-content-between mx-lg-auto">
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
                </ul>
            </div>

            <!-- User Icons and Search -->
            <div class="navbar align-self-center d-flex">
                @guest
                <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                @else
                <div class="d-flex align-items-center">
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
                </div>
                @endguest
            </div>
        </div>
    </div>
    @vite(['resources/css/custom.css',
    'resources/css/fontawesome.css',
    'resources/css/fontawesome.min.css',
    'resources/css/templatemo.css',
    'resources/css/templatemo.min.css',
    'resources/css/bootstrap.min.css',
    'resources/css/slick-thre.css',])
</nav>
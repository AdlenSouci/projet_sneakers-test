<nav x-data="{ open: false }" class="navbar navbar-expand-lg navbar-light shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div>
                    <a href="{{ route('index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('index')" :active="request()->routeIs('index')">
                        {{ __('Accueil') }}
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('À propos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                        {{ __('Boutique') }}
                    </x-nav-link>
                    <x-nav-link :href="route('basket')" :active="request()->routeIs('basket')">
                        {{ __('Panier') }}
                        <!--ajout d'un compteur d'article present dans le panier-->
                   
                        <span class="badge rounded-pill bg-danger" id="countArticle">{{ session('totalItems', 0) }}</span>
                    </x-nav-link>


                    <x-nav-link :href="route('contact.form')" :active="request()->routeIs('contact.form')">
                        {{ __('Contact') }}
                    </x-nav-link>




                    <!-- Hide these links if the user is authenticated -->
                    @guest
                    <!--<x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Inscription') }}
                        </x-nav-link>-->
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Connexion') }}
                    </x-nav-link>
                    @endguest

                    @if(Request::url() == url('/shop') || Request::url() == url('/search'))

                    <form class="d-flex ms-auto align-items-center spacing-horizontal" role="search" action="{{ route('search') }}" method="GET">
                        <input class="form-control me-2 custom-input-search ms-3 rounded" type="search" name="query" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-dark custom-button" type="submit">Envoyer</button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('index')" :active="request()->routeIs('dashboard')">
                {{ __('Accueil') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('À propos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                {{ __('Boutique') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('basket')" :active="request()->routeIs('basket')">
                {{ __('Panier') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact.form')" :active="request()->routeIs('contact.form')">
                {{ __('Contact') }}
            </x-responsive-nav-link>


            <!-- Hide these links if the user is authenticated -->
            @guest
            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ __('Inscription') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Connexion') }}
            </x-responsive-nav-link>
            @endguest
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @endauth
        </div>
    </div>
    <script>



    </script>
    @vite(['resources/css/nav.css'])
</nav>
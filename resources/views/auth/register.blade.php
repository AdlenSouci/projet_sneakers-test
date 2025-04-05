<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="adresse_livraison" :value="__('Adresse')" />
            <x-text-input id="adresse_livraison" class="block mt-1 w-full" type="text" name="adresse_livraison" :value="old('adresse_livraison')" required autocomplete="adresse_livraison" />
            <x-input-error :messages="$errors->get('adresse_livraison')" class="mt-2" />

        </div>

        <div class="mt-4">
            <x-input-label for="code_postal" :value="__('Code postal')" />
            <x-text-input id="code_postal" class="block mt-1 w-full" type="text" name="code_postal" :value="old('code_postal')" required autocomplete="code_postal" />
            <x-input-error :messages="$errors->get('code_postal')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="ville" :value="__('Ville')" />
            <x-text-input id="ville" class="block mt-1 w-full" type="text" name="ville" :value="old('ville')" required autocomplete="ville" />
            <x-input-error :messages="$errors->get('ville')" class="mt-2" />
        </div>

        <!-- telephone-->
        
        <div class="mt-4">
            <x-input-label for="telephone" :value="__('Téléphone')" />
            <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')" required autocomplete="telephone" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>
            

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __(' Déjà enregistré ?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('ok') }}
            </x-primary-button>
        </div>
    </form>

    @vite('resources/css/accueil.css')
</x-guest-layout>
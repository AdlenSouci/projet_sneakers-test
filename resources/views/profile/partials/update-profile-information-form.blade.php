<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Information du profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mdifier les informations du profil.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')


        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />


        <!-- code postal -->

        <x-input-label for="code_postal" :value="__('Code postal')" />
        <x-text-input id="code_postal" name="code_postal" type="text" class="mt-1 block w-full" :value="old('code_postal', $user->code_postal)" required autocomplete="code_postal" />
        <x-input-error class="mt-2" :messages="$errors->get('code_postal')" />

        <!-- adresse de livraison -->

        <x-input-label for="adresse_livraison" :value="__('Adresse de livraison')" />
        <x-text-input id="adresse_livraison" name="adresse_livraison" type="text" class="mt-1 block w-full" :value="old('adresse_livraison', $user->adresse_livraison)" required autocomplete="adresse_livraison" />
        <x-input-error class="mt-2" :messages="$errors->get('adresse_livraison')" />

        <!-- ville -->



        <x-input-label for="ville" :value="__('Ville')" />
        <x-text-input id="ville" name="ville" type="text" class="mt-1 block w-full" :value="old('ville', $user->ville)" required autocomplete="ville" />
        <x-input-error class="mt-2" :messages="$errors->get('ville')" />


        <!-- telephone-->


        <x-input-label for="telephone" :value="__('Telephone')" />
        <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full" :value="old('telephone', $user->telephone)" required autocomplete="telephone" />
        <x-input-error class="mt-2" :messages="$errors->get('telephone')" />

        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div>
            <p class="text-sm mt-2 text-gray-800">
                {{ __('Your email address is unverified.') }}

                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
            <p class="mt-2 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to your email address.') }}
            </p>
            @endif
        </div>
        @endif


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
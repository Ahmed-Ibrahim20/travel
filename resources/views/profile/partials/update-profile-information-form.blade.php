<section class="space-y-6">
    <header class="border-b pb-3 mb-4">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-user-circle text-indigo-500"></i>
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-gray-700">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification"
                        class="ml-1 text-indigo-600 hover:text-indigo-800 underline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-green-600 text-sm">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-500">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

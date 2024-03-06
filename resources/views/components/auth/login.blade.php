@props(['title'])
<form wire:submit.prevent="customerLogin" class="my-4 space-y-4">
    <p class="text-gray-600 mt-0 pt-0">{{ $title }}</p>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Achtung!</strong>
            <span class="block sm:inline"> {{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Schließen</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif


    <x-input.group for="email" label="" :error="$errors->first('login.email')">
        <x-input.text wire:model.defer="login.email" placeholder="E-mail Adresse" required />
    </x-input.group>

    <x-input.group for="password" label="" :error="$errors->first('login.password')">
        <x-input.text type="password" wire:model.defer="login.password" placeholder="Passwort" required />
    </x-input.group>

    <button class="bg-red-500 w-full text-white py-2 px-4 rounded hover:bg-red-600" type="submit">Login</button>

    <p class="mt-10 text-center text-sm text-gray-500">
        Noch kein Konto?
        <a href="{{ route('frontend.register') }}" class="font-semibold leading-6 text-red-600 hover:text-red-500">Konto
            erstellen</a>
    </p>
</form>

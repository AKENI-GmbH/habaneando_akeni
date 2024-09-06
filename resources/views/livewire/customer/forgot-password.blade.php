@section('title', 'Passwort zurücksetzen')

<div class="min-h-screen flex items-center justify-center mx-auto w-full max-w-96 lg:w-136">
    <div>

        <h2 class="text-3xl font-bold leading-9 tracking-tight text-neutral-900 -mt-20 mb-5">Passwort zurücksetzen</h2>

        @if (session('status'))
            <div class="mb-5 bg-green-300 text-green-800 p-2  alert alert-danger">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 bg-red-300 text-red-800 p-2  alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="sendResetLink" class="space-y-6">

            <x-input.group for="email" label="E-Mail-Adresse" :error="$errors->first('email')">
                <x-input.text wire:model.lazy="email" required type="email"
                    placeholder="Geben Sie Ihre E-Mail-Adresse ein" />
            </x-input.group>

            <button type="submit"
                class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Link
                zum Zurücksetzen des Passworts senden</button>
        </form>
    </div>
</div>

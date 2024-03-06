@section('title', 'Mein Konto')

<div class="mx-auto w-full max-w-sm lg:w-96 mt-5">
    @if (session()->has('error'))
        <div class="rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button"
                            class="inline-flex rounded-md bg-red-50 p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 focus:ring-offset-red-50">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div>
        <h2 class="mt-4 text-3xl font-bold leading-9 tracking-tight text-gray-900">Mein Konto</h2>

        <form wire:submit.prevent="login" class="space-y-6">
            <x-input.group for="email" label="E-Mail-Adresse">
                <x-input.text wire:model.lazy="email" required type="email" />
            </x-input.group>

            <x-input.group for="password" label="Passwort">
                <x-input.text wire:model.lazy="password" required type="password" />
            </x-input.group>


            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                    <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-700">Remember
                        me</label>
                </div>

                <div class="text-sm leading-6">
                    <a href="#" class="font-medium text-black hover:text-red-500">Passwort
                        vergessen?</a>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Einloggen</button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Noch kein Konto?
            <a href="{{ route('frontend.register') }}"
                class="font-semibold leading-6 text-red-600 hover:text-red-500">Konto erstellen</a>
        </p>
    </div>
</div>

@section('title', 'Mein Konto')

<div class="min-h-screen flex items-center justify-center mx-auto w-full max-w-132 lg:w-132">

    <div>
        <h2 class="text-3xl font-bold leading-9 tracking-tight text-neutral-900">Reset Password</h2>

     
        <form wire:submit.prevent="resetPassword" class="space-y-6">

            <x-input.group for="email" label="E-Mail-Adresse">
                <x-input.text wire:model.lazy="email" required type="email" />
            </x-input.group>

            <x-input.group for="password" label="New Password">
                <x-input.text wire:model.lazy="password" required type="password" />
            </x-input.group>

            <x-input.group for="password_confirmation" label="Confirm Password">
                <x-input.text wire:model.lazy="password_confirmation" required type="password" />
            </x-input.group>
   
            <button type="submit" class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Reset Password</button>
        </form>
    </div>


    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

   
</div>


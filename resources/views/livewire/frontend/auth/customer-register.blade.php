@section('title', 'Konto erstellen')

@php
$label = "Mit der Anmeldung akzeptiere ich die <a href='" . route('frontend.page', 'agb') . "' class='text-red-600 hover:text-red-800'>Allgemeinen Geschäftsbedingungen (AGBs)</a> und die <a href='" . route('frontend.page', 'datenschutz') . "' class='text-red-600 hover:text-red-800'>Datenschutzbestimmungen</a>.";
@endphp


<div class="mx-auto w-full max-w-96 lg:w-136 mt-5">
    <div>
        <h2 class="mt-4 text-3xl font-bold leading-9 tracking-tight text-gray-900">Konto erstellen</h2>
        <p class="text-sm mt-4 ">Alle mit einem <span class="text-red-600 font-bold text-base">*</span> markierten Felder
            sind Pflichtfelder</p>
        <form wire:submit.prevent="register" class="space-y-6 mt-5">

            <x-input.group for="gender" label="Geschlecht wählen" :required="true" :error="$errors->first('user.gender')">
                <x-input.select wire:model.lazy="user.gender" required>
                    <option value="Männlich" selected>Männlich</option>
                    <option value="Weiblich">Weiblich</option>
                    <option value="Neutro">Neutro</option>
                </x-input.select>
            </x-input.group>

            <x-grid class="space-x-4">
                <div class="space-y-4">

                    <small class="m-0 p-0">Geburtsdatum <span class="text-red-700 font-bold text-base">*</span></small>
                    <x-grid cols="3" id="bday-inputs">
                        <x-input.group for="day" label="" :error="$errors->first('user.day')">
                            <x-input.text wire:model.lazy="user.day" placeholder="Tag" required />
                        </x-input.group>

                        <x-input.group for="month" label="" :error="$errors->first('user.month')">
                            <x-input.text wire:model.lazy="user.month" placeholder="Monat" required />
                        </x-input.group>

                        <x-input.group for="year" label="" :error="$errors->first('user.year')">
                            <x-input.text wire:model.lazy="user.year" placeholder="Jahr" required />
                        </x-input.group>
                    </x-grid>

                    <x-input.group for="first_name" label="Vorname" :required="true" :error="$errors->first('user.first_name')">
                        <x-input.text wire:model.lazy="user.first_name" placeholder="Vorname" required />
                    </x-input.group>

                    <x-input.group for="last_name" label="Nachname" :required="true" :error="$errors->first('user.last_name')">
                        <x-input.text wire:model.lazy="user.last_name" placeholder="Nachname" required />
                    </x-input.group>

                    <x-input.group for="email" label="E-Mail-Adresse" :required="true" :error="$errors->first('user.email')">
                        <x-input.text wire:model.lazy="user.email" placeholder="E-Mail-Adresse" type="email"
                            required />
                    </x-input.group>

                    <x-input.group for="phone" label="Telefonnummer" :error="$errors->first('user.phone')">
                        <x-input.text wire:model.lazy="user.phone" placeholder="Telefonnummer" />
                    </x-input.group>

                </div>
                <div class="space-y-4">


                    <x-input.group for="address" label="Adresse" :required="true" :error="$errors->first('user.address')">
                        <x-input.text wire:model.lazy="user.address" placeholder="Adresse" required />
                    </x-input.group>


                    <x-input.group for="city" label="Ort" :required="true" :error="$errors->first('user.city')">
                        <x-input.text wire:model.lazy="user.city" placeholder="Ort" required />
                    </x-input.group>

                    <x-input.group for="zip" label="PLZ" :required="true" :error="$errors->first('user.zip')">
                        <x-input.text wire:model.lazy="user.zip" placeholder="PLZ" required />
                    </x-input.group>



                    <x-input.group for="password" label="Passwort" :required="true" :error="$errors->first('user.password')">
                        <x-input.text wire:model.lazy="user.password" placeholder="Passwort" type="password" required />
                    </x-input.group>



                    <x-input.group for="password_confirm" label="Passwortbestätigung" :required="true"
                        :error="$errors->first('user.password_confirmation')">
                        <x-input.text wire:model.lazy="user.password_confirmation" placeholder="Passwortbestätigung"
                            type="password" required />
                    </x-input.group>

                </div>
            </x-grid>

           
            <x-input.checkbox wire:model="user.termsAccepted" :error="$errors->first('user.termsAccepted')" :label="$label" />




                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    Konto erstellen
                </button>

        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Bereits registriert?
            <a href="{{ route('frontend.login') }}" class="font-semibold leading-6 text-red-600 hover:text-red-500">Zum
                Login</a>
        </p>
    </div>
</div>

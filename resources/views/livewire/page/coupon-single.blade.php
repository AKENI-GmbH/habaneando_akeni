<div>
    <x-hero title="Gutscheine" :header="$header" :description="$coupon->name" />


    <x-container>

        <!-- Product -->
        <div class="lg:grid lg:grid-cols-7 lg:grid-rows-1 lg:gap-x-8 lg:gap-y-10 xl:gap-x-16">

            <div class="lg:col-span-4 lg:row-end-1">
                <div class="aspect-h-3 aspect-w-4 overflow-hidden rounded-lg bg-neutral-100">
                    <img src="https://images.pexels.com/photos/1775115/pexels-photo-1775115.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                        alt="Sample of 30 icons with friendly and fun details in outline, filled, and brand color styles."
                        class="object-cover object-center">
                </div>
            </div>

            <!-- Product details -->
            <div class="mx-auto mt-14 max-w-2xl sm:mt-16 lg:col-span-3 lg:row-span-2 lg:row-end-2 lg:mt-0 lg:max-w-none">

                <div class="mt-4">
                    <h1 class="text-2xl font-bold tracking-tight text-neutral-900 sm:text-3xl">{{ $coupon->name }}</h1>
                </div>


                <p class="mt-6 text-neutral-500">{!! $coupon->description !!}</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                    <button type="button"
                        class="flex w-full items-center justify-center rounded-md border border-transparent bg-red-600 px-8 py-3 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-neutral-50">Zahlen {{ number_format($coupon->amount, 0, ',', '.') }},-€</button>
                    <a target="_blank" href="{{ route('coupon.preview') }}"
                        class="flex w-full items-center justify-center rounded-md border border-transparent bg-red-50 px-8 py-3 text-base font-medium text-red-700 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-neutral-50">Preview</a>
                </div>

            </div>

        </div>

    </x-container>
</div>

<div>
    <x-hero :title="$page->name" :header="$page->header" />

    <x-container>

        <div
            class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">

            @forelse ($coupons as $coupon)
                <article
                    class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-neutral-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80">
                    <img src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80"
                        alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
                    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-neutral-900 via-neutral-900/40"></div>
                    <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-neutral-900/10"></div>

                    <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-neutral-300">
                        <div class="absolute top-0 right-5">
                            <div class="bg-red-600 text-white py-2 px-3 rounded-b-lg inline-block">
                                <span class="text-lg font-bold">{{ number_format($coupon->amount, 0, ',', '.') }}</span>
                                <span class="text-sm">€</span>
                            </div>
                        </div>

                    </div>
                    <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
                        <a href="{{ route('frontend.coupon.show', $coupon) }}">
                            <span class="absolute inset-0"></span>
                            {{ $coupon->name }}
                        </a>
                    </h3>
                </article>
            @empty
            @endforelse
        </div>
    </x-container>
</div>

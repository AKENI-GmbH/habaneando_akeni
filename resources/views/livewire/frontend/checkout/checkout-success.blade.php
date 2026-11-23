<div>
    <div class="relative overflow-hidden px-6 h-40 sm:h-120 lg:px-8 bg-red-700">

        <div class="absolute inset-0 flex items-center justify-center z-30">
            <div class="text-center max-w-screen-md">
                <h2 class="text-4xl font-medium tracking-tight sm:text-6xl text-white">
                    Vielen Dank</h2>
            </div>
        </div>

    </div>

    <div class="mx-auto max-w-md sm:max-w-3xl">
        <div class="py-14">
            <div class="text-center">
                <h2 class="mt-2 text-base font-semibold leading-6 text-neutral-900">Vielen Dank für Ihre Bestellung! Wir
                    wünschen Ihnen viel Freude damit.</h2>
            </div>

        </div>

    </div>

    @if (!empty($adsConversion))
        <!-- Google Ads: Conversion Schnupperstunde (lädt erst nach Einwilligung in Marketing-Cookies) -->
        <script type="text/plain" data-cookieconsent="marketing">
            gtag('event', 'conversion', {
                'send_to': 'AW-18587260157/e9iyCMHqqb0dEP2pjJ9F',
                'value': {{ (float) $adsConversion['value'] }},
                'currency': 'EUR',
                'transaction_id': @json($adsConversion['transaction_id'])
            });
        </script>
    @endif
</div>

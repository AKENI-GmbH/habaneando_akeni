<div x-data="{
    init() {
        new Splide(this.$refs.splide, {
            perPage: 1,
            gap: '0.5rem',
            breakpoints: {
                640: {
                    perPage: 1,
                },
            },
        }).mount()
    },
}">
    <section x-ref="splide" class="splide" aria-label="habaneando">
        <div class="splide__track">
            <ul class="splide__list">
                {{ $slot }}
            </ul>
        </div>
    </section>
</div>

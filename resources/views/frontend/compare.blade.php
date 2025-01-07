<x-frontend-layout>

    <section>
        <div class="container py-10">
            <p class="text-2xl primary">Result For {{ $q }}</p>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-10 py-5">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

</x-frontend-layout>

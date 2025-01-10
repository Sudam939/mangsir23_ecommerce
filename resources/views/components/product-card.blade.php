@props(['product'])
<div class="border text-xs rounded-lg overflow-hidden hover:shadow-md duration-300">
    <div data-modal-target="cart-modal{{ $product->id }}" data-modal-toggle="cart-modal{{ $product->id }}"
        class="grid grid-cols-2 gap-2 items-center cursor-pointer">
        <img class="w-full h-[100px] object-cover" src="{{ asset(Storage::url($product->image)) }}"
            alt="{{ $product->name }}">
        <div>
            <h1 class="text-sm font-medium">{{ Str::limit($product->name, 30, '...') }}</h1>
            <div>
                @if ($product->discount || $product->discount > 0)
                    <s class="text-red-600">Rs.{{ $product->price }}</s>
                    Rs.{{ $product->price - ($product->price * $product->discount) / 100 }}
                @else
                    Rs.{{ $product->price }}
                @endif
            </div>
            <strong>{{ $product->vendor->shop->name }}</strong>
        </div>
    </div>
</div>


<!-- Main modal -->
<div id="cart-modal{{ $product->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold primary    ">
                    ADD TO CART
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="cart-modal{{ $product->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <img class="w-full h-[100px] object-cover" src="{{ asset(Storage::url($product->image)) }}"
                            alt="{{ $product->name }}">
                    </div>

                    <div class="col-span-2 space-y-2">
                        <h1 class="text-lg font-medium">{{ Str::limit($product->name, 30, '...') }}</h1>
                        <div>
                            @if ($product->discount || $product->discount > 0)
                                <s class="text-red-600">Rs.{{ $product->price }}</s>
                                Rs.{{ $product->price - ($product->price * $product->discount) / 100 }}
                            @else
                                Rs.{{ $product->price }}
                            @endif
                        </div>
                        <form action="{{ route('add_to_cart') }}" method="post">
                            @csrf
                            <input value="{{ $product->id }}" type="number" name="product_id"
                                id="product_id" hidden>
                            <input value="1" type="number" min="1" name="qty" id="qty">

                            <button class="bg-primary text-white px-4 py-2 rounded-md mt-2">ADD TO CART</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-frontend-layout>

    <section>
        <div class="container py-10">
            @foreach ($vendors as $vendor)
                <div class="space-y-4 mb-10">
                    <div class="border-b">
                        <h1>{{ $vendor['shop']['name'] }}</h1>
                    </div>

                    <div class="py-2 border-b">
                        <table class="w-full text-center">

                            <thead class="bg-primary text-white p-2">
                                <tr>
                                    <th>SN</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>QTY</th>
                                    <th>Rate(NRs.)</th>
                                    <th>Amount(NRs.)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($carts as $cart)
                                    @if ($cart->product->vendor->id == $vendor['id'])
                                        @php
                                            $total += $cart->amount;
                                        @endphp

                                        <tr>
                                            <td>
                                                <form action="{{ route('cart_delete', $cart->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button>
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </form>
                                            </td>

                                            <td>
                                                <img src="{{ asset(Storage::url($cart->product->image)) }}"
                                                    class="w-10 h-10 object-cover" alt="{{ $cart->product->name }}">
                                            </td>

                                            <td>
                                                {{ $cart->product->name }}
                                            </td>
                                            <form action="{{ route('cart_update', $cart->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <td>
                                                    <input type="number" value="{{ $cart->qty }}" min="1"
                                                        name="qty" id="qty">
                                                </td>

                                                <td>
                                                    @if ($cart->product->discount || $cart->product->discount > 0)
                                                        {{ $cart->product->price - ($cart->product->price * $cart->product->discount) / 100 }}
                                                    @else
                                                        {{ $cart->product->price }}
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $cart->amount }}
                                                </td>

                                                <td>

                                                    <button type="submit"
                                                        class="bg-slate-600 text-white px-2 py-1 rounded">Update</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="text-end">
                        <p>
                            <b>Total:</b> Rs. {{ $total }}
                        </p>

                        <a href="{{ route('checkout', $vendor['id']) }}" class="bg-primary px-4 py-2 text-white rounded">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</x-frontend-layout>

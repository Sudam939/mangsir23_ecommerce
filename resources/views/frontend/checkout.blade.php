<x-frontend-layout>

    <section>
        <div class="container py-10">
            <form action="{{ route('order', $id) }}" method="post">
                @csrf

                <div>
                    @foreach (Auth::user()->shipping_addresses as $address)
                        <div>
                            <label for="{{ $address->id }}">{{ $address->title }}</label>
                            <input type="radio" name="shipping_address" value="{{ $address->id }}"
                                id="{{ $address->id }}">
                        </div>
                    @endforeach
                </div>

                <div>
                    <label for="payment_type">Payment Type</label>
                    <select name="payment_type" id="payment_type">
                        <option value="cash">Cash on Delivery</option>
                        <option value="esewa">eSewa</option>
                    </select>
                </div>

                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md">Order</button>
            </form>
        </div>
    </section>

</x-frontend-layout>

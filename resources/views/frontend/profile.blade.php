<x-frontend-layout>

    <section>
        <div class="container py-10">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-3  border-r-2">
                    <ul>
                        <li>
                            <a href="{{ route('profile') }}">Shipping Address</a>
                        </li>
                        <li>
                            <a href="{{ route('profile.edit') }}">Edit Profile</a>
                        </li>
                    </ul>
                </div>

                <div class="col-span-9 space-y-5">
                    <h1 class="text-2xl primary font-semibold">SHIPPING ADDRESS</h1>

                    <div id="accordion">
                        @foreach ($shipping_addresses as $shipping_address)
                            <h3>{{ $shipping_address->title }}</h3>
                            <div class="flex justify-between items-center">
                                <p>
                                    {{ $shipping_address->address_note }}
                                </p>

                                <div>
                                    <a href="">edit</a>
                                    <a href="">delete</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('add_shipping_address') }}" method="post">
                        @csrf
                        <h1 class="text-2xl primary font-semibold">ADD</h1>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="title">Title <span class="text-red-600">*</span></label>
                                <input type="text" name="title" id="title"
                                    class="w-full px-2 py-1 border rounded-md" value="{{ old('title') }}">
                            </div>
                            <div>
                                <label for="phone">Phone <span class="text-red-600">*</span></label>
                                <input type="text" name="phone" id="phone"
                                    class="w-full px-2 py-1 border rounded-md" value="{{ old('phone') }}">
                            </div>
                            <div class="col-span-2">
                                <label for="address_note">Address Note <span class="text-red-600">*</span></label>
                                <input type="text" name="address_note" id="address_note"
                                    class="w-full px-2 py-1 border rounded-md" value="{{ old('address_note') }}">
                            </div>
                            {{-- <div class="col-span-2">
                                <x-laravel-map id="shipping-map" :initialMarkers="$initialMarkers" :options="$options" />
                                <input name="latitude" id="latitude">
                                <input name="longitude" id="longitude">
                            </div> --}}
                            <div class="text-center col-span-2">
                                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md">SEND
                                    REQUEST</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-frontend-layout>

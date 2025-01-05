<x-frontend-layout>

    <section>
        <div class="container flex justify-center text-center py-20">
            <div>
                <h1 class="text-3xl text-slate-600">
                    List your Restaurant or Store at Floor Digital Pvt. Ltd.! <br>
                    Reach 1,00,000 + new customers.
                </h1>


                <!-- Modal toggle -->
                <button data-modal-target="request-modal" data-modal-toggle="request-modal"
                    class="mt-5 bg-primary text-white px-4 py-2 rounded-md" type="button">
                    SEND A REQUEST
                </button>

                <div class="space-y-2 py-2">
                    @error('name')
                        <div class="text-red-600 bg-red-100 px-4 py-2">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('email')
                        <div class="text-red-600 bg-red-100 px-4 py-2">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('phone')
                        <div class="text-red-600 bg-red-100 px-4 py-2">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('shop_name')
                        <div class="text-red-600 bg-red-100 px-4 py-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Main modal -->
        <div id="request-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold primary">
                            Welcome to Floor Digital Pvt. Ltd.
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="request-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>


                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <form action="{{ route('vendor_request') }}" method="post">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="name">Name <span class="text-red-600">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="w-full px-2 py-1 border rounded-md" value="{{ old('name') }}">
                                </div>
                                <div>
                                    <label for="email">Email <span class="text-red-600">*</span></label>
                                    <input type="text" name="email" id="email"
                                        class="w-full px-2 py-1 border rounded-md" value="{{ old('email') }}">
                                </div>
                                <div>
                                    <label for="phone">Phone <span class="text-red-600">*</span></label>
                                    <input type="text" name="phone" id="phone"
                                        class="w-full px-2 py-1 border rounded-md" value="{{ old('phone') }}">
                                </div>
                                <div>
                                    <label for="shop_name">Restaurant/Shop Name <span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="shop_name" id="shop_name"
                                        class="w-full px-2 py-1 border rounded-md" value="{{ old('shop_name') }}">
                                </div>
                                <div class="text-center col-span-2">
                                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md">SEND
                                        REQUEST</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-frontend-layout>

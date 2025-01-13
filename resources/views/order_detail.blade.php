<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
</head>

<body>
    <div class="container py-10 space-y-10">
        <div class="flex justify-between">
            <div>
                <img class="w-[200px]" src="{{ asset(Storage::url($company->logo)) }}" alt="{{ $company->name }}">

                <h1 class="text-lg font-bold">{{ $company->name }}</h1>
                <address>{{ $company->address }}</address>
            </div>

            <h2 class="text-2xl font-bold">Payment Order</h2>
        </div>

        <div class="flex justify-between gap-4 ">
            <div>
                <h2 class="text-2xl font-bold">Shipping Address</h2>
                <p>{{ $order->shipping_address->address_note }}</p>
                <a href="tel:{{ $order->shipping_address->phone }}">Phone: {{ $order->shipping_address->phone }}</a>
            </div>

            <div>
                <h2 class="text-2xl font-bold">Vendor</h2>
                <p>{{ $order->order_descriptions[0]->product->vendor->shop->name }}</p>
                <p>{{ $order->order_descriptions[0]->product->vendor->shop->address }}</p>
            </div>
        </div>

        <div>
            <table class="w-full text-center">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>
                            Product
                        </th>

                        <th>
                            QTY
                        </th>

                        <th>
                            Price
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->order_descriptions as $des)
                        <tr>
                            <td class="py-2 border-b">
                                {{ $des->product->name }}
                            </td>

                            <td class="py-2 border-b">
                                {{ $des->qty }}
                            </td>

                            <td class="py-2 border-b">
                                {{ $des->amount }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th class="border-b" colspan="2">
                            Total
                        </th>
                        <td class="border-b">
                            {{ $order->total_amount }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

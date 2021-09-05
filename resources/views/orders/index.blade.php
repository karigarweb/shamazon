<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert class="mb-5" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 bg-white border-b border-gray-200 ">

                    @foreach($orders as $order)
                        <span class="text-lg font-bold text-green-800">Order ID: {{$order->id}}</span>
                        <table class="w-full text-center rounded-lg mt-4 mb-4">
                            <thead>
                            <tr class="text-gray-800 border border-b-0">
                                <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Product</th>
                                <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Qty</th>
                                <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Price</th>
                                <th class="border border-emerald-500 px-4 py-2 text-emerald-600">total</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($order->items as $item)
                                <tr class="w-full font-light text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">
                                    <td class="p-3 ">{{$item->product->name}}</td>
                                    <td class="p-3 ">{{$item->qty}}</td>
                                    <td class="p-3 ">{{$item->price}}</td>
                                    <td class="p-3 ">{{($item->qty * $item->price)}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

</x-app-layout>













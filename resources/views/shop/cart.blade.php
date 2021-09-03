<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert class="mb-5" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 bg-white border-b border-gray-200 ">

                    <button class="" onclick="handleDelete()">
                        <span class="fill-current text-red-500 material-icons">Clear Cart</span>
                    </button>

                    <table class="w-full text-center rounded-lg mt-4">
                        <thead>
                        <tr class="text-gray-800 border border-b-0">
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Product</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Qty</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Price</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(sizeof($cart))
                            @foreach($cart as $product)
                                <tr class="w-full font-light text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">
                                    <td class="p-3 ">{{$product['name']}}</td>
                                    <td class="p-3 ">{{$product['qty']}}</td>
                                    <td class="p-3 ">{{$product['price']}}</td>
                                    <td class="p-3 ">{{($product['price'] * $product['qty'])}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="w-full font-light text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">
                                <td colspan="4" class="py-3 text-xl">Your cart is empty</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">

            $('.btn-add-to-cart').on('click', function()
            {
                let productId = $(this).data('product-id');
                let qty = $('#qty_' + productId).val();

                if(qty === "" || qty <= 0) {
                    toastr["error"]("Qty", "Invalid qty ")
                }

                let request = new Request();
                request.send("post","/shop/add-to-cart" , {product_id:productId, qty:qty}).then((res) =>
                {
                    toastr["success"]("", "Product added to your cart successfully");
                }).catch((error) => {
                    toastr["error"]("Success", error);
                    console.log(error);
                });

            });
        </script>
    @endpush


</x-app-layout>













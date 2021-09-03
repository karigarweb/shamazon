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

                   @foreach($products as $sellerName => $sellerProducts)
                       <h2 class="text-blue-600 text-2xl">{{$sellerName}}</h2>
                        <div class="p-6 border rounded-t-lg bg-gray-100 mb-5">
                            <div class="lg:flex flex-wrap -mx-2">
                                @foreach($sellerProducts as $product)
                                    <div class="w-full lg:w-1/3 px-2">
                                        <div class="bg-white px-4 py-4 flex my-2 rounded-lg shadow">
                                            <div class="w-24 pr-5">
                                                <a href="#" class="mb-4">
                                                    <img class="rounded" src="images/default-product.png">
                                                </a>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-md font-bold text-gray-700 my-0">{{$product->name}}</p>
                                                <p>{{$product->currency}} {{$product->price}}</p>
                                                <p class="mt-3">
                                                    <input type="number" class="w-1/2" min="1" id="qty_{{$product->id}}">
                                                    <x-button class="bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 mt-1 focus:outline-none btn-add-to-cart"
                                                    data-product-id="{{$product->id}}">
                                                        {{ __('Buy') }}
                                                    </x-button>


                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

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
                request.send("post","/shop/add-to-cart" , {product_id:productId, qty:qty}).then((res)=>
                {
                    $('#cartTotal').html(res.total)
                    toastr["success"]("", "Product added to your cart successfully");
                }).catch((error) => {
                    toastr["error"]("Success", error);
                    console.log(error);
                });

            });
        </script>
    @endpush


</x-app-layout>













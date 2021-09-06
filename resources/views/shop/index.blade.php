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


                    <form method="POST" action="{{ route('orders.place') }}" class="float-right py-4 px-2 mr-4">

                        @csrf

                        <button  class="btn-place-order inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 text-lg bg-blue-700 text-white"
                                 {{ ((\App\Facades\Cart::count() == 0) ? 'disabled' : '') }}
                                  onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Place Order') }}
                        </button>

                    </form>


                <div class="p-6 bg-white border-b border-gray-200 mt-4 ">

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
                    if(res.error !== undefined)
                    {
                        toastr["error"]("", res.error);
                    }
                    else
                    {
                        $('#cartTotal').html(res.total);
                        $('.btn-place-order').removeAttr('disabled')
                        toastr["success"]("", "Product added to your cart successfully");
                    }

                }).catch((error) => {
                    toastr["error"]("", error);
                    console.log(error);
                });

            });
        </script>
    @endpush


</x-app-layout>













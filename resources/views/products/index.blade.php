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

                    <a class="underline text-lg text-blue-800-600 hover:text-blue-900-900 mb-2 pb-3" href="{{ route('products.create') }}">
                        {{ __('Create product') }}
                    </a>


                    <table class="w-full text-center rounded-lg mt-4">
                        <thead>
                        <tr class="text-gray-800 border border-b-0">
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Name</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Price</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Stock</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="w-full font-light text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">
                                    <td class="">{{$product->name}}</td>
                                    <td class="price">
                                        <span class="currency mr-1">{{$product->currency}}</span>{{$product->price}}
                                    </td>
                                    <td class="">{{$product->stock}}</td>
                                    <td class="text-center py-4">
                                        <a href="{{route('products.edit',     ['product' => $product->id])}}"><span class="fill-current text-green-500 material-icons">edit</span></a>
                                        <button onclick="handleDelete('{{$product->id}}')" href="{{route('products.destroy',  ['product' => $product->id])}}">
                                            <span class="fill-current text-red-500 material-icons">delete</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form method="POST" id="formDeleteProduct">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">

            function handleDelete(id)
            {
                var url = '{{ route("products.destroy", ":id") }}';
                url = url.replace(':id', id);
                document.getElementById("formDeleteProduct").action = url;
                document.getElementById("formDeleteProduct").submit();
            }

        </script>
    @endpush

</x-app-layout>









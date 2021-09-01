<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __((isset($product) ? 'Edit Product' : 'New Product')) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 bg-white border-b border-gray-200 ">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert class="mb-4" />


                    <form method="POST" action="{{ (isset($product)) ? route('products.update', ['product' => $product->id]) : route('products.store') }}">
                        @csrf

                        @if(isset($product))
                            @method("PATCH")
                        @endif

                        <!-- Name -->
                        <div class="mt-4">
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', @$product->name)" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="currency" :value="__('Currency')" />
                            <x-select id="currency" name="currency" class="w-full" :options="['eur' => 'eur']" value="" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="price" :value="__('Price')" />

                            <x-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price', @$product->price)" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="stock" :value="__('stock')" />

                            <x-input id="stock" class="block mt-1 w-full" type="text" name="stock" :value="old('stock', @$product->stock)" required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <a class="underline text-sm text-red-700 hover:text-red-900 text-lg" href="{{ route('products.index') }}">
                                {{ __('Cancel') }}
                            </a>

                            <x-button class="ml-4 text-lg bg-green-800 text-white">
                                {{ __('Save') }}
                            </x-button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>





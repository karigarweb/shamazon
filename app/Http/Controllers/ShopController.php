<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Http\Requests\AddToCartRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * get all product with group by seller
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::with('seller')->orderBy('name')->get()->groupBy('seller.name');
        return view('shop.index', compact('products'));
    }

    public function clear()
    {
        Cart::clear();
        return redirect(route('shop'));
    }

    public function addToCart(AddToCartRequest $request)
    {
        Cart::add($request->product_id, $request->qty);
        return response()->json(['message' => true]);
    }


    public function cart()
    {
        $cart = Cart::get();
        return view('shop.cart', compact('cart'));
    }
}

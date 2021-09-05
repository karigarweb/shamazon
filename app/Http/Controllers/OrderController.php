<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * get list of orders
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        //get list of orders only for logged in seller
        $orders = Order::with(['items' => function($q)
        {
           return $q->with('product')->whereHas('product', function($q){
                return $q->where('seller_id', Auth::user()->id);
            });

        }])->get();


        return view('orders.index', compact('orders'));
    }


    /**
     * implement place order
     * @return mixed
     */
    public function placeOrder()
    {
        return DB::transaction(function()
        {
            $cart = Cart::get();

            if(!$cart->count()) return redirect()->back()->with('error', 'Your cart is empty');

            /**
             * validate stock before place order
             */
            $products = Product::whereIn('id', $cart->pluck('product_id')->toArray())->get()->keyBy('id')->toArray();
            foreach ($cart as $item)
            {
                if($products[$item['product_id']]['stock'] < $item['qty']) {
                    return redirect()->back()->with('error', $item['name'] . ' does not have enough stock');
                }

                $orderItems[] = [
                    'product_id' => $item['product_id'],
                    'price'      => $products[$item['product_id']]['price'],
                    'qty'        => $item['qty']
                ];
            }

            //create order
            $order = Order::create([
                'total'         => Cart::total(),
                'customer_id'   => Auth::user()->id
            ]);

            //create order items
            $order->items()->createMany($orderItems);

            //decrease stock
            $cart->each(function ($item, $key) {
                Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
            });

            Cart::clear();

            return redirect()->back()->with('message', 'Thank you for your order, Your order ID is ' . $order->id);

        });
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        //get logged in seller products only
        $products = Product::where('seller_id', Auth::user()->id)->paginate();
        return view('products.index', compact('products'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('products.form');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        return view('products.form', compact('product'));
    }


    /**
     * @param ProductRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProductRequest $request)
    {
        $productData = $request->validated();
        $productData['seller_id'] = Auth::user()->id;

        Product::create($productData);
        Session::flash('message', 'Product is saved successfully');

        return redirect(route('products.create'));
    }

    /**
     * @param $id
     * @param ProductRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Product $product, ProductRequest $request)
    {
        $product->update($request->validated());

        Session::flash('message', 'Product is updated successfully');
        return redirect(route('products.edit', ['product' => $product->id]));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Product $product)
    {
        try
        {
            $product->delete();
            Session::flash('message', 'Product is deleted successfully');
        }
        catch (\Exception $exception)
        {
            Session::flash('error', 'Can not delete this product');
        }

        return redirect(route('products.index'));
    }
}

<?php


namespace App\Helpers;


use App\Models\Product;
use Illuminate\Support\Collection;

class Cart
{
    public  $instance;

    /**
     * Cart constructor.
     * @param SessionManager $session
     * @param Dispatcher $events
     */
    public function __construct()
    {

    }

    /**
     * get cart content
     *
     * @return Collection
     */
    protected function getContent()
    {
       return session()->has('cart')
            ? session()->get('cart')
            : new Collection();
    }

    /**
     * get cart
     * @return Collection
     */
    public function get()
    {
        return $this->getContent();
    }

    /**
     * get total items in cart
     * @return int
     */
    public function count()
    {
        return $this->getContent()->count();
    }

    /**
     * delete all products from cart
     */
    public function clear()
    {
        session()->forget('cart');
    }

    /**
     * add / update cart product
     *
     * @param $productId
     * @param $qty
     * @return bool
     */
    public function add($productId, $qty)
    {
        $content = $this->getContent();
        $product = Product::findOrFail($productId);

        /**
         * update product qty when product already exists
         */
        if ($content->has($product->id)) {
            $qty += $content->get($product->id)['qty'];
        }

        if($product->stock < $qty) {
            return ['error' => 'Product do not have enough stock to buy'];
        }

        //push to cart
        $content->put($product->id, [
            'product_id'    => $product->id,
            'name'          => $product->name,
            'qty'           => $qty,
            'price'         => $product->price
        ]);

        //update cart content
        session()->put('cart', $content);

        return ['message' => 'Product is added to cart successfully.', 'total' => $this->total()];
    }

    /**
     * get cart total
     *
     * @return string
     */
    public function total()
    {
        $content = $this->getContent();

        $total = $content->reduce(function ($total, $item) {
            return $total + ($item['qty'] * $item['price'] );
        }, 0);

        return number_format($total , 2);
    }
}

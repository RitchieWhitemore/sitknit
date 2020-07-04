<?php


namespace app\modules\cart\services;


use app\modules\cart\models\Cart;

class CartService
{
    private $cart;
    private $products;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function add($productId, $quantity)
    {
        $product = $this->products->get($productId);
        $this->cart->add(new CartItem($product, $quantity));
    }

    public function set($id, $quantity)
    {
        $this->cart->set($id, $quantity);
    }

    public function remove($id)
    {
        $this->cart->remove($id);
    }

    public function clear(): void
    {
        $this->cart->clear();
    }
}
<?php namespace Hideyo\ViewComposers;

use Illuminate\Contracts\View\View;
use Hideyo\Services\Cart as Cart;
use App\Shop;
use Auth;
use Request;

class CartComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $url = Request::url();
        $pos = strpos($url, 'wholesale');

        $cart = new Cart();
        $this->cart = $cart->getInstance();
        $products = $this->cart->products();
        $summary = $this->cart->summary();
        
        if ($this->cart->summary()) {
            $view->with('cartTotals', $summary->totals());
            $view->with('cartProducts', $summary->products());
        }
        
        $view->with('cartCount', count($products));
    }
}

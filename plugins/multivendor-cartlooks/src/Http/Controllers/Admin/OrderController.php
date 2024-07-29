<?php

namespace Plugin\Multivendor\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugin\CartLooksCore\Repositories\OrderRepository;

class OrderController extends Controller
{

    public function __construct(public OrderRepository $orderRepository)
    {
        isActiveParentPlugin('cartlookscore');
    }
    /**
     * Will return seller orders
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function sellerOrders(Request $request)
    {
        $orders = $this->orderRepository->orderList($request, config('cartlookscore.order_type.home_delivery'), 'seller', null);
        $order_counter = $this->orderRepository->sellerOrderCounter(config('cartlookscore.order_type.home_delivery'));
        return view('plugin/multivendor-cartlooks::admin.orders.index')->with(
            [
                'orders' => $orders,
                'order_counter' => $order_counter
            ]
        );
    }
}

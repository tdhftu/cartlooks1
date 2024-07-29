<?php

namespace Plugin\CartLooksCore\Repositories;

class ReportRepository
{

    /**
     * Will return admin business stats
     */
    public function businessStats($time = null)
    {
        $order_repository = new \Plugin\CartLooksCore\Repositories\OrderRepository();

        $customer_query = \Plugin\CartLooksCore\Models\Customers::select('id');
        $product_query = \Plugin\CartLooksCore\Models\Product::select('id');
        $order_query = \Plugin\CartLooksCore\Models\Orders::select('id');
        if (isActivePlugin('refund-cartlooks')) {
            $return_query = \Plugin\Refund\Models\OrderReturnRequest::select('id', 'return_status');
            $return_processing_query = \Plugin\Refund\Models\OrderReturnRequest::select('id', 'return_status');
        }

        $total_refunds = 0;
        $return_processing = 0;
        if ($time == 'over_all' || $time == null) {
            $total_customers = $customer_query->get()->count();
            $total_products = $product_query->get()->count();
            $total_orders = $order_query->get()->count();
            $total_sales = $order_query->sum('total_payable_amount');
            if (isActivePlugin('refund-cartlooks')) {
                $total_refunds = $return_query->where('return_status', config('cartlookscore.return_request_status.approved'))->get()->count();
                $return_processing = $return_processing_query->whereNot('return_status', config('cartlookscore.return_request_status.approved'))->get()->count();
            }
        }
        if ($time == 'today') {
            $total_customers = $customer_query->whereDate('created_at', today())->get()->count();
            $total_products = $product_query->whereDate('created_at', today())->get()->count();
            $total_orders = $order_query->whereDate('created_at', today())->get()->count();
            $total_sales = $order_query->whereDate('created_at', today())->sum('total_payable_amount');
            if (isActivePlugin('refund-cartlooks')) {
                $total_refunds = $return_query->where('return_status', config('cartlookscore.return_request_status.approved'))->whereDate('created_at', today())->get()->count();
                $return_processing = $return_processing_query->whereNot('return_status', config('cartlookscore.return_request_status.approved'))->whereDate('created_at', today())->get()->count();
            }
        }
        if ($time == 'month') {
            $total_customers = $customer_query->whereMonth('created_at', '=', now()->month)->get()->count();
            $total_products = $product_query->whereMonth('created_at', '=', now()->month)->get()->count();
            $total_orders = $order_query->whereMonth('created_at', '=', now()->month)->get()->count();
            $total_sales = $order_query->whereMonth('created_at', '=', now()->month)->sum('total_payable_amount');
            if (isActivePlugin('refund-cartlooks')) {
                $total_refunds = $return_query->where('return_status', config('cartlookscore.return_request_status.approved'))->whereMonth('created_at', '=', now()->month)->get()->count();
                $return_processing = $return_processing_query->whereNot('return_status', config('cartlookscore.return_request_status.approved'))->whereMonth('created_at', '=', now()->month)->get()->count();
            }
        }

        $total_sales = currencyExchange($total_sales, true, null, false);

        $pending_orders = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.pending'), $time);
        $approved = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.processing'), $time);
        $ready_to_ship = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.ready_to_ship'), $time);
        $shipped = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.shipped'), $time);
        $delivered = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.delivered'), $time);
        $cancelled = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.cancelled'), $time);

        return [
            'total_customers' => $total_customers,
            'total_products' => $total_products,
            'total_orders' => $total_orders,
            'total_sales' => $total_sales,
            'pending_orders' => $pending_orders,
            'approved' => $approved,
            'ready_to_ship' => $ready_to_ship,
            'shipped' => $shipped,
            'delivered' => $delivered,
            'cancelled' => $cancelled,
            'total_refunds' => $total_refunds,
            'return_processing' => $return_processing
        ];
    }

    /**
     * Will return seller business stats
     */
    public function sellerBusinessStats($time = null)
    {
        $order_repository = new \Plugin\CartLooksCore\Repositories\OrderRepository();

        $product_query = \Plugin\CartLooksCore\Models\Product::where('supplier', auth()->user()->id)->select('id');
        $sales_query = \Plugin\CartLooksCore\Models\OrderHasProducts::where('seller_id', auth()->user()->id)
            ->select('unit_price', 'quantity');

        $earning_query = \Plugin\Multivendor\Models\SellerEarnings::where('seller_id', auth()->user()->id)
            ->where('status', config('cartlookscore.seller_earning_status.approve'));


        $order_query = \Plugin\CartLooksCore\Models\OrderHasProducts::groupBy('order_id')
            ->where('seller_id', auth()->user()->id)
            ->selectRaw('order_id, count(*) as count');


        if (isActivePlugin('refund-cartlooks')) {
            $return_query = \Plugin\Refund\Models\OrderReturnRequest::whereHas('product', function ($q) {
                $q->where('supplier', auth()->user()->id);
            });

            $return_processing_query = \Plugin\Refund\Models\OrderReturnRequest::whereHas('product', function ($q) {
                $q->where('supplier', auth()->user()->id);
            });
        }
        $total_refunds = 0;
        $return_processing = 0;
        if ($time == 'over_all' || $time == null) {

            $total_products = $product_query->get()->count();
            $total_sales = $sales_query->get()
                ->sum(function ($sale) {
                    return $sale->unit_price * $sale->quantity;
                });

            $total_earning = $earning_query->sum('earning');
            $total_orders = $order_query->get()->count();


            if (isActivePlugin('refund-cartlooks')) {
                $return_processing = $return_query->whereNot('return_status', config('cartlookscore.return_request_status.approved'))->get()->count();
                $total_refunds = $return_processing_query->where('return_status', config('cartlookscore.return_request_status.approved'))->get()->count();
            }
        }
        if ($time == 'today') {

            $total_products = $product_query->whereDate('created_at', today())->get()->count();
            $total_sales = $sales_query->whereDate('created_at', today())->get()
                ->sum(function ($sale) {
                    return $sale->unit_price * $sale->quantity;
                });
            $total_earning = $earning_query->whereDate('created_at', today())->sum('earning');
            $total_orders = $order_query->whereDate('created_at', today())->get()->count();

            if (isActivePlugin('refund-cartlooks')) {
                $total_refunds = $return_query->where('return_status', config('cartlookscore.return_request_status.approved'))->whereDate('created_at', today())->get()->count();
                $return_processing = $return_processing_query->whereNot('return_status', config('cartlookscore.return_request_status.approved'))->whereDate('created_at', today())->get()->count();
            }
        }
        if ($time == 'month') {
            $total_products = $product_query->whereMonth('created_at', '=', now()->month)->get()->count();
            $total_sales = $sales_query->whereMonth('created_at', '=', now()->month)->get()
                ->sum(function ($sale) {
                    return $sale->unit_price * $sale->quantity;
                });
            $total_earning = $earning_query->whereMonth('created_at', '=', now()->month)->sum('earning');
            $total_orders = $order_query->whereMonth('created_at', '=', now()->month)->get()->count();

            if (isActivePlugin('refund-cartlooks')) {
                $total_refunds = $return_query->where('return_status', config('cartlookscore.return_request_status.approved'))->whereMonth('created_at', '=', now()->month)->get()->count();
                $return_processing = $return_processing_query->whereNot('return_status', config('cartlookscore.return_request_status.approved'))->whereMonth('created_at', '=', now()->month)->get()->count();
            }
        }

        $total_sales = currencyExchange($total_sales, true, null, false);
        $total_earning = currencyExchange($total_earning, true, null, false);

        $pending_orders = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.pending'), $time, auth()->user()->id);
        $approved = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.processing'), $time, auth()->user()->id);
        $ready_to_ship = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.ready_to_ship'), $time, auth()->user()->id);
        $shipped = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.shipped'), $time, auth()->user()->id);
        $delivered = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.delivered'), $time, auth()->user()->id);
        $cancelled = $order_repository->statusWiseOrderCounter(config('cartlookscore.order_delivery_status.cancelled'), $time, auth()->user()->id);

        return [
            'total_earning' => $total_earning,
            'total_products' => $total_products,
            'total_orders' => $total_orders,
            'total_sales' => $total_sales,
            'pending_orders' => $pending_orders,
            'approved' => $approved,
            'ready_to_ship' => $ready_to_ship,
            'shipped' => $shipped,
            'delivered' => $delivered,
            'cancelled' => $cancelled,
            'total_refunds' => $total_refunds,
            'return_processing' => $return_processing
        ];
    }
}

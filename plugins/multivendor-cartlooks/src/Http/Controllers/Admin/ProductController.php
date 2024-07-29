<?php

namespace Plugin\Multivendor\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugin\CartLooksCore\Repositories\ProductRepository;

class ProductController extends Controller
{

    public function __construct(public ProductRepository $productRepository)
    {
        isActiveParentPlugin('cartlookscore');
    }
    /**
     * Will return seller product
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function sellerProducts(Request $request)
    {
        return view('plugin/multivendor-cartlooks::admin.products.index')->with([
            'products' => $this->productRepository->productManagement($request, null, 'seller')
        ]);
    }
}

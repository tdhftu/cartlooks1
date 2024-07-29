<?php

namespace Theme\CartLooksTheme\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function allProductsPage()
    {
        return view('theme/cartlooks-theme::frontend.pages.products');
    }

    public function productDetails($id)
    {
        if (isActivePlugin('cartlookscore')) {
            $product_details = \Plugin\CartLooksCore\Models\Product::where('permalink', $id)->select('id', 'name', 'thumbnail_image', 'summary')->first();
            if ($product_details != null) {
                $product_details->meta_title = $product_details->product_seo != null && $product_details->product_seo->meta_title != null ? $product_details->product_seo->meta_title : $product_details->name;
                $product_details->meta_description = $product_details->product_seo != null  && $product_details->product_seo->meta_description != null ? $product_details->product_seo->meta_description : $product_details->summary;
                $product_details->meta_image = $product_details->product_seo != null && $product_details->product_seo->meta_image != null ? getFilePath($product_details->product_seo->meta_image, false) : getFilePath($product_details->thumbnail_image, false);
            }

            return view('theme/cartlooks-theme::frontend.pages.product-details')->with(
                [
                    'product_details' => $product_details
                ]
            );
        }
    }

    /**
     * Will return category seo info
     * 
     * @param String id
     * @return mixed
     */
    public function categoryProducts($id)
    {
        if (isActivePlugin('cartlookscore')) {
            $category_details = \Plugin\CartLooksCore\Models\ProductCategory::where('permalink', $id)
                ->select('id', 'name', 'banner', 'meta_title', 'meta_image', 'meta_description')
                ->first();

            $category_details->meta_title = $category_details->meta_title != null ? $category_details->meta_title : $category_details->name;
            $category_details->meta_description = $category_details->meta_description != null ? $category_details->meta_description : $category_details->name;
            $category_details->meta_image = $category_details->meta_image != null ? getFilePath($category_details->meta_image, false) : getFilePath($category_details->banner, false);

            return view('theme/cartlooks-theme::frontend.pages.category-products')->with(
                [
                    'category_details' => $category_details
                ]
            );
        }
    }

    /**
     * Will return deals seo info
     * 
     * @param String $id
     * @return mixed
     */
    public function dealsPage($id)
    {
        if (isActivePlugin('flashdeal-cartlooks')) {
            $deals_details = \Plugin\Flashdeal\Models\FlashDeal::where('permalink', $id)->select('id', 'title  as meta_title', 'background_image')->first();
            $deals_details->meta_image = getFilePath($deals_details->background_image, false);
            $deals_details->meta_description = $deals_details->meta_title;

            return view('theme/cartlooks-theme::frontend.pages.deals')->with(
                [
                    'deals_details' => $deals_details
                ]
            );
        }
    }
}

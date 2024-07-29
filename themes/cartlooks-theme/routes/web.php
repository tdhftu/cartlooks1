<?php

use Core\Models\TlPage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Core\Exceptions\ThemeRequiredPluginException;
use Theme\CartLooksTheme\Http\Controllers\Frontend\BlogController;
use Theme\CartLooksTheme\Http\Controllers\Backend\WidgetController;
use Theme\CartLooksTheme\Http\Controllers\Frontend\PagesController;
use Theme\CartLooksTheme\Http\Controllers\Frontend\ProductController;
use Theme\CartLooksTheme\Http\Controllers\Backend\ThemeOptionController;

$prefix = Request::segment(1);

//Frontend 
if ($prefix == null || $prefix != getAdminPrefix()) {

    /**
     * Check required plugin is activated  or not
     */
    if (!isActivePlugin('cartlookscore')) {
        throw new ThemeRequiredPluginException('Please activate cart looks plugin');
    }

    Route::get('/login', [PagesController::class, 'customerLogin']);
    Route::get('/register', [PagesController::class, 'customerRegistration']);

    Route::get('/products', [ProductController::class, 'allProductsPage']);
    Route::get('products/{id}', [ProductController::class, 'productDetails']);
    Route::get('deals/{id}', [ProductController::class, 'dealsPage']);
    Route::get('products/category/{id}', [ProductController::class, 'categoryProducts']);

    Route::get('/blog/{slug}', [BlogController::class, 'getSingleBlogDetails']);
    Route::get('/page/{any}', [PagesController::class, 'getSinglePageDetails'])->where('any', '.*');
    Route::get('/page-preview/{slug}', [PagesController::class, 'getSinglePageDetails']);

    Route::get('/seller-register', [PagesController::class, 'sellerRegistration']);
    Route::get('/all-shops', [PagesController::class, 'allShop']);
    Route::get('/shop/{slug}', [PagesController::class, 'shopPage']);

    Route::get('/{path}', function () {
        $page = TlPage::where('is_home', true)->first();
        return view('theme/cartlooks-theme::frontend.pages.home', compact('page'));
    })->where('path', '.*');
}


//Backend
Route::group(['middleware' => 'auth', 'prefix' => getAdminPrefix()], function () {
    // Widgets
    Route::middleware(['can:Manage Widget'])->group(function () {
        Route::get('/manage-widgets', [WidgetController::class, 'widgets'])->name('theme.cartlooks-theme.widgets');
        Route::post('/get-widget-input', [WidgetController::class, 'getWidgetInputFields'])->name('theme.cartlooks-theme.widget.get_input_field');
        Route::post('/add-widget-sidebar', [WidgetController::class, 'addWidgetToSidebar'])->name('theme.cartlooks-theme.widget.addToSidebar')->middleware('demo');
        Route::post('/remove-widget-sidebar', [WidgetController::class, 'removeWidgetFromSidebar'])->name('theme.cartlooks-theme.widget.removeFromSidebar');
        Route::post('/save-sidebar-widget-form', [WidgetController::class, 'saveWidgetSidebarInput'])->name('theme.cartlooks-theme.widget.widgetSidebarForm')->middleware('demo');
        Route::post('/widget-order-save', [WidgetController::class, 'saveWidgetOrder'])->name('theme.cartlooks-theme.widget.saveWidgetOrder')->middleware('demo');
    });

    Route::middleware(['can:Manage Theme settings'])->group(function () {
        //Theme Options
        Route::get('/theme-options', [ThemeOptionController::class, 'themeOptions'])->name('theme.cartlooks-theme.options');
        Route::post('/get-theme-option-form', [ThemeOptionController::class, 'getOptionForm'])->name('theme.cartlooks-theme.get.option.form');
        Route::post('/save-theme-option-form', [ThemeOptionController::class, 'saveOptionForm'])->name('theme.cartlooks-theme.save.option.form')->middleware('demo');
    });
});

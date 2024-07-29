<?php

use Illuminate\Support\Facades\Route;
use Theme\CartLooksTheme\Http\Controllers\Api\HomePageController;
use Theme\CartLooksTheme\Http\Controllers\Frontend\BlogController;
use Theme\CartLooksTheme\Http\Controllers\Frontend\PagesController;
use Plugin\CartLooksCore\Http\Controllers\LayoutSettingsController;
use Theme\CartLooksTheme\Http\Controllers\Frontend\NewsletterController;
use Theme\CartLooksTheme\Http\Controllers\Frontend\ThemeOptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'theme/cartlooks-theme/v1'], function () {
    Route::get('/active-home-page-sections', [HomePageController::class, 'homePageSections']);

    //Deals Sections
    Route::post('/deal-details', [HomePageController::class, 'dealsDetails']);
    Route::post('/deal-products', [HomePageController::class, 'dealProducts']);

    //Collections sections
    Route::post('/collection-details', [HomePageController::class, 'collectionDetails']);
    Route::post('/collection-all-products', [HomePageController::class, 'collectionAllProducts']);

    //Blogs lists
    Route::post('/home-page-blogs-list', [HomePageController::class, 'homePageBlogs']);


    //Menus & widgets
    Route::get('get-all-menus-for-ecommerce-home', [LayoutSettingsController::class, 'getAllMenusForEcommerceHome']);
    Route::get('get-footer-widgets', [LayoutSettingsController::class, 'getFooterWidgets']);


    //Theme Options
    Route::get('/get-back-to-top-style', [ThemeOptionController::class, 'getBackToTopStyle']);
    Route::get('/get-404-page-style', [ThemeOptionController::class, 'get404PageStyle']);
    Route::get('/get-preloader-style', [ThemeOptionController::class, 'getPreloaderStyle']);
    Route::get('/get-theme-color', [ThemeOptionController::class, 'getThemeColor']);
    Route::get('/get-theme-style', [ThemeOptionController::class, 'getThemeStyle']);
    Route::get('/get-theme-color', [ThemeOptionController::class, 'getPresentColor']);
    Route::get('/get-blog-theme-style', [ThemeOptionController::class, 'getBlogThemeStyle']);

    //Blogs
    Route::get('/blogs', [BlogController::class, 'blogs']);
    Route::get('/get-related-blogs', [BlogController::class, 'getRelatedBlogs']);

    Route::get('/get-blog-sidebar-widgets', [LayoutSettingsController::class, 'getBlogSidebarWidgets']);

    Route::post('/blog/comment/create', [BlogController::class, 'createBlogComment']);
    Route::post('/blog/comment', [BlogController::class, 'loadBlogComment']);
    Route::get('/blog/search', [BlogController::class, 'blogBySearch']);
    Route::get('/blog/{slug}', [BlogController::class, 'blog_details']);
    Route::get('/preview-blog/{slug}', [BlogController::class, 'previewBlog']);

    //Pages
    Route::get('/page/{slug}', [PagesController::class, 'pageDetails']);
    Route::get('/preview-page/{slug}', [PagesController::class, 'previewPage']);
    Route::post('/newsletter-store', [NewsletterController::class, 'store']);
});

<?php

use Illuminate\Support\Facades\Route;
use Plugin\CartLooksCore\Http\Controllers\TaxController;
use Plugin\CartLooksCore\Http\Controllers\UnitController;
use Plugin\CartLooksCore\Http\Controllers\BrandController;
use Plugin\CartLooksCore\Http\Controllers\ColorController;
use Plugin\CartLooksCore\Http\Controllers\OrderController;
use Plugin\CartLooksCore\Http\Controllers\ReportController;
use Plugin\CartLooksCore\Http\Controllers\ProductController;
use Plugin\CartLooksCore\Http\Controllers\CategoryController;
use Plugin\CartLooksCore\Http\Controllers\CurrencyController;
use Plugin\CartLooksCore\Http\Controllers\CustomerController;
use Plugin\CartLooksCore\Http\Controllers\LocationController;
use Plugin\CartLooksCore\Http\Controllers\SettingsController;
use Plugin\CartLooksCore\Http\Controllers\ShippingController;
use \Plugin\CartLooksCore\Http\Controllers\MarketingController;
use Plugin\CartLooksCore\Http\Controllers\ProductTagsController;
use Plugin\CartLooksCore\Http\Controllers\Payment\GpayController;
use Plugin\CartLooksCore\Http\Controllers\Payment\MollieController;
use Plugin\CartLooksCore\Http\Controllers\Payment\PaddleController;
use Plugin\CartLooksCore\Http\Controllers\Payment\PaypalController;
use Plugin\CartLooksCore\Http\Controllers\Payment\StripeController;
use Plugin\CartLooksCore\Http\Controllers\Payment\PaymentController;
use Plugin\CartLooksCore\Http\Controllers\Payment\PaystackController;
use Plugin\CartLooksCore\Http\Controllers\Payment\RazorpayController;
use Plugin\CartLooksCore\Http\Controllers\ProductAttributeController;
use Plugin\CartLooksCore\Http\Controllers\ProductConditionController;
use Plugin\CartLooksCore\Http\Controllers\ProductCollectionController;
use Plugin\CartLooksCore\Http\Controllers\Payment\SSLCommerzController;

Route::group(['middleware' => 'auth', 'prefix' => getAdminPrefix()], function () {

    //product category module
    Route::middleware(['can:Manage Categories', 'license'])->group(function () {
        Route::get('/product-categories', [CategoryController::class, 'categories'])->name('plugin.cartlookscore.product.category.list');
        Route::get('/new-category', [CategoryController::class, 'newCategory'])->name('plugin.cartlookscore.product.category.new');
        Route::post('/new-category-store', [CategoryController::class, 'newCategoryStore'])->name('plugin.cartlookscore.product.category.new.store')->middleware('demo');
        Route::get('/edit-category/{id}', [CategoryController::class, 'editCategory'])->name('plugin.cartlookscore.product.category.edit');
        Route::post('/category-update', [CategoryController::class, 'updateCategory'])->name('plugin.cartlookscore.product.category.update')->middleware('demo');
        Route::post('/category-delete', [CategoryController::class, 'deleteCategory'])->name('plugin.cartlookscore.product.category.delete')->middleware('demo');
        Route::post('/category-bulk--delete', [CategoryController::class, 'deleteBulkCategory'])->name('plugin.cartlookscore.product.category.delete.bulk')->middleware('demo');
        Route::post('/category-change-status', [CategoryController::class, 'categoryChangeStatus'])->name('plugin.cartlookscore.product.category.status.change')->middleware('demo');
        Route::post('/category-change-featured-status', [CategoryController::class, 'changeCategoryFeaturedStatus'])->name('plugin.cartlookscore.product.category.featured.change')->middleware('demo');
    });

    //Product brand module
    Route::middleware(['can:Manage Brands', 'license'])->group(function () {
        Route::get('/product-brands', [BrandController::class, 'productBrands'])->name('plugin.cartlookscore.product.brand.list');
        Route::view('/new-product-brand', 'plugin/cartlookscore::products.brands.new_brand')->name('plugin.cartlookscore.product.brand.new');
        Route::post('/store-new-product-brand', [BrandController::class, 'storeNewProductBrand'])->name('plugin.cartlookscore.product.brand.store')->middleware('demo');
        Route::get('/edit-brand/{id}', [BrandController::class, 'editBrand'])->name('plugin.cartlookscore.product.brand.edit');
        Route::post('/update-product-brand', [BrandController::class, 'updateProductBrand'])->name('plugin.cartlookscore.product.brand.update')->middleware('demo');
        Route::post('/delete-product-brand', [BrandController::class, 'deleteProductBrand'])->name('plugin.cartlookscore.product.brand.delete')->middleware('demo');
        Route::post('/delete-bulk-product-brand', [BrandController::class, 'deleteBulkProductBrand'])->name('plugin.cartlookscore.product.brand.delete.bulk')->middleware('demo');
        Route::post('/change-product-brand-status', [BrandController::class, 'changeProductBrandStatus'])->name('plugin.cartlookscore.product.brand.status.change')->middleware('demo');
        Route::post('/change-product-brand-featured-status', [BrandController::class, 'changeProductBrandFeatured'])->name('plugin.cartlookscore.product.brand.featured.status.change')->middleware('demo');
    });

    //color module
    Route::middleware(['can:Manage Colors', 'license'])->group(function () {
        Route::view('/new-product-color', 'plugin/cartlookscore::products.colors.create_new')->name('plugin.cartlookscore.product.colors.new');
        Route::get('/product-colors', [ColorController::class, 'colors'])->name('plugin.cartlookscore.product.colors.list');
        Route::post('/store-new-product-colors', [ColorController::class, 'storeColor'])->name('plugin.cartlookscore.product.colors.store')->middleware('demo');
        Route::post('/delete-product-color', [ColorController::class, 'deleteColor'])->name('plugin.cartlookscore.product.colors.delete')->middleware('demo');
        Route::get('/product-color-edit/{id}', [ColorController::class, 'editColor'])->name('plugin.cartlookscore.product.colors.edit');
        Route::post('/update-product-color', [ColorController::class, 'updateColor'])->name('plugin.cartlookscore.product.colors.update')->middleware('demo');
        Route::post('/delete-bulk-product-color', [ColorController::class, 'deleteBulkColor'])->name('plugin.cartlookscore.product.colors.delete.bulk')->middleware('demo');
    });

    //product unit module
    Route::middleware(['can:Manage Units', 'license'])->group(function () {
        Route::get('/product-units', [UnitController::class, 'units'])->name('plugin.cartlookscore.product.units.list');
        Route::view('/new-product-unit', 'plugin/cartlookscore::products.units.add_new')->name('plugin.cartlookscore.product.units.new');
        Route::post('/product-unit-store', [UnitController::class, 'storeUnit'])->name('plugin.cartlookscore.product.units.store')->middleware('demo');
        Route::post('/product-unit-delete', [UnitController::class, 'deleteUnit'])->name('plugin.cartlookscore.product.units.delete')->middleware('demo');
        Route::post('/product-unit-bulk-delete', [UnitController::class, 'deleteBulkUnit'])->name('plugin.cartlookscore.product.units.delete.bulk')->middleware('demo');
        Route::get('/edit-product-unit/{id}', [UnitController::class, 'editUnit'])->name('plugin.cartlookscore.product.units.edit');
        Route::post('/product-unit-update', [UnitController::class, 'updateUnit'])->name('plugin.cartlookscore.product.units.update')->middleware('demo');
    });

    //product condition
    Route::middleware(['can:Manage Product Conditions', 'license'])->group(function () {
        Route::get('/product-conditions', [ProductConditionController::class, 'conditions'])->name('plugin.cartlookscore.product.conditions.list');
        Route::view('/new-product-condition', 'plugin/cartlookscore::products.conditions.new_condition')->name('plugin.cartlookscore.product.conditions.new');
        Route::post('/store-product-condition', [ProductConditionController::class, 'storeCondition'])->name('plugin.cartlookscore.product.conditions.store')->middleware('demo');
        Route::post('/change-product-condition-status', [ProductConditionController::class, 'changeConditionStatus'])->name('plugin.cartlookscore.product.conditions.status.change')->middleware('demo');
        Route::post('/product-condition-delete', [ProductConditionController::class, 'deleteCondition'])->name('plugin.cartlookscore.product.conditions.delete')->middleware('demo');
        Route::post('/product-condition-bulk-delete', [ProductConditionController::class, 'deleteBulkCondition'])->name('plugin.cartlookscore.product.conditions.delete.bulk')->middleware('demo');
        Route::get('/product-condition-edit/{id}', [ProductConditionController::class, 'editCondition'])->name('plugin.cartlookscore.product.conditions.edit');
        Route::post('/product-condition-update', [ProductConditionController::class, 'updateCondition'])->name('plugin.cartlookscore.product.conditions.update')->middleware('demo');
    });

    //Product tags module
    Route::middleware(['can:Manage Product Tags', 'license'])->group(function () {
        Route::get('/product-tags', [ProductTagsController::class, 'productTags'])->name('plugin.cartlookscore.product.tags.list');
        Route::view('/add-new-tag', 'plugin/cartlookscore::products.tags.create_new')->name('plugin.cartlookscore.product.tags.add.new');
        Route::post('/store-new-product-tag', [ProductTagsController::class, 'storeTag'])->name('plugin.cartlookscore.product.tags.store')->middleware('demo');
        Route::post('/delete-product-tag', [ProductTagsController::class, 'deleteTag'])->name('plugin.cartlookscore.product.tags.delete')->middleware('demo');
        Route::post('/delete-bulk-product-tag', [ProductTagsController::class, 'deleteBulkTag'])->name('plugin.cartlookscore.product.tags.delete.bulk')->middleware('demo');
        Route::post('/change-status-product-tag', [ProductTagsController::class, 'changeStatus'])->name('plugin.cartlookscore.product.tags.status.change')->middleware('demo');
        Route::get('/edit-product-tag/{id}', [ProductTagsController::class, 'editTag'])->name('plugin.cartlookscore.product.tags.edit');
        Route::post('/update-product-tag', [ProductTagsController::class, 'updateTag'])->name('plugin.cartlookscore.product.tags.update')->middleware('demo');
    });


    //Product Attribute module
    Route::middleware(['can:Manage Attributes', 'license'])->group(function () {
        Route::get('/product-attributes', [ProductAttributeController::class, 'productAttributes'])->name('plugin.cartlookscore.product.attributes.list');
        Route::view('/add-new-product-attribute', 'plugin/cartlookscore::products.attributes.new_attribute')->name('plugin.cartlookscore.product.attributes.add');
        Route::post('/store-product-attribute', [ProductAttributeController::class, 'storeAttribute'])->name('plugin.cartlookscore.product.attributes.store')->middleware('demo');
        Route::get('/edit-product-attribute/{id}', [ProductAttributeController::class, 'editAttribute'])->name('plugin.cartlookscore.product.attributes.edit');
        Route::post('/update-product-attribute', [ProductAttributeController::class, 'updateAttribute'])->name('plugin.cartlookscore.product.attributes.update')->middleware('demo');
        Route::post('/delete-product-attribute', [ProductAttributeController::class, 'deleteAttribute'])->name('plugin.cartlookscore.product.attributes.delete')->middleware('demo');
        Route::post('/delete-bulk-product-attribute', [ProductAttributeController::class, 'deleteBulkAttribute'])->name('plugin.cartlookscore.product.attributes.delete.bulk')->middleware('demo');
        Route::get('/product-attribute-values/{id}', [ProductAttributeController::class, 'attributeValues'])->name('plugin.cartlookscore.product.attributes.values');
        Route::post('/product-attribute-values-store', [ProductAttributeController::class, 'attributeValuesStore'])->name('plugin.cartlookscore.product.attributes.values.store')->middleware('demo');
        Route::post('/product-attribute-values-delete', [ProductAttributeController::class, 'attributeValueDelete'])->name('plugin.cartlookscore.product.attributes.values.delete')->middleware('demo');
        Route::get('/product-attribute-value-edit/{id}', [ProductAttributeController::class, 'attributeValueEdit'])->name('plugin.cartlookscore.product.attributes.values.edit');
        Route::post('/product-attribute-value-update', [ProductAttributeController::class, 'attributeValueUpdate'])->name('plugin.cartlookscore.product.attributes.values.update')->middleware('demo');
        Route::post('/product-attribute-status-change', [ProductAttributeController::class, 'attributeStatusChange'])->name('plugin.cartlookscore.product.attributes.status.change')->middleware('demo');
        Route::post('/product-attribute-value-status-change', [ProductAttributeController::class, 'attributeValueStatusChange'])->name('plugin.cartlookscore.product.attributes.value.status.change')->middleware('demo');
    });

    //Product list
    Route::get('/product-dropdown-options', [ProductController::class, 'productDropdownOptions'])->name('plugin.cartlookscore.product.dropdown.options');
    Route::middleware(['can:Manage Inhouse Products', 'license'])->group(function () {
        Route::get('/products', [ProductController::class, 'productList'])->name('plugin.cartlookscore.product.list');
        Route::post('/product-bulk-action', [ProductController::class, 'productBulkAction'])->name('plugin.cartlookscore.product.bulk.action');
        Route::post('/update-product-status', [ProductController::class, 'updateProductStatus'])->name('plugin.cartlookscore.product.status.update')->middleware('demo');
        Route::post('/update-product-approval-status', [ProductController::class, 'updateProductApprovalStatus'])->name('plugin.cartlookscore.product.approval.status.update')->middleware('demo');
        Route::post('/update-product-featured-status', [ProductController::class, 'updateProductFeaturedStatus'])->name('plugin.cartlookscore.product.status.featured.update')->middleware('demo');
        Route::post('/delete-product', [ProductController::class, 'deleteProduct'])->name('plugin.cartlookscore.product.delete');
        Route::post('/view-product-quick-action-modal', [ProductController::class, 'viewProductQuickActionForm'])->name('plugin.cartlookscore.product.quick.action.modal.view');
        Route::post('/product-quick-discount-update', [ProductController::class, 'updateProductDiscount'])->name('plugin.cartlookscore.product.quick.update.discount')->middleware('demo');
        Route::post('/product-quick-price-update', [ProductController::class, 'updateProductPrice'])->name('plugin.cartlookscore.product.quick.update.price')->middleware('demo');
        Route::post('/product-quick-stock-update', [ProductController::class, 'updateProductStock'])->name('plugin.cartlookscore.product.quick.update.stock')->middleware('demo');
    });

    //Product reviews
    Route::middleware(['can:Manage Product Reviews', 'license'])->group(function () {
        Route::get('/product-reviews', [ProductController::class, 'productReviewsList'])->name('plugin.cartlookscore.product.reviews.list');
        Route::post('/update-product-review-status', [ProductController::class, 'updateProductReviewStatus'])->name('plugin.cartlookscore.product.reviews.status.change')->middleware('demo');
        Route::post('/product-review-delete', [ProductController::class, 'productReviewelete'])->name('plugin.cartlookscore.product.reviews.delete')->middleware('demo');
    });

    //product form
    Route::get('/product-categories-options', [ProductController::class, 'productCategoryOption'])->name('plugin.cartlookscore.product.category.option');
    Route::get('/product-brands-options', [ProductController::class, 'productBrandsOption'])->name('plugin.cartlookscore.product.brand.option');
    Route::get('/product-tags-options', [ProductController::class, 'productTagsOption'])->name('plugin.cartlookscore.product.tag.option');
    Route::get('/product-cod-countries-dropdown-options', [ProductController::class, 'codCountriesDropdownOptions'])->name('plugin.cartlookscore.product.cod.countries.dropdown.option');
    Route::get('/product-cod-states-dropdown-options', [ProductController::class, 'codStateDropdownOptions'])->name('plugin.cartlookscore.product.cod.state.dropdown.option');
    Route::get('/product-cod-cities-dropdown-options', [ProductController::class, 'codCityDropdownOptions'])->name('plugin.cartlookscore.product.cod.city.dropdown.option');


    Route::middleware(['can:Manage Add New Product', 'license'])->group(function () {
        Route::get('/add-new-product', [ProductController::class, 'addNewProduct'])->name('plugin.cartlookscore.product.add.new');
        Route::post('/store-new-product', [ProductController::class, 'storeNewProduct'])->name('plugin.cartlookscore.product.store.new')->middleware('demo');
    });

    Route::middleware(['can:Manage Inhouse Products', 'license'])->group(function () {
        Route::get('/edit-product/{id}', [ProductController::class, 'editProduct'])->name('plugin.cartlookscore.product.edit');
        Route::post('/update-product', [ProductController::class, 'updateProduct'])->name('plugin.cartlookscore.product.update')->middleware('demo');
    });

    Route::post('/add-product-choice-option', [ProductController::class, 'addProductChoiceOption'])->name('plugin.cartlookscore.product.form.add.choice.option');
    Route::post('/generate-product-variant-combination', [ProductController::class, 'variantCombination'])->name('plugin.cartlookscore.product.form.variant.combination');
    Route::post('/load-color-variant-image-input', [ProductController::class, 'colorVariantImageInput'])->name('plugin.cartlookscore.product.form.color.variant.image.input');

    /**
     * 
     * Product collections
     */
    Route::middleware(['can:Manage Product collections', 'license'])->group(function () {
        Route::get('/product-collections', [ProductCollectionController::class, 'collections'])->name('plugin.cartlookscore.product.collection.list');
        Route::get('/add-new-product-collection', [ProductCollectionController::class, 'newCollection'])->name('plugin.cartlookscore.product.collection.add.new');
        Route::post('/store-new-product-collection', [ProductCollectionController::class, 'storeNewCollection'])->name('plugin.cartlookscore.product.collection.store.new')->middleware('demo');
        Route::get('/edit-product-collection/{id}', [ProductCollectionController::class, 'editCollection'])->name('plugin.cartlookscore.product.collection.edit');
        Route::post('/update-product-collection', [ProductCollectionController::class, 'updateCollection'])->name('plugin.cartlookscore.product.collection.update')->middleware('demo');
        Route::post('/delete-product-collection', [ProductCollectionController::class, 'deleteCollection'])->name('plugin.cartlookscore.product.collection.delete')->middleware('demo');
        Route::post('/update-product-collection-status', [ProductCollectionController::class, 'updateCollectionStatus'])->name('plugin.cartlookscore.product.collection.update.status')->middleware('demo');
        Route::post('/bulk-delete-product-collection', [ProductCollectionController::class, 'deleteBulkCollection'])->name('plugin.cartlookscore.product.collection.delete.bulk')->middleware('demo');
        Route::get('/collection-products/{id}', [ProductCollectionController::class, 'collectionProducts'])->name('plugin.cartlookscore.product.collection.products');
        Route::post('/store-collection-products', [ProductCollectionController::class, 'storeCollectionProducts'])->name('plugin.cartlookscore.product.collection.products.store')->middleware('demo');
        Route::post('/remove-collection-product', [ProductCollectionController::class, 'removeCollectionProduct'])->name('plugin.cartlookscore.product.collection.products.remove')->middleware('demo');
        Route::post('/bulk-remove-collection-product', [ProductCollectionController::class, 'removeBulkCollectionProduct'])->name('plugin.cartlookscore.product.collection.products.remove.bulk')->middleware('demo');
    });

    /**
     * Shipping modules routes
     */
    Route::group(['prefix' => 'shipping'], function () {
        Route::middleware(['can:Manage Shipping & Delivery', 'license'])->group(function () {
            //shipping and delivery
            Route::get('/configuration', [ShippingController::class, 'shippingAndDelivery'])->name('plugin.cartlookscore.shipping.configuration');
            Route::post('/update-shipping-option', [ShippingController::class, 'updateShippingOption'])->name('plugin.cartlookscore.shipping.option.update')->middleware('demo');
            Route::post('/update-flat-rate-shipping', [ShippingController::class, 'updateFlatRateShipping'])->name('plugin.cartlookscore.shipping.flat.rate.update')->middleware('demo');
            //Shipping time 
            Route::post('/store-new-shipping-time', [ShippingController::class, 'storeShippingTime'])->name('plugin.cartlookscore.shipping.time.store')->middleware('demo');
            Route::post('/delete-shipping-time', [ShippingController::class, 'deleteShippingTime'])->name('plugin.cartlookscore.shipping.time.delete')->middleware('demo');

            //Shipping Profiles
            Route::get('/create-shipping-profile', [ShippingController::class, 'shippingProfileForm'])->name('plugin.cartlookscore.shipping.profile.form');
            Route::post('/store-shipping-profile', [ShippingController::class, 'storeShippingProfile'])->name('plugin.cartlookscore.shipping.profile.store')->middleware('demo');
            Route::get('/manage-shipping-profile/{id}', [ShippingController::class, 'manageShippingProfile'])->name('plugin.cartlookscore.shipping.profile.manage');
            Route::post('/update-shipping-profile', [ShippingController::class, 'updateShippingProfile'])->name('plugin.cartlookscore.shipping.profile.update')->middleware('demo');
            Route::post('/update-shipping-product-list', [ShippingController::class, 'updateShippingProductList'])->name('plugin.cartlookscore.shipping.profile.update.product.list')->middleware('demo');
            Route::post('/remove-product-from-profile', [ShippingController::class, 'removeProduct'])->name('plugin.cartlookscore.shipping.profile.product.remove')->middleware('demo');
            Route::post('/delete-shipping-profile', [ShippingController::class, 'deleteShippingProfile'])->name('plugin.cartlookscore.shipping.profile.delete')->middleware('demo');

            //Shipping Zones
            Route::post('/locations-ul-list', [ShippingController::class, 'locationUlList'])->name('plugin.cartlookscore.shipping.location.ul.list');
            Route::post('/locations-ul-list-edit', [ShippingController::class, 'locationUlListEdt'])->name('plugin.cartlookscore.shipping.location.ul.list.edit');
            Route::post('/search-locations-ul-list', [ShippingController::class, 'searchLocationUlList'])->name('plugin.cartlookscore.shipping.search.location.ul.list');
            Route::post('/search-locations-ul-list-edit', [ShippingController::class, 'searchLocationUlListEdit'])->name('plugin.cartlookscore.shipping.search.location.ul.list.edit');
            Route::post('/locations-searched-ul-list', [ShippingController::class, 'locationSearchedUlList'])->name('plugin.cartlookscore.shipping.location.searched.list');
            Route::post('/store-shipping-new-zone', [ShippingController::class, 'storeNewShippingZone'])->name('plugin.cartlookscore.shipping.profile.zones.store')->middleware('demo');
            Route::post('/edit-shipping-zone', [ShippingController::class, 'editShippingZone'])->name('plugin.cartlookscore.shipping.profile.zones.edit');
            Route::post('/update-shipping-zone', [ShippingController::class, 'updateShippingZone'])->name('plugin.cartlookscore.shipping.profile.zones.update')->middleware('demo');
            Route::post('/delete-shipping-zone', [ShippingController::class, 'deleteZone'])->name('plugin.cartlookscore.shipping.zones.delete')->middleware('demo');
            //Shipping Rates
            Route::post('/store-shipping-rate', [ShippingController::class, 'storeShippingRate'])->name('plugin.cartlookscore.shipping.store.rate')->middleware('demo');
            Route::post('/edit-shipping-rate', [ShippingController::class, 'editShippingRate'])->name('plugin.cartlookscore.shipping.rate.edit');
            Route::post('/update-shipping-rate', [ShippingController::class, 'updateShippingRate'])->name('plugin.cartlookscore.shipping.rate.update')->middleware('demo');
            Route::post('/delete-shipping-rate', [ShippingController::class, 'deleteShippingRate'])->name('plugin.cartlookscore.shipping.delete.rate')->middleware('demo');
            Route::get('/load-carrier-shipping-weight-range', function () {
                return view('plugin/cartlookscore::shipping.configuration.carrier-shipping-weight-range');
            })->name('plugin.cartlookscore.shipping.carrier.weight.range.input');
        });



        Route::middleware(['can:Manage Locations'])->group(function () {
            //countries module
            Route::get('/countries', [LocationController::class, 'countries'])->name('plugin.cartlookscore.shipping.locations.country.list');
            Route::get('/new-country', [LocationController::class, 'newCountry'])->name('plugin.cartlookscore.shipping.locations.country.new');
            Route::post('/store-new-country', [LocationController::class, 'storeNewCountry'])->name('plugin.cartlookscore.shipping.locations.country.new.store')->middleware('demo');
            Route::post('/delete-country', [LocationController::class, 'deleteCountry'])->name('plugin.cartlookscore.shipping.locations.country.delete')->middleware('demo');
            Route::post('/country-status-change', [LocationController::class, 'countryStatusChange'])->name('plugin.cartlookscore.shipping.locations.country.status.change')->middleware('demo');
            Route::get('/edit-country/{id}', [LocationController::class, 'editCountry'])->name('plugin.cartlookscore.shipping.locations.country.edit');
            Route::post('/update-country', [LocationController::class, 'updateCountry'])->name('plugin.cartlookscore.shipping.locations.country.update')->middleware('demo');
            Route::post('/country-bulk-actions', [LocationController::class, 'countryBulkActions'])->name('plugin.cartlookscore.shipping.locations.country.bulk.action')->middleware('demo');

            //states
            Route::get('/states', [LocationController::class, 'states'])->name('plugin.cartlookscore.shipping.locations.states.list');
            Route::get('/add-new-state', [LocationController::class, 'newState'])->name('plugin.cartlookscore.shipping.locations.states.new.add');
            Route::post('/add-new-state', [LocationController::class, 'storeState'])->name('plugin.cartlookscore.shipping.locations.states.new.store')->middleware('demo');
            Route::post('/delete-state', [LocationController::class, 'deleteState'])->name('plugin.cartlookscore.shipping.locations.states.delete')->middleware('demo');
            Route::post('/change-state-status', [LocationController::class, 'changeStateStatus'])->name('plugin.cartlookscore.shipping.locations.states.status.change')->middleware('demo');
            Route::get('/edit-state/{id}', [LocationController::class, 'editState'])->name('plugin.cartlookscore.shipping.locations.states.edit');
            Route::post('/update-state', [LocationController::class, 'updateState'])->name('plugin.cartlookscore.shipping.locations.states.update')->middleware('demo');
            Route::post('/state-bulk-actions', [LocationController::class, 'stateBulkActions'])->name('plugin.cartlookscore.shipping.locations.states.bulk.action')->middleware('demo');

            //cities
            Route::get('/cities', [LocationController::class, 'cities'])->name('plugin.cartlookscore.shipping.locations.cities.list');
            Route::get('/add-new-city', [LocationController::class, 'newCity'])->name('plugin.cartlookscore.shipping.locations.cities.add.new');
            Route::post('/store-new-city', [LocationController::class, 'storeNewCity'])->name('plugin.cartlookscore.shipping.locations.cities.store.new')->middleware('demo');
            Route::post('/delete-city', [LocationController::class, 'deleteCity'])->name('plugin.cartlookscore.shipping.locations.cities.delete')->middleware('demo');
            Route::post('/change-city-status', [LocationController::class, 'changeCityStatus'])->name('plugin.cartlookscore.shipping.locations.cities.status.change')->middleware('demo');
            Route::get('/edit-city/{id}', [LocationController::class, 'editCity'])->name('plugin.cartlookscore.shipping.locations.cities.edit');
            Route::post('/update-city', [LocationController::class, 'updateCity'])->name('plugin.cartlookscore.shipping.locations.cities.update')->middleware('demo');
            Route::post('/cities-bulk-actions', [LocationController::class, 'cityBulkActions'])->name('plugin.cartlookscore.shipping.locations.cities.bulk.action')->middleware('demo');
        });
    });
    /**
     * E commerce settings Module
     */
    Route::group(['prefix' => 'ecommerce-settings'], function () {
        //taxes
        Route::middleware(['can:Manage Taxes', 'license'])->group(function () {
            Route::get('/taxes', [TaxController::class, 'taxes'])->name('plugin.cartlookscore.ecommerce.settings.taxes.list');
            Route::post('/store-tax-profile', [TaxController::class, 'storeTaxProfile'])->name('plugin.cartlookscore.ecommerce.settings.taxes.store.profile')->middleware('demo');
            Route::post('/update-tax-profile', [TaxController::class, 'updateTaxProfile'])->name('plugin.cartlookscore.ecommerce.settings.taxes.update.profile')->middleware('demo');
            Route::post('/delete-tax-profile', [TaxController::class, 'deleteTaxProfile'])->name('plugin.cartlookscore.ecommerce.settings.taxes.delete.profile')->middleware('demo');
            Route::get('/manage-tax-rate/{id}', [TaxController::class, 'manageTaxRates'])->name('plugin.cartlookscore.ecommerce.settings.taxes.manage.rates');
            Route::post('/store-new-tax-rates', [TaxController::class, 'storeTaxRates'])->name('plugin.cartlookscore.ecommerce.settings.taxes.store.rates')->middleware('demo');
            Route::post('/update-tax-rate-value', [TaxController::class, 'updateTaxRateValue'])->name('plugin.cartlookscore.ecommerce.settings.taxes.update.rates.value');
            Route::post('/update-tax-rate-post-code', [TaxController::class, 'updateTaxRatePostCode'])->name('plugin.cartlookscore.ecommerce.settings.taxes.update.rates.post.code');
            Route::post('/update-tax-rate-name', [TaxController::class, 'updateTaxRateName'])->name('plugin.cartlookscore.ecommerce.settings.taxes.update.rates.name');
            Route::post('/bulk-action-tax-rate', [TaxController::class, 'taxRateBulkAction'])->name('plugin.cartlookscore.ecommerce.settings.taxes.rates.bulk.action')->middleware('demo');
        });

        //Product share option
        Route::middleware(['can:Manage Product Share Options'])->group(function () {
            Route::get('/product-share-options', [ProductController::class, 'shareOptions'])->name('plugin.cartlookscore.products.share.options');
            Route::post('/product-share-option-update-status', [ProductController::class, 'shareOptionUpdateStatus'])->name('plugin.cartlookscore.products.share.options.update.status')->middleware('demo');
        });

        //e-Commerce settings
        Route::middleware(['can:Manage Settings', 'license'])->group(function () {
            Route::get('/config', [SettingsController::class, 'ecommerceConfig'])->name('plugin.cartlookscore.ecommerce.configuration');
            Route::post('/update-ecommerce-settings', [SettingsController::class, 'updateEcommerceSettings'])->name('plugin.cartlookscore.ecommerce.configuration.update')->middleware('demo');
        });

        //Currency Settings
        Route::middleware(['can:Manage Currencies', 'license'])->group(function () {
            Route::get('/add-currency', [CurrencyController::class, 'addCurrency'])->name('plugin.cartlookscore.ecommerce.add.currency');
            Route::post('/add-currency', [CurrencyController::class, 'storeCurrency'])->name('plugin.cartlookscore.ecommerce.store.currency')->middleware('demo');
            Route::get('/all-currencies', [CurrencyController::class, 'allCurrencies'])->name('plugin.cartlookscore.ecommerce.all.currencies');
            Route::post('/update-currency-status', [CurrencyController::class, 'updateCurrencyStatus'])->name('plugin.cartlookscore.ecommerce.update.currency.status')->middleware('demo');
            Route::get('/edit-currency/{id}', [CurrencyController::class, 'editCurrency'])->name('plugin.cartlookscore.ecommerce.edit.currency');
            Route::post('/update-currency', [CurrencyController::class, 'updateCurrency'])->name('plugin.cartlookscore.ecommerce.update.currency')->middleware('demo');
            Route::post('/delete-currency', [CurrencyController::class, 'deleteCurrency'])->name('plugin.cartlookscore.ecommerce.currency.delete')->middleware('demo');
        });
    });
    /**
     * Orders Module
     */
    Route::group(['prefix' => 'orders'], function () {
        Route::middleware(['can:Manage Inhouse Orders', 'license'])->group(function () {
            Route::get('/inhouse-orders', [OrderController::class, 'inhouseOrders'])->name('plugin.cartlookscore.orders.inhouse');
        });
        Route::post('/order-status-details', [OrderController::class, 'orderStatusDetails'])->name('plugin.cartlookscore.orders.status.details');
        Route::get('/order-details/{id}', [OrderController::class, 'orderDetails'])->name('plugin.cartlookscore.orders.details')->middleware(['can:Manage Order Details', 'license']);
        Route::post('/accept-order', [OrderController::class, 'acceptOrder'])->name('plugin.cartlookscore.orders.accept')->middleware('demo');
        Route::post('/update-order-status', [OrderController::class, 'updateOrderStatus'])->name('plugin.cartlookscore.orders.status.update')->middleware('demo');
        Route::post('/cancel-order', [OrderController::class, 'cancelOrder'])->name('plugin.cartlookscore.orders.cancel')->middleware('demo');
        Route::post('/cancel-order-item', [OrderController::class, 'cancelOrderItem'])->name('plugin.cartlookscore.orders.item.cancel')->middleware('demo');
        Route::post('/order-bulk-action', [OrderController::class, 'orderBulkAction'])->name('plugin.cartlookscore.orders.bulk.action')->middleware('demo');
        Route::post('/print-shipping-label', [OrderController::class, 'printShippingLabel'])->name('plugin.cartlookscore.orders.print.shipping.label');
        Route::post('/print-order-invoice', [OrderController::class, 'printInvoice'])->name('plugin.cartlookscore.orders.print.invoice');
    });
    /**
     *Payments Module
     */
    Route::group(['prefix' => 'payments'], function () {
        Route::middleware(['can:Manage Payment Methods', 'license'])->group(function () {
            Route::get('/payment-methods', [PaymentController::class, 'paymentMethods'])->name('plugin.cartlookscore.payments.methods')->middleware('license');
            Route::post('/change-payment-method-status', [PaymentController::class, 'changePaymentMethodStatus'])->name('plugin.cartlookscore.payments.methods.status.update')->middleware('demo');
            Route::post('/update-payment-method-credential', [PaymentController::class, 'updatePaymentMethodCredential'])->name('plugin.cartlookscore.payments.methods.credential.update')->middleware('demo');
        });
        Route::middleware(['can:Manage Transaction history'])->group(function () {
            Route::get('/transaction-history', [PaymentController::class, 'transactionHistory'])->name('plugin.cartlookscore.payments.transactions.history');
        });
    });

    /**
     *customers Module
     */
    Route::middleware(['can:Manage Customers', 'license'])->group(function () {
        Route::get('/customers', [CustomerController::class, 'customers'])->name('plugin.cartlookscore.customers.list');
        Route::post('/change-customer-status', [CustomerController::class, 'changeCustomerStatus'])->name('plugin.cartlookscore.customers.change.status')->middleware('demo');
        Route::get('customer-details/{id}', [CustomerController::class, 'customerDetails'])->name('plugin.cartlookscore.customers.details');
        Route::post('/reset-customer-password', [CustomerController::class, 'resetCustomerPassword'])->name('plugin.cartlookscore.customers.password.reset')->middleware('demo');
        Route::post('/update-customer-info', [CustomerController::class, 'updateCustomerInfo'])->name('plugin.cartlookscore.customers.info.update')->middleware('demo');
        Route::post('/customer-secret-login', [CustomerController::class, 'customerSecretLogin'])->name('plugin.cartlookscore.customers.login.secret')->middleware('demo');
        Route::post('/delete-customer', [CustomerController::class, 'deleteCustomer'])->name('plugin.cartlookscore.customers.delete')->middleware('demo');
    });

    /**
     * Reports Routes
     */
    Route::middleware(['can:Manage Product Reports'])->group(function () {
        Route::get('/products-report', [ReportController::class, 'productReport'])->name('plugin.cartlookscore.reports.products');
    });

    Route::middleware(['can:Manage Wishlist Reports'])->group(function () {
        Route::get('/products-wishlist-report', [ReportController::class, 'productWishlistReport'])->name('plugin.cartlookscore.reports.products.wishlist');
    });

    Route::middleware(['can:Manage Keyword Search Reports'])->group(function () {
        Route::get('/user-keyword-search', [ReportController::class, 'userKeywordSearch'])->name('plugin.cartlookscore.reports.search.keyword');
    });

    Route::post('/sales-chart-report', [ReportController::class, 'salesChartReport'])->name('plugin.cartlookscore.reports.sales.chart');

    //Dashboard stats
    Route::post('/business-stats-analysis', [ReportController::class, 'businessStatsAnalysis'])->name('plugin.cartlookscore.business.stats');

    /**
     * Marketing Modules
     */
    Route::middleware(['can:Manage Custom notification', "license"])->group(function () {
        Route::get('/custom-notifications', [MarketingController::class, 'customNotifications'])->name('plugin.cartlookscore.marketing.custom.notification');
        Route::get('/create-new-custom-notifications', [MarketingController::class, 'newCustomNotifications'])->name('plugin.cartlookscore.marketing.custom.notification.create.new');
        Route::get('/get-customer-options', [MarketingController::class, 'getCustomerOptions'])->name('plugin.cartlookscore.marketing.custom.notification.customer.options');
        Route::get('/get-users-options', [MarketingController::class, 'getUsersOptions'])->name('plugin.cartlookscore.marketing.custom.notification.users.options');
        Route::get('/get-user-roles-options', [MarketingController::class, 'getUserRolesOptions'])->name('plugin.cartlookscore.marketing.custom.notification.user.roles.options');
        Route::post('/send-custom-notification', [MarketingController::class, 'sendCustomNotification'])->name('plugin.cartlookscore.marketing.custom.notification.send')->middleware('demo');
        Route::post('/custom-notification-bulk-action', [MarketingController::class, 'customNotificationBulkAction'])->name('plugin.cartlookscore.marketing.custom.notification.bulk.action');
    });
});

/**
 * Product review details
 */
Route::post(getAdminPrefix() . '/product-review-details', [ProductController::class, 'productReviewDetails'])->name('plugin.cartlookscore.product.reviews.details');

/**
 * Payment page
 */
Route::get('/payment/{id}/pay', [PaymentController::class, 'createPayment']);

/**
 * Stripe payment 
 */
Route::any('/stripe/create-session', [StripeController::class, 'create_checkout_session'])->name('stripe.generate.token');
Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success.payment');
Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel.payment');

/**
 * Paypal payment
 */
Route::get('/paypal/success', [PaypalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');

/**
 * paddle payment
 */
Route::any('/paddle/success', [PaddleController::class, 'paddleSuccess'])->name('paddle.payment.success');
Route::any('/paddle/return', [PaddleController::class, 'paddleReturn'])->name('paddle.payment.return');

/**
 * SSLCommerz payment 
 */
Route::any('/ssl-commerce/success', [SSLCommerzController::class, 'success'])->name('sslcommerz.success.payment');
Route::any('/ssl-commerce/cancel', [SSLCommerzController::class, 'cancel'])->name('sslcommerz.cancel.payment');
Route::any('/ssl-commerce/fail', [SSLCommerzController::class, 'fail'])->name('sslcommerz.fail.payment');

//Paystack
Route::get('/pay/callback', [PaystackController::class, 'callback'])->name('pay.callback');

//Razorpay
Route::post('/razorpay-payment-submit', [RazorpayController::class, 'paymentStatus'])->name('razorpay.payment.submit');

//Mollie
Route::get('/payment-callback', [MollieController::class, 'paymentCallback'])->name('payment.callback');
Route::get('/payment-webhook', [MollieController::class, 'paymentWebhook'])->name('payment.webhook');

//Google pay
Route::post('/googlepay-payment-submit', [GpayController::class, 'googlepayPaymentSubmit'])->name('googlepay.payment.submit');

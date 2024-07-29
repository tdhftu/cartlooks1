<?php

use Illuminate\Support\Facades\Route;
use Plugin\Coupon\Http\Controllers\CouponController;

Route::group(['prefix' => getAdminPrefix()], function () {
    /**
     * Marketings Modules
     */
    Route::group(['prefix' => 'marketing'], function () {
        Route::middleware(['can:Manage Coupons'])->group(function () {
            //coupon
            Route::get('/coupons', [CouponController::class, 'coupons'])->name('plugin.coupon.marketing.coupon.list');
            Route::get('/create-new-coupon', [CouponController::class, 'createNewCoupon'])->name('plugin.coupon.marketing.coupon.create.new');
            Route::post('/store-new-coupon', [CouponController::class, 'storeNewCoupon'])->name('plugin.coupon.marketing.coupon.store.new')->middleware('demo');
            Route::get('/edit-coupon/{id}', [CouponController::class, 'editCoupon'])->name('plugin.coupon.marketing.coupon.edit');
            Route::post('/update-coupon', [CouponController::class, 'updateCoupon'])->name('plugin.coupon.marketing.coupon.update')->middleware('demo');
            Route::post('/update-coupon-status', [CouponController::class, 'updateCouponStatus'])->name('plugin.coupon.marketing.coupon.update.status')->middleware('demo');
            Route::post('/delete-coupon', [CouponController::class, 'deleteCoupon'])->name('plugin.coupon.marketing.coupon.delete')->middleware('demo');
            Route::post('/delete-bulk-coupon', [CouponController::class, 'deleteBulkCoupon'])->name('plugin.coupon.marketing.coupon.bulk.delete')->middleware('demo');
        });
    });
});

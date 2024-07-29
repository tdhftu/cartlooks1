<?php

use Illuminate\Support\Facades\Route;
use Plugin\TlPageBuilder\Http\Controllers\PageBuilderController;

Route::group(['prefix' => getAdminPrefix()], function () {

    Route::middleware(['can:Manage Tlcommerce Page Builder'])->group(function () {
        // Section Routes
        Route::get('page-builder-sections', [PageBuilderController::class, 'pageSections'])->name('plugin.builder.pageSections');
        Route::post('page-builder/section/create', [PageBuilderController::class, 'newSection'])->name('plugin.builder.pageSection.new');
        Route::post('page-builder/section/remove', [PageBuilderController::class, 'removeSection'])->name('plugin.builder.pageSection.remove')->middleware('demo');
        Route::post('page-builder/section/sorting', [PageBuilderController::class, 'sortingSection'])->name('plugin.builder.pageSection.sorting')->middleware('demo');
        Route::post('page-builder/section/get-properties', [PageBuilderController::class, 'getSectionProperties'])->name('plugin.builder.pageSection.get.properties');
        Route::post('page-builder/update-properties', [PageBuilderController::class, 'updateSectionProperties'])->name('plugin.builder.pageSection.update.properties')->middleware('demo');

        // Widget Routes
        Route::post('page-builder/widget/add', [PageBuilderController::class, 'addWidget'])->name('plugin.builder.pageSection.widget.add');
        Route::post('page-builder/widget/remove', [PageBuilderController::class, 'removeWidget'])->name('plugin.builder.pageSection.widget.remove');
        Route::post('page-builder/widget/update-position', [PageBuilderController::class, 'updateWidgetPosition'])->name('plugin.builder.pageSection.widget.updatePosition')->middleware('demo');
        Route::post('page-builder/widget/order', [PageBuilderController::class, 'orderWidget'])->name('plugin.builder.pageSection.widget.order');
        Route::post('page-builder/widget/get-properties', [PageBuilderController::class, 'getWidgetProperties'])->name('plugin.builder.pageSection.widget.get.properties');
        Route::post('page-builder/widget/update-properties', [PageBuilderController::class, 'updateWidgetProperties'])->name('plugin.builder.pageSection.widget.update.properties')->middleware('demo');

        // Text Editor Image Upload
        Route::post('page-builder/text-editor/upload', [PageBuilderController::class, 'imageUpload'])->name('plugin.builder.pageSection.text-editor.upload');

        // Banner Widgets Routes
        Route::get('banner/modal/show', [PageBuilderController::class, 'showModal'])->name('plugin.builder.pageSection.banner.show');
        Route::post('banner/modal/save', [PageBuilderController::class, 'saveSlider'])->name('plugin.builder.pageSection.banner.save')->middleware('demo');
        Route::delete('banner/modal/delete', [PageBuilderController::class, 'deleteSlider'])->name('plugin.builder.pageSection.banner.delete')->middleware('demo');

        // Service Feature Widgets Routes
        Route::get('feature/modal/show', [PageBuilderController::class, 'showModalFeature'])->name('plugin.builder.pageSection.feature.show');
        Route::post('feature/modal/save', [PageBuilderController::class, 'saveFeature'])->name('plugin.builder.pageSection.feature.save')->middleware('demo');
        Route::delete('feature/modal/delete', [PageBuilderController::class, 'deleteFeature'])->name('plugin.builder.pageSection.feature.delete')->middleware('demo');
    });
});

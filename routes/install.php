<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;

Route::group(['prefix' => 'install', 'middleware' => ['web', 'install', 'redirectIfInstalled']], function () {
    Route::get('/', [InstallController::class, 'index'])->name('install.welcome');
    Route::get('/check-requirements', [InstallController::class, 'requirements'])->name('install.requirements');
    Route::get('/check-permissions', [InstallController::class, 'permissions'])->name('install.permissions');
    Route::view('/database', 'install.database')->name('install.database');
    Route::post('/set-database-credentials', [InstallController::class, 'setDatabaseCredentials'])->name('install.database.save.credentials');
    Route::view('/import-sql', 'install.import_sql')->name('install.database.import');
    Route::post('/run-sql', [InstallController::class, 'runSql'])->name('install.database.run.sql');
    Route::view('/registration', 'install.registration')->name('install.user.registration');
    Route::post('/registration', [InstallController::class, 'adminRegistration'])->name('install.user.registration.complete');
});

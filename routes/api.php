<?php

use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

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


Route::prefix('/v1')->group(function () {

    Route::prefix('/tags')->group(function () {
        Route::post('/create', [TagController::class, 'createTag']);
    });

//    Route::prefix('/billing-address')->group(function () {
//        Route::get('/populate', [BillingAddressController::class, 'populate']);
//    });
//    Route::prefix('/invoice')->group(function () {
//        Route::get('/populate', [InvoiceController::class, 'populate']);
//        Route::post('/create', [InvoiceController::class, 'create']);
//        Route::post('/edit/{uuid}', [InvoiceController::class, 'edit']);
//        Route::delete('/delete/{uuid}', [InvoiceController::class, 'delete']);

});

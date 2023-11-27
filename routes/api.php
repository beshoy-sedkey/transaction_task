<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
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

Route::post('login' , [AuthController::class , 'login']);

Route::middleware('auth:api')->group(function(){
    Route::resource('transaction' , 'App\Http\Controllers\TransactionController');
    Route::get('transaction/show/by/user' , [TransactionController::class , 'showUserTransaction']);
    Route::post('create/transaction/details/{transaction}' , [TransactionController::class , 'createTransactionDetails']);
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



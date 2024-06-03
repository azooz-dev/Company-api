<?php

use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
| Seller
*/
Route::resource('sellers', SellerController::class)->only('index', 'show');

/*
| Buyer
*/
Route::resource('buyers', BuyerController::class)->only('index', 'show');

/*
| Category
*/
Route::resource('categories', CategoryController::class)->except('create', 'edit');

/*
| Product
*/
Route::resource('products', ProductController::class)->only('index', 'show');

/*
| Transaction
*/
Route::resource('transactions', TransactionController::class)->only('index', 'show');

/*
| User
*/
Route::resource('users', UserController::class)->except('create', 'edit');
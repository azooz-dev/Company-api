<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Buyer\BuyerCategoryController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryBuyerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Category\CategorySellerController;
use App\Http\Controllers\Category\CategoryTransactionController;
use App\Http\Controllers\Product\ProductBuyerController;
use App\Http\Controllers\Product\ProductBuyerTransactionController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductTransactionController;
use App\Http\Controllers\Seller\SellerBuyerController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerTransactionController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
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
Route::resource('sellers.transactions', SellerTransactionController::class)->only('index');
Route::resource('sellers.categories', SellerCategoryController::class)->only('index');
Route::resource('sellers.buyers', SellerBuyerController::class)->only('index');
Route::resource('sellers.products', SellerProductController::class)->except('create', 'edit', 'show')->middleware('auth:api');

/*
| Buyer
*/
Route::resource('buyers', BuyerController::class)->only('index', 'show');
Route::resource('buyers.transactions', BuyerTransactionController::class)->only('index');
Route::resource('buyers.products', BuyerProductController::class)->only('index');
Route::resource('buyers.sellers', BuyerSellerController::class)->only('index');
Route::resource('buyers.categories', BuyerCategoryController::class)->only('index');

/*
| Category
*/
Route::resource('categories', CategoryController::class)->except('create', 'edit');
Route::resource('categories.products', CategoryProductController::class)->only('index');
Route::resource('categories.sellers', CategorySellerController::class)->only('index');
Route::resource('categories.transactions', CategoryTransactionController::class)->only('index');
Route::resource('categories.buyers', CategoryBuyerController::class)->only('index');

/*
| Product
*/
Route::resource('products', ProductController::class)->only('index', 'show');
Route::resource('products.transactions', ProductTransactionController::class)->only('index');
Route::resource('products.buyers', ProductBuyerController::class)->only('index');
Route::resource('products.categories', ProductCategoryController::class)->only('index', 'update', 'destroy');
Route::resource('products.buyers.transactions', ProductBuyerTransactionController::class)->only('store')->middleware('auth:api');

/*
| Transaction
*/
Route::resource('transactions', TransactionController::class)->only('index', 'show');
Route::resource('transactions.categories', TransactionCategoryController::class)->only('index');
Route::resource('transactions.sellers', TransactionSellerController::class)->only('index');

/*
| User
*/
Route::resource('users', UserController::class)->except('create', 'edit');
Route::get('users/verify/{token}', [UserController::class, 'verify'])->name('users.verify');
Route::get('users/{user}/resend', [UserController::class, 'resendEmail'])->name('users.resend');


/*
| Authentication
*/
Route::group([
    'middleware' => 'api',
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('profile', [AuthController::class, 'profile'])->name('profile');
});
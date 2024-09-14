<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreateAccount;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/login', function () {
//     return view('auth.login');
// });

// Route::get('/register', function () {
//     return view('auth.register');
// });

// Route::get('/home', function () {
//     return vie');
// });

Route::controller(AuthController::class)->group(function () {
    //register
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    //login
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    //logout
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'AdminIndex'])->name('admin.home');

    Route::get('/createAccount', [CreateAccount::class, 'creatingAccount'])->name('create.account');
    Route::post('/createAccountPost', [CreateAccount::class, 'CreateAccount'])->name('account.create.post');
    Route::get('/userlist', [UserlistController::class, 'index'])->name('userlist');
    Route::delete('/admin/userlist/{id}', [UserlistController::class, 'destroy'])->name('admin.userlist.destroy');
    Route::post('/toggle-approval/{id}', [UserlistController::class, 'toggleApproval'])->name('toggle.approval');

    // Route::resource('categories', CategoryController::class);
    // Route::resource('products', ProductController::class);
});

Route::middleware(['auth', 'user-access:petugas'])->group(function () {
    Route::get('/petugas', [HomeController::class, 'PetugasIndex'])->name('petugas.home');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/sales/add-to-cart-barcode', [SaleController::class, 'addToCartByBarcode'])->name('sales.addToCartByBarcode');


    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::post('/sales/add-to-cart/{id}', [SaleController::class, 'addToCart'])->name('sales.add-to-cart');
    Route::post('/sales/remove-from-cart/{id}', [SaleController::class, 'removeFromCart'])->name('sales.remove-from-cart');
    Route::post('/sales/checkout', [SaleController::class, 'checkout'])->name('sales.checkout');
    Route::get('/sales/history', [SaleController::class, 'history'])->name('sales.history');
    Route::get('/cart', [SaleController::class, 'showCart'])->name('sales.cart');
    Route::get('/sales/invoice/{sale}', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::post('/sales/add-to-cart-by-barcode', [SaleController::class, 'addToCartByBarcode'])->name('sales.add-to-cart-by-barcode');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/Products', [ProductController::class, 'index'])->name('products');
    Route::get('/Products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/Products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/Products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/Products/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/Products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/ProductsList', [ProductController::class, 'showProducts'])->name('products.index');
    Route::get('/productsList/{id}', [ProductController::class, 'show'])->name('products.show');

    Route::get('products/{id}/download-barcode', [ProductController::class, 'downloadBarcode'])->name('products.downloadBarcode');


});

<?php

use Illuminate\Support\Facades\Route;
// hungtmph10583 (21/09/21) start
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// hungtmph10583 (21/09/21) end
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\AccessoryController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Client\CustomerController;
use App\Http\Controllers\Client\CancelOrderController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\MailController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/ssd', function(){
//     $user = \App\Models\User::find(1);
//     dd($user->roles);
// });

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::get('/cache-permission', function () {
    Artisan::call('cache:forget spatie.permission.cache');
    return redirect(route('role.index'))->with('success', "Cập nhật Vai trò thành công");
})->name('cache-permission');

Route::get('/dump', function()
{
    Artisan::call('dump-autoload');
    return 'DONE'; //Return anything
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});


Route::get('/', [HomeController::class, 'home'])->name('client.home');
Route::get('/trang-chu', [HomeController::class, 'home']);
Route::get('search/result', [HomeController::class, 'search'])->name('client.search');

Route::prefix('san-pham')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('client.product.index');

    Route::get('/chi-tiet/{id}', [ProductController::class, 'detail'])->name('client.product.detail');
    Route::post('/chi-tiet/{id}', [ProductController::class, 'saveReview']);
});

Route::prefix('phu-kien')->group(function () {
    Route::get('/', [AccessoryController::class, 'index'])->name('client.accessory.index');

    Route::get('/chi-tiet/{id}', [AccessoryController::class, 'detail'])->name('client.accessory.detail');
    Route::post('/chi-tiet', [AccessoryController::class, 'saveReview'])->name('client.accessory.post_review');
});

Route::prefix('gio-hang')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('client.cart.index');

    Route::get('/show-cart', [CartController::class, 'showCart'])->name('showCart');
    Route::post('/save-cart', [CartController::class, 'saveCart'])->name('saveCart');

    Route::post('/buy-now', [CartController::class, 'buyNow'])->name('buyNow');

    Route::get('/delete-to-cart/{rowId}', [CartController::class, 'deleteToCart'])->name('deleteToCart');
    Route::post('/update-cart-quantity/{rowId}', [CartController::class, 'updateCartQty'])->name('updateCartQty');


    Route::post('/usDiscount', [CouponController::class, 'usDiscount'])->name('usDiscount');
    Route::post('/destroy', [CouponController::class, 'destroy'])->name('coupon.destroy');

    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('checkout', [CartController::class, 'saveCheckout']);
    
    Route::get('checkout-online', [CartController::class, 'checkoutOnline'])->name('checkoutOnline');
    Route::post('checkout-online', [CartController::class, 'saveCheckoutOnline']);
    Route::get('return', [CartController::class, 'returnUrl'])->name('returnUrl');

    // Route::get('/chi-tiet/{id}', [CartController::class, 'detail'])->name('client.cart.detail');
    // Route::post('/chi-tiet/{id}', [CartController::class, 'saveReview']);
});

Route::prefix('tai-khoan')->middleware('auth')->group(function () {
    Route::get('/', [CustomerController::class, 'accountInfo'])->name('client.customer.info');
    // Route::get('cap-nhat', [CustomerController::class, 'updateinfo'])->name('client.customer.updateinfo');
    Route::post('cap-nhat', [CustomerController::class, 'saveUpdateinfo'])->name('client.customer.updateinfo');

    Route::get('doi-mat-khau/{id}', [CustomerController::class, 'changePForm'])->name('client.customer.changeP');
    Route::post('doi-mat-khau/{id}', [CustomerController::class, 'saveChangeP']);

    Route::get('lich-su-don-hang', [CustomerController::class, 'orderHistory'])->name('client.customer.orderHistory');
    Route::get('chi-tiet-don-hang/{code}', [CustomerController::class, 'order_history_detail'])->name('client.customer.order_history_detail');
    Route::get('huy-don-hang/{id}', [CustomerController::class, 'cancel_order'])->name('cancel_order');

    Route::get('danh-gia-san-pham', [CustomerController::class, 'review'])->name('client.customer.review');
    Route::get('xoa-danh-gia/{id}', [CustomerController::class, 'deleteReview'])->name('deleteReview');

    Route::get('san-pham-yeu-thich', [CustomerController::class, 'favoriteProduct'])->name('client.customer.favoriteProduct');
});

Route::get('huy-donHang/{id}', [CancelOrderController::class, 'cancel_order_t'])->name('cancel_order_t');

Route::prefix('bai-viet')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('client.blog.index');
    Route::get('/chi-tiet/{id}', [BlogController::class, 'detail'])->name('client.blog.detail');
});

Route::prefix('lien-he')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('client.contact');
});

// ------------------------------- Login -------------------------------
Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);

//-------------------------------- Login with google--------------------
Route::group(['middleware' => 'guest'], function () {
    Route::get('/auth/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.login');
    Route::get('/facebook/auth/redirect', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('/facebook/auth/callback', [AuthController::class, 'handleFacebookCallback'])->name('auth.loginFb');
});

// ------------------------------- Register -------------------------------
Route::get('registration', [AuthController::class, 'registrationForm'])->name('registration');
Route::post('registration', [AuthController::class, 'saveRegistration']);

Route::get('register', [RegisterController::class, 'register'])->name('register'); // test
Route::post('register', [RegisterController::class, 'storeUser']); // test

//------------------------------- Logout -------------------------------
Route::any('logout', function () {
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

// ------------------------------- Forget password -------------------------------
// Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
// Route::post('forgot-password', [AuthController::class, 'saveForgotPassword']);

// ------------------------------- Change password -------------------------------
Route::get('change-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('changePassword');
Route::post('change-password', [AuthController::class, 'saveChangePassword']);

// ------------------------------- Reset password -------------------------------
// Route::post('reset-password', 'ResetPasswordController@sendMail');

Route::get('forgot-password', [ForgotPasswordController::class, 'getEmail'])->middleware('guest')->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'postEmail'])->middleware('guest');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'getPassword'])->name('resetPassword');
Route::post('reset-password', [ResetPasswordController::class, 'updatePassword']);

//Send mail
Route::get('send-mail', [SearchController::class, 'send_mail'])->name('sendMail');

Route::get('tinh-trang-don-hang/{code}', [SearchController::class, 'order_status'])->name('orderStatus');
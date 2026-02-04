<?php

use App\Http\Controllers\Api\appSettingsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\categoriesController;
use App\Http\Controllers\Api\cheefCartController;
use App\Http\Controllers\Api\cheefOutOrderController;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\faqsController;
use App\Http\Controllers\Api\HomePageSectionsController;
use App\Http\Controllers\api\Market;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\MarketOrderController;
use App\Http\Controllers\api\offersController;
use App\Http\Controllers\Api\PaymentMethodsController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\reservations;
use App\Http\Controllers\Api\slidersController;
use App\Http\Controllers\Api\storesController;
use App\Http\Controllers\Api\TermsController;
use App\Http\Controllers\Api\tipsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\vendorCategoriesController;
use App\Http\Controllers\Api\VendorsController;
use App\Http\Controllers\Api\VendorsItemsController;
use Illuminate\Support\Facades\Route;
use App\Models\customers;


Route::get('/send-to-all', function () {
    $title = "إعلان جديد 📢";
    $body = "يا شباب عندنا عرض جديد لكل مستخدمي التطبيق!";

    $result = customers::sendToAll($title, $body, ['type' => 'offer']);

    return response()->json([
        'message' => 'تمت عملية الإرسال الجماعي',
        'details' => $result
    ]);
});
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

/* Customers Register & Login and Logout */
Route::post('/customer/register', [CustomerAuthController::class, 'register']);
Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/customer/logout', [CustomerAuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/customer/show', [CustomerAuthController::class, 'show']);
Route::middleware('auth:sanctum')->put('/customer/update', [CustomerAuthController::class, 'update']);
// Route::middleware('auth:sanctum')->post('/customer/update-fcm-token', [CustomerAuthController::class, 'updateFcmToken']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::get('/market-order', [market::class, 'index']);
    Route::get('/cheef-cart/{id}', [cheefCartController::class, 'index']);
    Route::post('/cheef-cart/store', [CheefCartController::class, 'store']);
    Route::put('/cheef-cart/update/{id}', [CheefCartController::class, 'update']);
    Route::delete('/cheef-cart/{id}', [CheefCartController::class, 'destroy'])->name('cheef-cart.destroy');
    Route::post('/cheef-order', [cheefCartController::class, 'createOrder']);
    Route::post('/test-cheef', [cheefCartController::class, 'checkIfNotSameCheef']);
    // Route::get('/user-orders',[UserOrdersController::class,'index']);

    Route::get('/cheef-out-order/{vendorId}', [cheefOutOrderController::class, 'index']);
    Route::post('/cheef-out-order', [cheefOutOrderController::class, 'store']);

    Route::post('/market/store', [MarketOrderController::class, 'store']);
});

/* End Customers Register & Login and Logout */
Route::get('home-page-sections', [HomePageSectionsController::class, 'index']);
Route::get('users', [UsersController::class, 'index']);
Route::get('products', [ProductsController::class, 'index']);
Route::get('products/show/{id}', [ProductsController::class, 'show']);
Route::get('categories', [categoriesController::class, 'index']);
Route::get('sliders', [slidersController::class, 'index']);
Route::get('stores', [storesController::class, 'index']);
Route::get('settings', [appSettingsController::class, 'index']);
Route::get('vendors', [VendorsController::class, 'index']);
Route::get('tips', [tipsController::class, 'index']);
Route::get('offers', [offersController::class, 'index']);
Route::get('faq', [faqsController::class, 'index']);
Route::get('faq_all', [faqsController::class, 'showAll']);
Route::get('PaymentMethods', [PaymentMethodsController::class, 'index']);
Route::get('all_PaymentMethods', [PaymentMethodsController::class, 'show']);
Route::post('reservations', [reservations::class, 'store']);
Route::get('terms', [TermsController::class, 'index']);
Route::get('vendor/categories/{id}', [vendorCategoriesController::class, 'index']);
Route::get('vendor/items/{id}', [VendorsItemsController::class, 'index']); // search by categories
Route::get('vendor/items/show_all/{id}', [VendorsItemsController::class, 'showAll']);
Route::get('market/items', [MarketController::class, 'items']);

// Route::middleware('auth:sanctum')->post('/save-fcm-token', [FCMController::class, 'store']);

// Route::post('/send-notification', [NotificationController::class, 'sendNotification'])
// ->middleware('auth:sanctum');

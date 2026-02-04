<?php

use App\Http\Controllers\AreaController;
use App\Livewire\Admins\Profile\ProfileComponent;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\DashboardComponent;
use App\Livewire\PermissionsComponent;
use App\Livewire\Roles;
use App\Livewire\Setup\Areas\AreaComponent;
use App\Livewire\Setup\Coupons\CouponsComponent;
use App\Livewire\Setup\Market\Items\ItemComponent;
use App\Livewire\Setup\Offers\OfferProductComponent;
use App\Livewire\Setup\Offers\OffersComponent;
use App\Livewire\Setup\Orders\OrdersComponent;
use App\Livewire\Setup\Products\ProductsManagementComponent;
use App\Livewire\Setup\Products\ProductVariantsComponent;
use App\Livewire\Setup\SettingsComponent;
use App\Livewire\Setup\SupTips\SuptipsComponet;
use App\Livewire\Users\UsersComponent;
use App\Livewire\VendorSide\Items\ItemsComponent;
use App\Livewire\VendorSide\Orders\OrdersComponent as OrdersOrdersComponent;
use App\Livewire\VendorSide\Orders\OrdersShow;
use App\Livewire\VendorSide\Sections\SectionsComponent;
use App\Livewire\VendorSide\Status\StatusComponent;
use App\Livewire\VendorSide\VendorsDashboardComponent;
use App\Models\areas;
use App\Models\customers;
use GPBMetadata\Google\Rpc\Status;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/storage-unlink', function () {
    Artisan::call('storage:unlink');
});
Route::get('/storage-link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});

// Route::get('/firebase-messaging-sw.js', function() {
//     return response()->file(public_path('firebase-messaging-sw.js'), [
//         'Content-Type' => 'application/javascript'
//     ]);
// });

Route::get('/firebase-messaging-sw.js', function () {
    return response()->file(public_path('firebase-messaging-sw.js'));
});

Route::get('/send-to-all', function () {
    $title = "إعلان جديد 📢";
    $body = "يا شباب عندنا عرض جديد لكل مستخدمي التطبيق!";

    $result = customers::sendToAll($title, $body, ['type' => 'offer']);

    return response()->json([
        'message' => 'تمت عملية الإرسال الجماعي',
        'details' => $result
    ]);
});

Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::middleware('guest')->group(function () {
            Route::get('/register', Register::class)->name('register');
            Route::get('/login', Login::class)->name('login');
        }); //Auth::routes();

        Route::middleware(['auth:web'])->group(function () {

            Route::get('/', DashboardComponent::class)->name('dashboard');
            Route::get('/settings', SettingsComponent::class)->name('settings');
            Route::get('/roles', Roles::class)->name('roles');
            Route::get('/permissions', PermissionsComponent::class)->name('permissions');
            Route::get('/users', UsersComponent::class)->name('users');
            Route::get('/profile', ProfileComponent::class)->name('admins.profile');

            // Route::get('/products', ProductsManagementComponent::class)->name('products');
            // Route::get('/products/{productId}/variants', ProductVariantsComponent::class)->name('product.variants');
            // Route::get('/products/{productId}/info', ProductVariantsComponent::class)->name('product.info');

            Route::get('/products', ItemComponent::class)->name('products');
            Route::get('/offers', OffersComponent::class)->name('offers');
            Route::get('/offers/{offerId}/products', OfferProductComponent::class)->name('offers.products');

            Route::get('/coupons', CouponsComponent::class)->name('coupons');

            Route::get('/areas', AreaComponent::class)->name('areas');
            Route::get('/oders', OrdersComponent::class)->name('admin.orders');

            Route::get('/areas/{area}', function (areas $area) {
                return response()->json([
                    'id'          => $area->id,
                    'name'        => $area->name,
                    'coordinates' => $area->coordinates,
                ]);
            });

            Route::get('/areas/search/{name}', function ($name) {
                return areas::where('name', 'like', "%$name%")->first();
            });

            Route::get('/debug-areas', function () {
                return areas::all();
            });
            Route::get('/map', [AreaController::class, 'index'])->name('map.index');
            Route::post('/map', [AreaController::class, 'store'])->name('map.store');
            Route::get('/tips/{mainTipId}/sup-tips', SuptipsComponet::class)->name('sup-tips');
            //logout
            Route::get('/logout', function () {
                Auth::logout();
                return redirect()->route('login');
            })->name('logout');
        });

        Route::middleware(['auth:vendor'])->group(function () {
            Route::get('/vendors/dashboard', VendorsDashboardComponent::class)->name('vendors.dashboard');
            Route::get('/vendors/section', SectionsComponent::class)->name('vendors.section');
            Route::get('/vendors/items', ItemsComponent::class)->name('vendors.items');
            Route::get('/vendors/orders', OrdersOrdersComponent::class)->name('vendors.orders');
            Route::get('/vendors/orders/{orderId}', OrdersShow::class)->name('vendors.orders.show');
            Route::get('/vendors/status', StatusComponent::class)->name('vendors.status');
        });

        //Livewre update route
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/custom/livewire/update', $handle);
        });
    }
);

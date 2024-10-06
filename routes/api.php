<?php

use App\Http\Controllers\admin\AreaController as AdminAreaController;
use App\Http\Controllers\admin\CardTableController as AdminCardTableController;
use App\Http\Controllers\admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ComboController;
use App\Http\Controllers\admin\DeviceController;
use App\Http\Controllers\admin\OptionController as AdminOptionController;
use App\Http\Controllers\admin\PaymenMethodController;
use App\Http\Controllers\admin\PrinterController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\admin\PromotionController;
use App\Http\Controllers\admin\ProvinceController;
use App\Http\Controllers\admin\ShopController;
use App\Http\Controllers\admin\SourceController;
use App\Http\Controllers\Admin\Storage\CommodityGroupController;
use App\Http\Controllers\admin\Storage\MerchandiseController;
use App\Http\Controllers\admin\Storage\UnitController;
use App\Http\Controllers\admin\TableController as AdminTableController;
use App\Http\Controllers\admin\TemplateController;
use App\Http\Controllers\admin\ToppingController as AdminToppingController;
use App\Http\Controllers\admin\UnitTypeController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\pos\AuthController as PosAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CardTableController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\pos\CategoryController;
use App\Http\Controllers\pos\CustomerController;
use App\Http\Controllers\pos\DashboardController;
use App\Http\Controllers\pos\HomeController;
use App\Http\Controllers\pos\OrderBeforController;
use App\Http\Controllers\pos\OrderController;
use App\Http\Controllers\pos\ShipperController;
use App\Http\Controllers\pos\UsageTypeController;
use App\Http\Controllers\pos\ShopController as PosShopController;
use App\Http\Controllers\pos\ComboController as PosComboController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ToppingController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    // Route::group(['prefix' => 'auth'], function () {
    Route::post('/find-user', [AuthController::class, 'findUser'])->name('auth.findUser');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/detail', [AuthController::class, 'detail'])->name('auth.detail');
    // });

    Route::group(['prefix' => 'admin'], function () {
        // shop
        Route::group([], function () {
            Route::group(['prefix' => 'shop'], function () {
                Route::get('/', [ShopController::class, 'index'])->name('admin.shop.index');
                Route::post('/', [ShopController::class, 'store'])->name('admin.shop.store');
                Route::get('/detail/{id}', [ShopController::class, 'show'])->name('admin.shop.show');
                Route::put('/{id}', [ShopController::class, 'update'])->name('admin.shop.update');
                Route::patch('/status/{id}', [ShopController::class, 'updateStatus'])->name('admin.shop.updateStatus');
                Route::delete('/vouchers', [ShopController::class, 'destroyVoucher'])->name('admin.shop.destroyVoucher');
            });
            Route::get('/list-shop', [ShopController::class, 'listShop'])->name('admin.listShop');

            // category
            Route::group(['prefix' => 'category'], function () {
                Route::get('/default', [AdminCategoryController::class, 'categoryDefault'])->name('admin.category.categoryDefault');
                Route::middleware('auth')->get('', [AdminCategoryController::class, 'index'])->name('admin.category.index');
                Route::middleware('auth')->get('/active', [AdminCategoryController::class, 'indexActive'])->name('admin.category.indexActive');
                Route::get('/generate-code', [AdminCategoryController::class, 'generateCode'])->name('admin.category.generateCode');
                Route::middleware(['role:Admin'])->post('', [AdminCategoryController::class, 'store'])->name('admin.category.create');
                Route::middleware(['role:Admin'])->put('/{id}', [AdminCategoryController::class, 'update'])->name('admin.category.update');
                Route::middleware(['role:Admin'])->patch('/{id}', [AdminCategoryController::class, 'updateStatus'])->name('admin.category.updateStatus');
                Route::middleware(['role:Admin'])->delete('/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.category.destroy');
            });

            // product
            Route::group(['prefix' => 'product'], function () {
                Route::get('/dropdown', [ProductController::class, 'dropdown'])->name('admin.product.dropdown');

                Route::get('/default', [ProductController::class, 'productDefault'])->name('admin.category.productDefault');
                Route::middleware('auth')->get('', [ProductController::class, 'index'])->name('admin.category.index');
                Route::middleware('auth')->get('/active', [ProductController::class, 'listProducts'])->name('admin.category.listProducts');
                Route::get('/generate-code', [ProductController::class, 'generateCode'])->name('admin.category.generateCode');
                Route::get('/generate-code/combo', [ProductController::class, 'generateCodeCombo'])->name('admin.category.generateCodeCombo');
                Route::middleware(['role:Admin'])->post('', [ProductController::class, 'store'])->name('admin.category.create');
                Route::middleware(['role:Admin'])->post('/topping', [ProductController::class, 'createTopping'])->name('admin.category.createTopping');
                Route::middleware(['role:Admin'])->post('/combo', [ProductController::class, 'storeCombo'])->name('admin.category.createCombo');
                Route::middleware(['role:Admin'])->put('/{id}', [ProductController::class, 'update'])->name('admin.category.update');
                Route::middleware(['role:Admin'])->get('/detail/{id}', [ProductController::class, 'show'])->name('admin.category.show');
                Route::middleware(['role:Admin'])->patch('/{id}', [ProductController::class, 'updateStatus'])->name('admin.category.updateStatus');
                Route::middleware(['role:Admin'])->delete('/{id}', [ProductController::class, 'destroy'])->name('admin.category.destroy');
            });

            // combo
            Route::middleware(['role:Admin'])->prefix('combo')->group(function () {
                Route::get('', [ComboController::class, 'index'])->name('admin.combo.index');
                Route::get('/generate-code', [ComboController::class, 'generateCode'])->name('admin.combo.generateCode');
                Route::post('', [ComboController::class, 'store'])->name('admin.combo.store');
                Route::put('/{id}', [ComboController::class, 'update'])->name('admin.combo.update');
                Route::patch('/{id}', [ComboController::class, 'updateStatus'])->name('admin.combo.updateStatus');
            });

            // payment method
            Route::middleware(['role:Admin'])->prefix('payment-method')->group(function () {
                Route::get('', [PaymenMethodController::class, 'index'])->name('admin.payment-method.index');
                Route::get('/generate-code', [PaymenMethodController::class, 'generateCode'])->name('admin.payment-method.generateCode');
                Route::post('', [PaymenMethodController::class, 'store'])->name('admin.payment-method.store');
                Route::put('/{id}', [PaymenMethodController::class, 'update'])->name('admin.payment-method.update');
                Route::patch('/{id}', [PaymenMethodController::class, 'updateStatus'])->name('admin.payment-method.updateStatus');
            });

            //Option
            Route::middleware(['role:Admin'])->prefix('option')->group(function () {
                Route::get('', [AdminOptionController::class, 'getList'])->name('admin.option.getList');
                Route::get('/all', [AdminOptionController::class, 'getListAll'])->name('admin.option.getListAll');
                Route::post('', [AdminOptionController::class, 'create'])->name('admin.option.create');
                Route::put('/{id}', [AdminOptionController::class, 'updateOption'])->name('admin.option.updateOption');
                Route::patch('/{id}', [AdminOptionController::class, 'updateStatusOption'])->name('admin.option.updateStatusOption');
                Route::delete('/{id}',  [AdminOptionController::class, 'destroy'])->name('admin.option.destroy');
                Route::delete('/option-value/{id}',  [AdminOptionController::class, 'destroyOptionValue'])->name('admin.option.destroyOptionValue');
            });

            //Topping
            Route::middleware(['role:Admin'])->prefix('topping')->group(function () {
                Route::get('', [AdminToppingController::class, 'index'])->name('admin.topping.index');
                Route::get('/attributes', [AdminToppingController::class, 'listTopping'])->name('admin.topping.listTopping');
                Route::post('', [AdminToppingController::class, 'store'])->name('admin.topping.store');
                Route::put('/{id}', [AdminToppingController::class, 'update'])->name('admin.topping.update');
                Route::patch('/{id}', [AdminToppingController::class, 'updateStatus'])->name('admin.topping.updateStatus');
            });

            //Area
            Route::middleware(['role:Admin'])->prefix('area')->group(function () {
                Route::get('', [AdminAreaController::class, 'index'])->name('admin.area.index');
                Route::get('/detail/{id}', [AdminAreaController::class, 'detail'])->name('admin.area.detail');
                Route::get('active', [AdminAreaController::class, 'listArea'])->name('admin.area.listArea');
                Route::post('', [AdminAreaController::class, 'store'])->name('admin.area.store');
                Route::put('/{id}', [AdminAreaController::class, 'update'])->name('admin.area.update');
                Route::patch('/{id}', [AdminAreaController::class, 'updateStatusArea'])->name('admin.area.updateStatusArea');
                Route::delete('/{id}',  [AdminAreaController::class, 'destroy'])->name('admin.area.destroy');
                Route::delete('/area-value/{id}',  [AdminAreaController::class, 'destroyareaValue'])->name('admin.area.destroyareaValue');
            });

            //Table
            Route::middleware(['role:Admin'])->prefix('table')->group(function () {
                Route::get('', [AdminTableController::class, 'index'])->name('admin.table.index');
                Route::post('', [AdminTableController::class, 'store'])->name('admin.table.store');
                Route::put('/{id}', [AdminTableController::class, 'update'])->name('admin.table.update');
                Route::patch('/{id}', [AdminTableController::class, 'updateStatusTable'])->name('admin.table.updateStatusTable');
            });

            //Device
            Route::middleware(['role:Admin'])->prefix('device')->group(function () {
                Route::get('', [DeviceController::class, 'index'])->name('admin.device.index');
                Route::get('/detail/{id}', [DeviceController::class, 'detail'])->name('admin.device.detail');
                Route::post('', [DeviceController::class, 'store'])->name('admin.device.store');
                Route::put('/{id}', [DeviceController::class, 'update'])->name('admin.device.update');
                Route::patch('/{id}', [DeviceController::class, 'updateStatusDevice'])->name('admin.device.updateStatusDevice');
            });

            //Printer
            Route::middleware(['role:Admin'])->prefix('printer')->group(function () {
                Route::get('', [PrinterController::class, 'index'])->name('admin.printer.index');
                Route::post('', [PrinterController::class, 'store'])->name('admin.printer.store');
                Route::put('/{id}', [PrinterController::class, 'update'])->name('admin.printer.update');
                Route::delete('/{id}', [PrinterController::class, 'destroy'])->name('admin.printer.destroy');
            });

            //Card table
            Route::middleware(['role:Admin'])->prefix('card-table')->group(function () {
                Route::get('', [AdminCardTableController::class, 'index'])->name('admin.card.table.index');
                Route::post('', [AdminCardTableController::class, 'store'])->name('admin.card.table.store');
                Route::put('/shop/{id}', [AdminCardTableController::class, 'update'])->name('admin.card.table.update');
                Route::delete('/{id}', [AdminCardTableController::class, 'deleteCardTable'])->name('admin.card.table.deleteCardTable');
            });

            // source
            Route::middleware(['role:Admin'])->prefix('source')->group(function () {
                Route::get('', [SourceController::class, 'listSource'])->name('admin.source.listSource');
                Route::get('/all', [SourceController::class, 'index'])->name('admin.source.index');
                Route::post('', [SourceController::class, 'store'])->name('admin.source.store');
                Route::put('/{id}', [SourceController::class, 'update'])->name('admin.source.update');
                Route::patch('/{id}', [SourceController::class, 'updateStatus'])->name('admin.source.updateStatus');
            });

            // province
            Route::prefix('province')->group(function () {
                Route::get('', [ProvinceController::class, 'index'])->name('admin.province.index');
            });

            // promotion
            Route::middleware(['role:Admin'])->prefix('promotion')->group(function () {
                Route::get('', [PromotionController::class, 'index'])->name('admin.promotion.index');
                Route::post('', [PromotionController::class, 'store'])->name('admin.promotion.store');
                Route::put('/{id}', [PromotionController::class, 'update'])->name('admin.promotion.update');
                Route::patch('/{id}', [PromotionController::class, 'updateStatus'])->name('admin.promotion.updateStatus');
            });

            // template
            Route::middleware(['role:Admin'])->prefix('template')->group(function () {
                Route::get('', [TemplateController::class, 'index'])->name('admin.template.index');
                Route::put('/update', [TemplateController::class, 'update'])->name('admin.template.update');
            });

            // unit type
            Route::middleware(['role:Admin'])->prefix('unit-type')->group(function () {
                Route::middleware('auth')->get('', [UnitTypeController::class, 'index'])->name('admin.unit-type.index');
            });
        });


        // storage
        Route::group(['prefix' => 'storage'], function () {
            Route::group(['prefix' => 'shop'], function () {
                Route::get('/', [ShopController::class, 'storage'])->name('admin.shop.storage');
            });

            Route::group(['prefix' => 'commodity-group'], function () {
                Route::get('/', [CommodityGroupController::class, 'index'])->name('admin.storage.commodity-group.index');
                Route::post('/', [CommodityGroupController::class, 'store'])->name('admin.storage.commodity-group.store');
                Route::put('/{id}', [CommodityGroupController::class, 'update'])->name('admin.storage.commodity-group.update');
                Route::patch('/{id}', [CommodityGroupController::class, 'updateStatus'])->name('admin.storage.commodity-group.updateStatus');
                Route::get('/generate-code', [CommodityGroupController::class, 'generateCode'])->name('admin.storage.commodity-group.generateCode');
            });

            Route::group(['prefix' => 'unit'], function () {
                Route::get('/', [UnitController::class, 'index'])->name('admin.storage.unit.index');
                Route::post('/', [UnitController::class, 'store'])->name('admin.storage.unit.store');
                Route::put('/{id}', [UnitController::class, 'update'])->name('admin.storage.unit.update');
                Route::patch('/{id}', [UnitController::class, 'updateStatus'])->name('admin.storage.unit.updateStatus');
                Route::get('/generate-code', [UnitController::class, 'generateCode'])->name('admin.storage.unit.generateCode');
            });

            Route::group(['prefix' => 'merchandise'], function () {
                Route::get('/', [MerchandiseController::class, 'index'])->name('admin.storage.merchandise.index');
                Route::post('/', [MerchandiseController::class, 'store'])->name('admin.storage.merchandise.store');
                Route::put('/{id}', [MerchandiseController::class, 'update'])->name('admin.storage.merchandise.update');
                Route::patch('/{id}', [MerchandiseController::class, 'updateStatus'])->name('admin.storage.merchandise.updateStatus');
                Route::delete('/{id}', [MerchandiseController::class, 'destroy'])->name('admin.storage.merchandise.destroy');
            });

            Route::group(['prefix' => 'cost'], function () {
                Route::get('/', [AdminProductController::class, 'getCost'])->name('admin.storage.merchandise.getCost');
                Route::post('/', [AdminProductController::class, 'createCost'])->name('admin.storage.merchandise.createCost');
                Route::put('/{id}', [AdminProductController::class, 'updateCost'])->name('admin.storage.merchandise.updateCost');
                Route::delete('/{id}', [AdminProductController::class, 'destroyCost'])->name('admin.storage.merchandise.destroyCost');
            });
        });
    });
});

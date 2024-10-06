<?php

namespace App\Providers;

use App\Repositories\Admin\Area\AreaRepository as AreaAreaRepository;
use App\Repositories\Admin\Area\AreaRepositoryEloquent as AreaAreaRepositoryEloquent;
use App\Repositories\Admin\CardTable\CardTableRepository;
use App\Repositories\Admin\CardTable\CardTableRepositoryEloquent;
use App\Repositories\Admin\Category\CategoryRepository;
use App\Repositories\Admin\Category\CategoryRepositoryEloquent;
use App\Repositories\Admin\Combo\ComboRepository;
use App\Repositories\Admin\Combo\ComboRepositoryEloquent;
use App\Repositories\Admin\CommodityGroup\CommodityGroupRepository;
use App\Repositories\Admin\CommodityGroup\CommodityGroupRepositoryEloquent;
use App\Repositories\Admin\Device\DeviceRepository;
use App\Repositories\Admin\Device\DeviceRepositoryEloquent;
use App\Repositories\Admin\Merchandise\MerchandiseRepository;
use App\Repositories\Admin\Merchandise\MerchandiseRepositoryEloquent;
use App\Repositories\Admin\Option\OptionRepository;
use App\Repositories\Admin\Option\OptionRepositoryEloquent;
use App\Repositories\Admin\Printer\PrinterRepository;
use App\Repositories\Admin\Printer\PrinterRepositoryEloquent;
use App\Repositories\Admin\Product\ProductRepository;
use App\Repositories\Admin\Product\ProductRepositoryEloquent;
use App\Repositories\Admin\Promotion\PromotionRepository;
use App\Repositories\Admin\Promotion\PromotionRepositoryEloquent;
use App\Repositories\Admin\Shop\ShopRepository;
use App\Repositories\Admin\Shop\ShopRepositoryEloquent;
use App\Repositories\Admin\Source\SourceRepository;
use App\Repositories\Admin\Source\SourceRepositoryEloquent;
use App\Repositories\Admin\SourceValue\SourceValueRepository;
use App\Repositories\Admin\SourceValue\SourceValueRepositoryEloquent;
use App\Repositories\Admin\Table\TableRepository;
use App\Repositories\Admin\Table\TableRepositoryEloquent;
use App\Repositories\Admin\Template\TemplateRepository;
use App\Repositories\Admin\Template\TemplateRepositoryEloquent;
use App\Repositories\Admin\Topping\ToppingRepository;
use App\Repositories\Admin\Topping\ToppingRepositoryEloquent;
use App\Repositories\Admin\ToppingAttr\ToppingAttrRepository;
use App\Repositories\Admin\ToppingAttr\ToppingAttrRepositoryEloquent;
use App\Repositories\Admin\Unit\UnitRepository;
use App\Repositories\Admin\Unit\UnitRepositoryEloquent;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\Pos\Area\AreaRepository;
use App\Repositories\Pos\Area\AreaRepositoryEloquent;
use App\Repositories\Pos\Combo\ComboRepository as PosComboRepository;
use App\Repositories\Pos\Combo\ComboRepositoryEloquent as PosComboRepositoryEloquent;
use App\Repositories\Pos\Dashboard\DashboardRepository;
use App\Repositories\Pos\Dashboard\DashboardRepositoryEloquent;
use App\Repositories\Pos\Home\HomeRepository;
use App\Repositories\Pos\Home\HomeRepositoryEloquent;
use App\Repositories\Pos\Order\OrderRepository;
use App\Repositories\Pos\Order\OrderRepositoryEloquent;
use App\Repositories\Pos\OrderBefor\OrderBeforRepository;
use App\Repositories\Pos\OrderBefor\OrderBeforRepositoryEloquent;
use App\Repositories\User\UserRepository as UserUserRepository;
use App\Repositories\User\UserRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Services\Admin\Area\AreaService as AreaAreaService;
use App\Services\Admin\Area\AreaServiceImp as AreaAreaServiceImp;
use App\Services\Admin\CardTable\CardTableService;
use App\Services\Admin\CardTable\CardTableServiceImp;
use App\Services\Admin\Category\CategoryService;
use App\Services\Admin\Category\CategoryServiceImp;
use App\Services\Admin\Combo\ComboService;
use App\Services\Admin\Combo\ComboServiceImp;
use App\Services\Admin\CommodityGroup\CommodityGroupService;
use App\Services\Admin\CommodityGroup\CommodityGroupServiceImp;
use App\Services\Admin\Device\DeviceService;
use App\Services\Admin\Device\DeviceServiceImp;
use App\Services\Admin\Merchandise\MerchandiseService;
use App\Services\Admin\Merchandise\MerchandiseServiceImp;
use App\Services\Admin\Option\OptionService;
use App\Services\Admin\Option\OptionServiceImp;
use App\Services\Admin\Printer\PrinterService;
use App\Services\Admin\Printer\PrinterServiceImp;
use App\Services\Admin\Product\ProductService;
use App\Services\Admin\Product\ProductServiceImp;
use App\Services\Admin\Promotion\PromotionService;
use App\Services\Admin\Promotion\PromotionServiceImp;
use App\Services\Admin\Shop\ShopService;
use App\Services\Admin\Shop\ShopServiceImp;
use App\Services\Admin\Source\SourceService;
use App\Services\Admin\Source\SourceServiceImp;
use App\Services\Admin\Table\TableService;
use App\Services\Admin\Table\TableServiceImp;
use App\Services\Admin\Template\TemplateService;
use App\Services\Admin\Template\TemplateServiceImp;
use App\Services\Admin\Topping\ToppingService;
use App\Services\Admin\Topping\ToppingServiceImp;
use App\Services\Admin\Unit\UnitService;
use App\Services\Admin\Unit\UnitServiceImp;
use App\Services\Pos\Area\AreaService;
use App\Services\Pos\Area\AreaServiceImp;
use App\Services\Pos\Combo\ComboService as PosComboService;
use App\Services\Pos\Combo\ComboServiceImp as PosComboServiceImp;
use App\Services\Pos\Dashboard\DashboardService;
use App\Services\Pos\Dashboard\DashboardServiceImp;
use App\Services\Pos\Home\HomeService;
use App\Services\Pos\Home\HomeServiceImp;
use App\Services\Pos\OrderBefor\OrderBeforService;
use App\Services\Pos\OrderBefor\OrderBeforServiceImp;
use App\Services\Pos\Order\OrderService;
use App\Services\Pos\Order\OrderServiceImp;
use App\Services\User\UserService;
use App\Services\User\UserServiceImp;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // service
        $this->app->bind(UserService::class, UserServiceImp::class);
        $this->app->bind(HomeService::class, HomeServiceImp::class);
        $this->app->bind(OrderService::class, OrderServiceImp::class);
        $this->app->bind(AreaService::class, AreaServiceImp::class);
        $this->app->bind(OrderBeforService::class, OrderBeforServiceImp::class);
        $this->app->bind(DashboardService::class, DashboardServiceImp::class);
        $this->app->bind(PosComboService::class, PosComboServiceImp::class);

        // service Admin
        $this->app->bind(ShopService::class, ShopServiceImp::class);
        $this->app->bind(CategoryService::class, CategoryServiceImp::class);
        $this->app->bind(ProductService::class, ProductServiceImp::class);
        $this->app->bind(SourceService::class, SourceServiceImp::class);
        $this->app->bind(OptionService::class, OptionServiceImp::class);
        $this->app->bind(AreaAreaService::class, AreaAreaServiceImp::class);
        $this->app->bind(TableService::class, TableServiceImp::class);
        $this->app->bind(CardTableService::class, CardTableServiceImp::class);
        $this->app->bind(DeviceService::class, DeviceServiceImp::class);
        $this->app->bind(PrinterService::class, PrinterServiceImp::class);
        $this->app->bind(ToppingService::class, ToppingServiceImp::class);
        $this->app->bind(PromotionService::class, PromotionServiceImp::class);
        $this->app->bind(ComboService::class, ComboServiceImp::class);
        $this->app->bind(TemplateService::class, TemplateServiceImp::class);
        $this->app->bind(CommodityGroupService::class, CommodityGroupServiceImp::class);
        $this->app->bind(UnitService::class, UnitServiceImp::class);
        $this->app->bind(MerchandiseService::class, MerchandiseServiceImp::class);

        // repository
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserUserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(HomeRepository::class, HomeRepositoryEloquent::class);
        $this->app->bind(OrderRepository::class, OrderRepositoryEloquent::class);
        $this->app->bind(AreaRepository::class, AreaRepositoryEloquent::class);
        $this->app->bind(OrderBeforRepository::class, OrderBeforRepositoryEloquent::class);
        $this->app->bind(DashboardRepository::class, DashboardRepositoryEloquent::class);
        $this->app->bind(PosComboRepository::class, PosComboRepositoryEloquent::class);

        // repository Admin
        $this->app->bind(ShopRepository::class, ShopRepositoryEloquent::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryEloquent::class);
        $this->app->bind(SourceRepository::class, SourceRepositoryEloquent::class);
        $this->app->bind(OptionRepository::class, OptionRepositoryEloquent::class);
        $this->app->bind(AreaAreaRepository::class, AreaAreaRepositoryEloquent::class);
        $this->app->bind(TableRepository::class, TableRepositoryEloquent::class);
        $this->app->bind(CardTableRepository::class, CardTableRepositoryEloquent::class);
        $this->app->bind(DeviceRepository::class, DeviceRepositoryEloquent::class);
        $this->app->bind(PrinterRepository::class, PrinterRepositoryEloquent::class);
        $this->app->bind(ToppingRepository::class, ToppingRepositoryEloquent::class);
        $this->app->bind(ToppingAttrRepository::class, ToppingAttrRepositoryEloquent::class);
        $this->app->bind(SourceValueRepository::class, SourceValueRepositoryEloquent::class);
        $this->app->bind(PromotionRepository::class, PromotionRepositoryEloquent::class);
        $this->app->bind(ComboRepository::class, ComboRepositoryEloquent::class);
        $this->app->bind(TemplateRepository::class, TemplateRepositoryEloquent::class);
        $this->app->bind(CommodityGroupRepository::class, CommodityGroupRepositoryEloquent::class);
        $this->app->bind(UnitRepository::class, UnitRepositoryEloquent::class);
        $this->app->bind(MerchandiseRepository::class, MerchandiseRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}

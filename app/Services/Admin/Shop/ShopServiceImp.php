<?php

namespace App\Services\Admin\Shop;

use App\Helpers\Common;
use App\Models\Admin\Voucher;
use App\Repositories\Admin\Shop\ShopRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShopServiceImp extends BaseServiceImp implements ShopService
{
    public function __construct(ShopRepository $shopRepository)
    {
        $this->repository = $shopRepository;
    }

    public function getShop(int $id): mixed
    {
        try {
            $shop = $this->repository->find($id);
            return $shop;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getAllShops(): mixed
    {
        try {
            $shops = $this->repository->getAllShops();
            return $shops;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function createShop(array $params): mixed
    {
        try {
            DB::beginTransaction();
            $logo = isset($params['logo']) ?  Common::uploadbase64Image($params['logo'], 'Shop/logo/') : null;
            $background = isset($params['background']) ?  Common::uploadbase64Image($params['background'], 'Shop/background/') : null;

            $data = [
                'company_id' => auth()->user()->company_id,
                'logo' => $logo,
                'background' => $background,
                'name' =>  $params['name'],
                'adress' =>  $params['address'],
                'phone' => $params['phone'],
                'email' => $params['email'],
                'province_id' => $params['province_id'],
                'license_expiry' => $params['license_expiry'] ?? null,
                'description' => $params['description'] ?? null,
                'bank_name' => $params['bank_name'] ?? null,
                'bank_account_number' => $params['bank_account_number'] ?? null,
                'bank_account_holder' => $params['bank_account_holder'] ?? null,
                'qr_code_status' => $params['qr_code_status'] ?? null,
                'bill_payment_approval_required' => $params['bill_payment_approval_required'] ?? null,
                'sales_report_approval_required' => $params['sales_report_approval_required'] ?? null,
                'custom_item_creation_approval_required' => $params['custom_item_creation_approval_required'] ?? null,
                'service_fee_approval_required' => $params['service_fee_approval_required'] ?? null,
                'order_discount_approval_required' => $params['order_discount_approval_required'] ?? null,
                'order_cancel_approval_required' => $params['order_cancel_approval_required'] ?? null,
                'order_history_approval_required' => $params['order_history_approval_required'] ?? null,
                'table_transfer_approval_required' => $params['table_transfer_approval_required'] ?? null,
                'pin_code' => $params['pin_code'] ?? null,
                'pin_code_length' => $params['pin_code_length'] ?? null,
                'auto_change_pin' => $params['auto_change_pin'] ?? null,
                'pos_alert_time' => $params['pos_alert_time'] ?? null,
                'opening_time' => $params['opening_time'] ?? null,
                'closing_time' => $params['closing_time'] ?? null,
                'user_id' => auth()->user()->id
            ];

            $shop = parent::create($data);

            if (isset($params['vouchers'])) {
                foreach ($params['vouchers'] as $voucher) {
                    $voucher['company_id'] = auth()->user()->company_id;
                    $voucher['shop_id'] = $shop->id;

                    Voucher::create($voucher);
                }
            }

            DB::commit();
            return $shop;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateShop(int $id, array $params): mixed
    {
        try {
            DB::beginTransaction();
            $shop = $this->repository->find($id);

            if (!$shop) {
                return false;
            }

            $oldLogoPath = $shop->logo;
            $oldBackgroundPath = $shop->background;

            $logo = null; // Đặt giá trị mặc định là null
            $background = null; // Đặt giá trị mặc định là null
            if (array_key_exists('logo', $params)) {
                $logo = Common::updateProductImage($params['logo'], $oldLogoPath, 'Shop/logo/');
            }
            if (array_key_exists('background', $params)) {
                $background = Common::updateProductImage($params['background'], $oldBackgroundPath, 'Shop/background/');
            }

            $data = [
                'name' =>  $params['name'],
                'adress' =>  $params['address'],
                'phone' => $params['phone'] ?? $shop->phone,
                'email' => $params['email'] ?? $shop->email,
                'province_id' => $params['province_id'] ?? $shop->province_id,
                'license_expiry' => $params['license_expiry'] ?? $shop->license_expiry,
                'description' => $params['description'] ?? $shop->description,
                'bank_name' => $params['bank_name'] ?? $shop->bank_name,
                'bank_account_number' => $params['bank_account_number'] ?? $shop->bank_account_number,
                'bank_account_holder' => $params['bank_account_holder'] ?? $shop->bank_account_holder,
                'qr_code_status' => $params['qr_code_status'] ?? $shop->qr_code_status,
                'bill_payment_approval_required' => $params['bill_payment_approval_required'] ?? $shop->bill_payment_approval_required,
                'sales_report_approval_required' => $params['sales_report_approval_required'] ?? $shop->sales_report_approval_required,
                'custom_item_creation_approval_required' => $params['custom_item_creation_approval_required'] ?? $shop->custom_item_creation_approval_required,
                'service_fee_approval_required' => $params['service_fee_approval_required'] ?? $shop->service_fee_approval_required,
                'order_discount_approval_required' => $params['order_discount_approval_required'] ?? $shop->order_discount_approval_required,
                'order_cancel_approval_required' => $params['order_cancel_approval_required'] ?? $shop->order_cancel_approval_required,
                'order_history_approval_required' => $params['order_history_approval_required'] ?? $shop->order_history_approval_required,
                'table_transfer_approval_required' => $params['table_transfer_approval_required'] ?? $shop->table_transfer_approval_required,
                'pin_code' => $params['pin_code'] ?? $shop->pin_code,
                'pin_code_length' => $params['pin_code_length'] ?? $shop->pin_code_length,
                'auto_change_pin' => $params['auto_change_pin'] ?? $shop->auto_change_pin,
                'pos_alert_time' => $params['pos_alert_time'] ?? $shop->pos_alert_time,
                'opening_time' => $params['opening_time'] ?? $shop->opening_time,
                'closing_time' => $params['closing_time'] ?? $shop->closing_time,
            ];

            if (!is_null($logo)) {
                $data['logo'] = $logo;
            } elseif (array_key_exists('logo', $params) && is_null($params['logo'])) {
                $data['logo'] = null; // Xóa ảnh nếu không có ảnh mới và 'image' trong params là null
            }

            if (!is_null($background)) {
                $data['background'] = $background;
            } elseif (array_key_exists('background', $params) && is_null($params['background'])) {
                $data['background'] = null; // Xóa ảnh nếu không có ảnh mới và 'image' trong params là null
            }

            $shop = parent::update($id, $data);

            if (isset($params['vouchers'])) {
                foreach ($params['vouchers'] as $voucher) {
                    if (isset($voucher['id'])) {
                        $voucherOld = Voucher::find($voucher['id']);
                        if ($voucherOld) {
                            $voucherOld->update($voucher);
                        } else {
                            return false;
                        }
                    } else {
                        $voucher['company_id'] = auth()->user()->company_id;
                        $voucher['shop_id'] = $shop->id;
                        Voucher::create($voucher);
                    }
                }
            }

            DB::commit();
            return $shop;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusShop(int $id, bool $status): mixed
    {
        try {
            $shop = $this->repository->find($id);

            if (!$shop) {
                return false;
            }

            $data = [
                'status' => $status == true ? 'active' : 'no_active',
            ];

            $shop = parent::update($id, $data);

            return $shop;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getShops(array $attributes, ?int $page, ?int $limit): mixed
    {
        try {
            $shops = $this->repository->getShops($attributes, $page, $limit);
            return $shops;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getShopsByCompany(): mixed
    {
        try {
            $shops = $this->repository->getShopsByCompany();
            return $shops;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getStorageByCompany(?array $filter): mixed
    {
        try {
            $shops =  $this->repository->getStorageByCompany($filter);
            return $shops;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getCardTables(array $attributes, ?int $page, ?int $limit): mixed
    {
        try {
            $shops = $this->repository->getCardTables($attributes, $page, $limit);
            return $shops;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}

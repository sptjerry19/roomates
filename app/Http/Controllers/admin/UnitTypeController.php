<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Admin\UnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $companyId = auth()->user()->company_id;
            $unitType = UnitType::query()->where('company_id', $companyId)->get();
            return ApiResponse::success($unitType, __('message.success.unit_type_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.unit_type_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

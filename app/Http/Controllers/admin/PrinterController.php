<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Printer\StoreRequest;
use App\Services\Admin\Printer\PrinterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrinterController extends Controller
{
    protected $printerService;
    public function __construct(PrinterService $printerService)
    {
        $this->printerService = $printerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $params = $request->validated();

            $option = $this->printerService->createPrinter($params);

            return ApiResponse::success($option, __('message.success.printer.created_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.printer.created_fail', 500);
        }
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
    public function update(StoreRequest $request, string $id)
    {
        try {
            $params = $request->validated();

            $option = $this->printerService->updatePrinter($id, $params);

            return ApiResponse::success($option, __('message.success.printer.updated_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.printer.updated_fail', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $option = $this->printerService->destroyPrinter($id);

            return ApiResponse::success([], __('message.success.printer.deleted_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.printer.deleted_fail', 500);
        }
    }
}

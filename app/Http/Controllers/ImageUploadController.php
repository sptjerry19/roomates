<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Resources\ImageCollection;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImageUploadController extends Controller
{
    // Hiển thị form upload
    public function showUploadForm(Request $request)
    {
        try {
            $page = $request->input('page');
            $limit = $request->input('limit', config('constant.PAGINATION'));
            $collections = Collection::query()->where('user_id', auth()->user()->id)->paginate($limit);

            return ApiResponse::success(new ImageCollection($collections), __("Lấy dữ liệu bộ sưu tập thành công"));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Unable to upload images. Please try again.'], 500);
        }
    }

    // Xử lý upload nhiều hình ảnh
    public function uploadImages(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validate([
                'base64Images' => 'required',
            ]);

            // $base64Images = explode(',', $request->input('base64Images')[0]);
            $base64Images = $params['base64Images'];
            $path = 'uploads/images/';
            $uploadedImages = Common::uploadbase64Image($base64Images, $path, true, 'user-uploads');

            // Lưu từng ảnh vào DB
            foreach ($uploadedImages as $imagePath) {
                Collection::create([
                    'user_id' => auth()->user()->id,
                    'image' => $imagePath,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Images uploaded successfully!',
                'uploaded_paths' => $uploadedImages,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['error' => 'Unable to upload images. Please try again.'], 500);
        }
    }
}

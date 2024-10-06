<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    /**
     * Xử lý request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        try {
            // Lấy người dùng đã xác thực từ token
            $user = JWTAuth::parseToken()->authenticate();

            // Kiểm tra nếu người dùng không được xác thực
            if (!$user) {
                return ApiResponse::error(__('message.error.unauthorized'), 403);
            }

            // Lấy danh sách các vai trò của người dùng
            $roles = $user->roles()->pluck('name');

            // Kiểm tra xem người dùng có vai trò phù hợp hay không
            if (!$roles->contains($role)) {
                return ApiResponse::error(__('message.error.unauthorized'), 403);
            }
        } catch (\Exception $e) {
            return ApiResponse::error(__('message.error.authenticated'), 401);
        }

        return $next($request);
    }
}

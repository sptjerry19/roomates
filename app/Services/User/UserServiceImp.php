<?php

namespace App\Services\User;

use App\Helpers\Common;
use App\Repositories\User\UserRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserServiceImp extends BaseServiceImp implements UserService
{
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function getUser($email): mixed
    {
        try {
            $user = $this->repository->getUser($email);
            if (!$user) {
                throw new \Exception('User not found');
            }
            return $user;
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function login($user, $password): mixed
    {
        try {
            if (!$token = auth()->attempt(['email' => $user->email, 'password' => $password])) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'message' => ['Tài khoản hoặc mật khẩu không chính xác'],
                    ]
                ], 401);
            }

            $data = [
                'sub' => auth('api')->user()->id,
                'random' => rand() . time(),
                'exp' => time() + config('jwt.refresh_ttl'),
            ];

            $refreshToken = JWTAuth::getJWTProvider()->encode($data);

            $roles = $user->roles()->pluck('name');

            $insert_session_user =  DB::table('session_users')->insert([
                'token' => $token,
                'refresh_token' => $refreshToken,
                'token_expried' => auth()->factory()->getTTL() * 60,
                'refresh_token_expried' => config('jwt.refresh_ttl') * 60,
                // 'token_expried' =>  60,
                // 'refresh_token_expried' =>  60,
                'user_id' => $user->id,
            ]);

            if (!$insert_session_user) {
                return response()->json([
                    'message' => 'error: insert token to session user',
                ]);
            };

            return [
                'token' => $token,
                'refreshToken' => $refreshToken,
                'roles' => $roles
            ];
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\cms\Users\UpdateRequest;
use App\Http\Resources\Auth\UserResource;
use App\Mail\ForgotPasswordVerificationMail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\GoogleClientService;
use App\Services\User\UserService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Validator;

class AuthController extends Controller
{
    protected $userService;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh', 'forgotPassword', 'resetPassword', 'loginSocial', 'loginWithGoogle', 'checkVerification', 'findUser']]);
        $this->middleware(['role:Supper Admin|Admin|User management'])->only('userProfilebyId', 'listUsers', 'setTimeToken');

        $this->userService = $userService;
    }

    public function detail()
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error(__('message.error.unauthorized'), 401);
        }

        return ApiResponse::success(new UserResource($user), __('message.success.user_find'));
    }

    public function findUser(Request $request)
    {
        $fields = $request->validate([
            'email_or_phone' => 'required',
        ], [
            'email_or_phone.required' => 'Vui lòng nhập Email hoặc Số điện thoại.',
        ]);

        $user = $this->userService->getUser($fields['email_or_phone']);

        if (!$user) {
            return ApiResponse::error('Tài khoản không tồn tại.', 404);
        }

        return ApiResponse::success($user, __('Lấy thông tin người dùng thành công'));
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email_or_phone' => 'required',
            'password' => 'required|string|min:6',
        ], [
            'email_or_phone.required' => 'Vui lòng nhập Email hoặc Số điện thoại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải tối thiểu 6 ký tự',
        ]);

        $email_or_phone = $fields['email_or_phone'];
        $password = $fields['password'];


        if (filter_var($email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $user = User::with('company')->where('email', $email_or_phone)->first();
        } else if (preg_match('/^0[0-9]{9,10}$/', $email_or_phone)) {
            $user = User::with('company')->where('phone', $email_or_phone)->first();
        } else {
            return ApiResponse::error('Vui lòng nhập đúng định dạng Email hoặc Số điện thoại.', 400);
        }

        if (!$user) {
            return ApiResponse::error('Tài khoản không tồn tại.', 404);
        }

        $info = $this->userService->login($user, $password);

        $response = [
            'message' => 'login success',
            'data' => $this->createNewToken($info['token'], $info['refreshToken']),
            'user' => $user,
            'roles' => $info['roles'],
        ];

        return response($response, 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginSocial(Request $request)
    {
        // Validate the request
        $fields = $request->validate([
            'provider_id' => 'required',
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email|nullable|regex:/^0[0-9]{9}$/',
            'name' => 'nullable|string'
        ], [
            'provider_id.required' => 'Vui lòng nhập provider_id.',
            'email.required_without' => 'Vui lòng nhập Email hoặc Số điện thoại.',
            'email.email' => 'Vui lòng nhập đúng định dạng Email.',
            'phone.required_without' => 'Vui lòng nhập Số điện thoại hoặc Email.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
        ]);

        // Find or create user
        $user = User::query()->where('provider_id', $fields['provider_id'])->first();

        if (!$user) {
            $user = User::create([
                'provider_id' => $fields['provider_id'],
                'email' => $fields['email'],
                'name' => $fields['name'],
                'password' => bcrypt(Str::random(8)) // Generate a random password
            ]);

            $role = Role::findByName('Viewer');
            $user->assignRole($role);
        }

        // Generate token for the user
        $token = auth()->login($user);

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Generate refresh token data
        $data = [
            'sub' => $user->id,
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl'),
        ];

        $refreshToken = JWTAuth::getJWTProvider()->encode($data);

        // // Fetch user roles
        $role = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', '=', $user->id)
            ->get(['roles.name as role']);

        // // Insert session user data
        // $insertSessionUser = DB::table('session_users')->insert([
        //     'token' => $token,
        //     'refresh_token' => $refreshToken,
        //     'token_expired' => auth()->factory()->getTTL() * 60,
        //     'refresh_token_expired' => config('jwt.refresh_ttl') * 60,
        //     'user_id' => $user->id,
        // ]);

        // if (!$insertSessionUser) {
        //     return response()->json([
        //         'message' => 'Error: Failed to insert token into session user.',
        //     ]);
        // }

        // Prepare response
        $response = [
            'message' => 'Login successful',
            'token' => $this->createNewToken($token, $refreshToken),
            'user' => $user,
            'roles' => $role,
        ];

        return response()->json($response, 200);
    }

    public function loginWithGoogle(Request $request)
    {
        $idToken = $request->input('idToken');

        if (!$idToken) {
            return response()->json(['error' => 'No ID token provided'], 400);
        }

        $payload = $this->googleClientService->verifyIdToken($idToken);

        if ($payload) {
            // Token hợp lệ
            $googleId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'];

            // Tìm user với provider_id (Google ID)
            $user = User::where('provider_id', $googleId)->first();

            if (!$user) {
                // Nếu user chưa tồn tại, tạo mới user
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'provider' => 'google',
                    'provider_id' => $googleId,
                    'email_verified_at' => now(),
                ]);
            }

            try {
                // Tạo JWT token
                if (!$token = JWTAuth::fromUser($user)) {
                    return response()->json(['error' => 'Could not create token'], 500);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'Could not create token'], 500);
            }

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => [
                'required',
                'string',
                'min:10',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'site_hotline' => ['nullable', 'regex:/^(0[0-9]{9}|\+84[0-9]{9}|18[0-9]{6}|19[0-9]{6})$/'],
            'provider_id' => 'nullable'
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.between' => 'Tên phải có độ dài từ 2 đến 100 ký tự.',
            'email.required' => 'Vui lòng nhập Email.',
            'email.email' => 'Vui lòng nhập đúng định dạng Email.',
            'email.max' => 'Email không được quá 100 ký tự.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải tối thiểu 10 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ thường, một chữ hoa, một chữ số và một ký tự đặc biệt.',
            'site_hotline.regex' => 'Số điện thoại không đúng định dạng.',
        ]);

        $user = User::create(array_merge(
            $fields,
            ['password' => bcrypt($request->password)]
        ));

        $role = Role::findByName('Viewer');
        $user->assignRole($role);

        return response()->json([
            'message' => 'Đăng ký tài khoản thành công',
            'user' => $user,
            'role' => $role,
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $token = request()->bearerToken();
        $user = Auth::guard('api')->authenticate($token);
        DB::table('session_users')->where('user_id', '=', $user->id)->delete();
        auth()->logout();

        return response()->json(['message' => 'Đăng xuất tài khoản thành công']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $fieds = $request->validate([
            'refresh_token' => 'required',
        ]);
        $refreshToken = $fieds['refresh_token'];
        try {
            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decoded['sub']);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            };

            auth('api')->invalidate();

            $token = auth('api')->login($user);

            return response()->json([
                'message' => 'refresh token success',
                'data' => $this->createNewToken($token, $refreshToken),
                'user' => $user,
            ]);
        } catch (JWTException $exception) {
            return response()->json(['error' => 'refresh token invalid'], 500);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $user = auth()->user();
        $role = DB::table('model_has_roles')
            ->join('roles', 'role_id', '=', 'roles.id')
            ->join('users', 'model_id', '=', 'users.id')
            ->where('users.id', '=', $user->id)
            ->get(['roles.name as role']);

        if ($user->avatar !== null) {
            $user->avatar = UploadImage::responseImage($user->avatar);
        } else {
            $user->avatar = null;
        }

        $sites = collect($user->meta_sites)->map(function ($site) {
            return [
                'site_id' => $site['site_id'],
                'site_name' => $site['site_name'],
            ];
        });
        return response()->json([
            'message' => "get user success",
            'user' => $user,
            'role' => $role,
            'sites' => $sites
        ]);
    }

    /**
     * Get the authenticated User by id.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfilebyId(string $id)
    {
        $user = User::findOrFail($id);
        $role = $user->with('roles:id,name')->where('id', '=', $id)->select('id', 'name', 'email')->get();
        return response()->json([
            'message' => "get user success",
            'data' => $role,
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token, $refreshToken)
    {
        return [
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'token_expires_in' => auth()->factory()->getTTL() * 60,
            'refresh_token_expires_in' => config('jwt.refresh_ttl') * 60,
        ];
    }

    public function changePassWord(Request $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            return ApiResponse::error(['Mật khẩu cũ không đúng.'], 400);
        }
        $fields = $request->validate([
            'old_password' => 'required|string|min:6',
            'new_password' => [
                'confirmed',
                'required',
                'string',
                'min:10',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ], [
            'new_password.required' => 'Vui lòng nhập mật khẩu.',
            'new_password.min' => 'Mật khẩu phải tối thiểu 10 ký tự.',
            'new_password.regex' => 'Mật khẩu phải chứa ít nhất một chữ thường, một chữ hoa, một chữ số và một ký tự đặc biệt.',
            'new_password.confirmed' => 'Vui lòng nhật đúng mật khẩu xác nhận',
        ]);

        FacadesValidator::make($fields, [
            'new_password' => [
                'required',
                function ($attribute, $value, $fail) use ($fields) {
                    if ($value === $fields['old_password']) {
                        $fail('Mật khẩu mới phải khác mật khẩu cũ.');
                    }
                },
            ],
        ])->validate();

        $userId = auth()->user()->id;

        $user = User::where('id', $userId)->update(
            ['password' => bcrypt($request->new_password)]
        );

        return response()->json([
            'message' => 'Thay đổi mật khẩu thành công',
            'user' => $user,
        ], 201);
    }

    public function listUsers(Request $request)
    {
        $users = User::query()->get();

        return response()->json([
            'message' => 'get data list Users successfully',
            'user' => $users,
        ], 200);
    }

    /**
     * set token time life for user
     */
    public function setTimeToken(Request $request, string $id)
    {
        // get token of user
        $token = auth('api')->tokenById($id);

        $field = $request->validate([
            'setTTL' => 'required|integer'
        ]);

        $ttl = $field['setTTL'];

        auth('api')->tokenById($id)->setTTL($ttl);

        // set token time life for user
    }

    // public function updateUser(UpdateRequest $request)
    // {
    //     try {
    //         $user = auth()->user();

    //         $fields = $request->validated();

    //         (isset($fields['avatar'])) ? $avatar = UploadImage::responseImage(UploadImage::uploadbase64Image($fields['avatar'], 'avatar/')) : $avatar = $user->avatar;

    //         $data = [
    //             'phone' => $fields['phone'] ?? $user->phone,
    //             'name' => $fields['name'],
    //             'avatar' => $avatar,
    //             'sex' => $fields['sex'] ?? null,
    //             'first_name' => $fields['first_name'] ?? $user->first_name,
    //             'last_name' => $fields['last_name'] ?? $user->last_name,
    //             'status' => $fields['status'] ?? 1,
    //         ];

    //         $user->update($data);

    //         return ApiResponse::success($user, "Cập nhập thông tin người dùng thành công");
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return ApiResponse::error("Cập nhập thông tin người dùng thất bại", 500);
    //     }
    // }

    // public function forgotPassword(Request $request)
    // {
    //     $fields = $request->validate([
    //         'email' => 'required_without:phone|email',
    //         'phone' => 'required_without:email|regex:/^0[0-9]{9}$/',
    //     ], [
    //         'email.required_without' => 'Vui lòng cung cấp email nếu không có số điện thoại',
    //         'phone.required_without' => 'Vui lòng cung cấp số điện thoại nếu email không được cung cấp',
    //         'email.email' => 'Vui lòng cung cấp một địa chỉ email hợp lệ.',
    //         'phone.regex' => 'Vui lòng cung cấp số điện thoại hợp lệ bắt đầu bằng 0 và theo sau là 9 chữ số.',
    //     ]);

    //     $user = User::query()
    //         ->when(isset($fields['email']), function ($query) use ($fields) {
    //             return $query->where('email', $fields['email']);
    //         })
    //         ->when(isset($fields['phone']), function ($query) use ($fields) {
    //             return $query->where('phone', $fields['phone']);
    //         })
    //         ->whereNull('provider_id')
    //         ->first();

    //     if (!$user) {
    //         return response()->json(['error' => 'Tài khoản không tồn tại với email hoặc số điện thoại này.'], 400);
    //     }

    //     // Generate a random verification code (6 digits)
    //     $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    //     // Save the verification code to the user's record (for verification later)
    //     $user->verification_code = $verificationCode;
    //     $user->save();

    //     // Send email with verification code
    //     $data = [
    //         'verificationCode' => $verificationCode,
    //         'email' => $user->email,
    //     ];

    //     Mail::to($user->email)->send(new ForgotPasswordVerificationMail($data));

    //     return response()->json(['message' => 'Mã xác nhận đã được gửi đến email của bạn.'], 200);
    // }

    // public function checkVerification(Request $request)
    // {
    //     $fields = $request->validate([
    //         'email' => 'required_without:phone|email',
    //         'phone' => 'required_without:email|regex:/^0[0-9]{9}$/',
    //         'verification_code' => 'required|digits:6',
    //     ]);

    //     $user = User::query()
    //         ->when(isset($fields['email']), function ($query) use ($fields) {
    //             return $query->where('email', $fields['email']);
    //         })
    //         ->when(isset($fields['phone']), function ($query) use ($fields) {
    //             return $query->where('phone', $fields['phone']);
    //         })
    //         ->first();

    //     if (!$user || $user->verification_code != $request->verification_code) {
    //         return response()->json(['error' => 'Mã xác nhận không đúng hoặc đã hết hạn.'], 400);
    //     }

    //     return ApiResponse::success([], "Mã xác nhận hợp lệ", 200);
    // }

    // public function resetPassword(Request $request)
    // {
    //     $fields = $request->validate([
    //         'email' => 'required_without:phone|email',
    //         'phone' => 'required_without:email|regex:/^0[0-9]{9}$/',
    //         'verification_code' => 'required|digits:6',
    //         'password' => 'required|confirmed|min:8',
    //     ]);

    //     $user = User::query()
    //         ->when(isset($fields['email']), function ($query) use ($fields) {
    //             return $query->where('email', $fields['email']);
    //         })
    //         ->when(isset($fields['phone']), function ($query) use ($fields) {
    //             return $query->where('phone', $fields['phone']);
    //         })
    //         ->where('verification_code', $request->verification_code)->first();


    //     if (!$user) {
    //         return response()->json(['error' => 'Mã xác nhận không hợp lệ.'], 400);
    //     }

    //     $user->update([
    //         'password' => bcrypt($request->password),
    //         'verification_code' => null,
    //     ]);

    //     return ApiResponse::success($user, "cập nhập lại tài khoản thành công", 200);
    // }
}

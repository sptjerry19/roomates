<template>
    <div class="bg-gray-100 flex justify-center items-center h-screen">
        <!-- Left: Image -->
        <div class="w-1/2 h-screen hidden lg:block">
            <img
                src="https://placehold.co/800x/667fff/ffffff.png?text=Your+Image&font=Montserrat"
                alt="Placeholder Image"
                class="object-cover w-full h-full"
            />
        </div>
        <!-- Right: Login Form -->
        <div class="lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">
            <h1 class="text-2xl font-semibold mb-4">Login</h1>
            <form @submit.prevent="handleLogin">
                <!-- Username Input -->
                <div class="mb-4">
                    <label class="block text-gray-600">Email or Phone</label>
                    <input
                        type="text"
                        id="username"
                        v-model="email"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                        autocomplete="off"
                    />
                </div>
                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-600"
                        >Password</label
                    >
                    <input
                        type="password"
                        id="password"
                        name="password"
                        v-model="password"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                        autocomplete="off"
                    />
                </div>
                <!-- Remember Me Checkbox -->
                <div class="mb-4 flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="text-blue-500"
                    />
                    <label for="remember" class="text-gray-600 ml-2"
                        >Remember Me</label
                    >
                </div>
                <!-- Forgot Password Link -->
                <div class="mb-6 text-blue-500">
                    <a href="#" class="hover:underline">Forgot Password?</a>
                </div>
                <!-- Login Button -->
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 px-4 w-full"
                >
                    Login
                </button>
            </form>
            <!-- Sign up  Link -->
            <div class="mt-6 text-blue-500 text-center">
                <a href="#" class="hover:underline">Sign up Here</a>
            </div>
        </div>
    </div>
</template>

<script>
import { defaultApiClient } from "../../axios";
export default {
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        async handleLogin() {
            console.log(this.email);

            try {
                // Gửi yêu cầu đăng nhập và đợi phản hồi từ API
                const response = await defaultApiClient.post("/login", {
                    email_or_phone: this.email,
                    password: this.password,
                });

                // Xử lý khi đăng nhập thành công
                console.log("Đăng nhập thành công:", response.data.data);
                localStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user)
                );
                localStorage.setItem(
                    "access_token",
                    response.data.data.access_token
                );

                // Ví dụ: chuyển hướng người dùng hoặc lưu token đăng nhập
                if (response.data.roles.includes("Admin")) {
                    this.$router.push("/admin");
                } else {
                    this.$router.push("/");
                }
            } catch (error) {
                // Xử lý lỗi đăng nhập
                console.error(
                    "Đăng nhập thất bại:",
                    error.response?.data || error.message
                );
            }
        },
    },
};
</script>

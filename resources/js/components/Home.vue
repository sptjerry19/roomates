<template>
    <div class="Products">
        <!-- Create By Joker Banny -->
        <div class="bg-white">
            <!-- Header Navbar -->
            <nav
                class="fixed top-0 left-0 z-20 w-full bg-sky-100 py-2.5 px-6 border-b border-gray-200"
            >
                <div
                    class="container mx-auto flex items-center justify-between"
                >
                    <!-- Logo và tên trang -->
                    <div class="flex items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-8 w-8 text-blue-700"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"
                            />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-blue-700"
                            >Roomates</span
                        >
                    </div>

                    <!-- Thanh tìm kiếm -->
                    <div class="w-[647px]">
                        <div class="relative">
                            <input
                                type="text"
                                placeholder="Tìm kiếm"
                                class="w-full rounded-full border-4 border-orange-500 py-2 px-4 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                            />
                            <button
                                class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full p-2 text-orange-400 hover:text-orange-700"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-4"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-6-6m3-9a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Icon người dùng, thông báo, và nút Đăng bài -->
                    <div v-if="user">
                        <div class="flex items-center space-x-4">
                            <!-- Icon người dùng -->
                            <button class="relative">
                                <img
                                    class="w-10 h-10 rounded-full"
                                    :src="
                                        user.avatar
                                            ? user.avatar
                                            : 'https://flowbite.com/docs/images/people/profile-picture-5.jpg'
                                    "
                                    alt="User Avatar"
                                />
                            </button>

                            <!-- Icon thông báo -->
                            <button class="relative">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-6 w-6 text-blue-700"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 9.75V8.25a6 6 0 00-12 0v1.5a5.25 5.25 0 0010.5 0zM10.5 21.75a1.5 1.5 0 001.5-1.5H9a1.5 1.5 0 001.5 1.5z"
                                    />
                                </svg>
                                <!-- Badge số thông báo -->
                                <span
                                    class="absolute -top-1 -right-1 flex h-3 w-3 items-center justify-center rounded-full bg-red-500 text-[10px] text-white"
                                >
                                    3
                                </span>
                            </button>

                            <!-- Nút Đăng bài -->
                            <button
                                class="rounded bg-blue-700 py-1.5 px-4 text-sm font-medium text-white hover:bg-blue-800 focus:ring-2 focus:ring-blue-500"
                            >
                                Đăng bài
                            </button>
                        </div>
                    </div>

                    <div v-else class="mt-2 sm:mt-0 sm:flex md:order-2">
                        <router-link to="login">
                            <!-- Login Button -->
                            <button
                                type="button"
                                class="rounde mr-3 hidden border border-blue-700 py-1.5 px-6 text-center text-sm font-medium text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 md:inline-block rounded-lg"
                            >
                                Login
                            </button>
                        </router-link>
                        <button
                            type="button"
                            class="rounde mr-3 hidden bg-blue-700 py-1.5 px-6 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 md:mr-0 md:inline-block rounded-lg"
                        >
                            Register
                        </button>
                        <!-- Register Button -->
                        <button
                            data-collapse-toggle="navbar-sticky"
                            type="button"
                            class="inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden"
                            aria-controls="navbar-sticky"
                            aria-expanded="false"
                        >
                            <span class="sr-only">Open main menu</span>
                            <svg
                                class="h-6 w-6"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Danh sách menu -->
                <div
                    class="mt-6 flex justify-center text-2xl font-bold text-blue-700"
                >
                    <router-link to="home" class="hover:underline px-10 py-1"
                        >Trang chủ</router-link
                    >
                    <router-link
                        to="phong-tro"
                        class="hover:underline px-10 py-1"
                        >Phòng trọ</router-link
                    >
                    <router-link
                        to="roomates"
                        class="hover:underline px-10 py-1"
                        >Tìm roommates</router-link
                    >
                    <router-link
                        to="bang-gia"
                        class="hover:underline px-10 py-1"
                        >Bảng giá</router-link
                    >
                </div>
            </nav>

            <!-- Title -->
            <div
                class="mt-32 flex items-center justify-center pt-4 pb-3 bg-gray-100"
            >
                <div
                    v-for="(filter, index) in filters"
                    :key="index"
                    class="flex items-center ml-6 space-x-2 rounded-full border border-orange-400 px-4 py-2 text-orange-500 hover:bg-orange-100 cursor-pointer"
                >
                    <!-- Icon -->
                    <span :class="filter.icon" class="text-orange-500"></span>

                    <!-- Label hoặc Placeholder -->
                    <span v-if="filter.placeholder" class="text-sm">{{
                        filter.placeholder
                    }}</span>
                    <span v-else class="text-sm">{{ filter.label }}</span>

                    <!-- Dropdown Icon -->
                    <span class="material-icons">arrow_drop_down</span>
                </div>
            </div>

            <!-- Danh sách bài đăng -->
            <section class="bg-gray-100">
                <div class="mx-auto max-w-3xl grid-cols-1 gap-6 p-6">
                    <article
                        v-for="post in posts"
                        :key="post.id"
                        class="rounded-xl bg-white p-3 shadow-lg hover:shadow-xl hover:transform hover:scale-105 duration-300 mb-5"
                    >
                        <a href="#">
                            <!-- Hình ảnh phòng trọ -->
                            <div
                                class="relative flex items-end overflow-hidden rounded-xl"
                            >
                                <img
                                    class="w-full h-40 object-cover"
                                    :src="
                                        post.image &&
                                        post.image !==
                                            'https://defaultimage.com'
                                            ? post.image
                                            : '/images/default-room.jpg'
                                    "
                                    alt="Room Post"
                                />
                                <span
                                    class="absolute top-2 left-2 bg-blue-500 px-2 py-1 text-xs font-medium text-white rounded-full"
                                >
                                    {{
                                        post.type === "room"
                                            ? "Phòng trọ"
                                            : "Roommate"
                                    }}
                                </span>
                            </div>

                            <!-- Thông tin bài đăng -->
                            <div class="mt-2 p-2">
                                <h2
                                    class="text-slate-700 font-bold text-lg truncate"
                                >
                                    {{ post.title }}
                                </h2>
                                <p class="mt-1 text-sm text-slate-400">
                                    {{ post.location }}
                                </p>

                                <div
                                    class="mt-3 flex items-center justify-between"
                                >
                                    <p class="text-lg font-bold text-blue-500">
                                        {{ post.price }} VNĐ/tháng
                                    </p>
                                    <div
                                        class="flex items-center space-x-1.5 rounded-lg bg-blue-500 px-4 py-1.5 text-white duration-100 hover:bg-blue-600"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="h-4 w-4"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15.75 9V5.25a3.75 3.75 0 00-7.5 0V9m0 0a3.75 3.75 0 017.5 0m-7.5 0v10.5a3.75 3.75 0 007.5 0V9"
                                            />
                                        </svg>
                                        <button class="text-sm">
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                </div>
            </section>

            <!-- Component phân trang -->
            <Pagination
                :total-pages="totalPages"
                :current-page="currentPage"
                @page-changed="handlePageChange"
            />

            <!-- Footer -->
            <footer class="py-6 bg-gray-200 text-gray-900">
                <div
                    class="container px-6 mx-auto space-y-6 divide-y divide-gray-400 md:space-y-12 divide-opacity-50"
                >
                    <div class="grid justify-center lg:justify-between">
                        <div
                            class="flex flex-col self-center text-sm text-center md:block lg:col-start-1 md:space-x-6"
                        >
                            <span>Copy rgight © 2023 by codemix team </span>
                            <a rel="noopener noreferrer" href="#">
                                <span>Privacy policy</span>
                            </a>
                            <a rel="noopener noreferrer" href="#">
                                <span>Terms of service</span>
                            </a>
                        </div>
                        <div
                            class="flex justify-center pt-4 space-x-4 lg:pt-0 lg:col-end-13"
                        >
                            <a
                                rel="noopener noreferrer"
                                href="#"
                                title="Email"
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 hover:bg-blue-600 duration-150 text-gray-50"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"
                                    ></path>
                                    <path
                                        d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"
                                    ></path>
                                </svg>
                            </a>
                            <a
                                rel="noopener noreferrer"
                                href="#"
                                title="Twitter"
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 hover:bg-blue-600 duration-150 text-gray-50"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 50 50"
                                    fill="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        d="M 50.0625 10.4375 C 48.214844 11.257813 46.234375 11.808594 44.152344 12.058594 C 46.277344 10.785156 47.910156 8.769531 48.675781 6.371094 C 46.691406 7.546875 44.484375 8.402344 42.144531 8.863281 C 40.269531 6.863281 37.597656 5.617188 34.640625 5.617188 C 28.960938 5.617188 24.355469 10.21875 24.355469 15.898438 C 24.355469 16.703125 24.449219 17.488281 24.625 18.242188 C 16.078125 17.8125 8.503906 13.71875 3.429688 7.496094 C 2.542969 9.019531 2.039063 10.785156 2.039063 12.667969 C 2.039063 16.234375 3.851563 19.382813 6.613281 21.230469 C 4.925781 21.175781 3.339844 20.710938 1.953125 19.941406 C 1.953125 19.984375 1.953125 20.027344 1.953125 20.070313 C 1.953125 25.054688 5.5 29.207031 10.199219 30.15625 C 9.339844 30.390625 8.429688 30.515625 7.492188 30.515625 C 6.828125 30.515625 6.183594 30.453125 5.554688 30.328125 C 6.867188 34.410156 10.664063 37.390625 15.160156 37.472656 C 11.644531 40.230469 7.210938 41.871094 2.390625 41.871094 C 1.558594 41.871094 0.742188 41.824219 -0.0585938 41.726563 C 4.488281 44.648438 9.894531 46.347656 15.703125 46.347656 C 34.617188 46.347656 44.960938 30.679688 44.960938 17.09375 C 44.960938 16.648438 44.949219 16.199219 44.933594 15.761719 C 46.941406 14.3125 48.683594 12.5 50.0625 10.4375 Z"
                                    ></path>
                                </svg>
                            </a>
                            <a
                                rel="noopener noreferrer"
                                href="#"
                                title="GitHub"
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 hover:bg-blue-600 duration-150 text-gray-50"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    class="w-5 h-5"
                                >
                                    <path
                                        d="M10.9,2.1c-4.6,0.5-8.3,4.2-8.8,8.7c-0.5,4.7,2.2,8.9,6.3,10.5C8.7,21.4,9,21.2,9,20.8v-1.6c0,0-0.4,0.1-0.9,0.1 c-1.4,0-2-1.2-2.1-1.9c-0.1-0.4-0.3-0.7-0.6-1C5.1,16.3,5,16.3,5,16.2C5,16,5.3,16,5.4,16c0.6,0,1.1,0.7,1.3,1c0.5,0.8,1.1,1,1.4,1 c0.4,0,0.7-0.1,0.9-0.2c0.1-0.7,0.4-1.4,1-1.8c-2.3-0.5-4-1.8-4-4c0-1.1,0.5-2.2,1.2-3C7.1,8.8,7,8.3,7,7.6C7,7.2,7,6.6,7.3,6 c0,0,1.4,0,2.8,1.3C10.6,7.1,11.3,7,12,7s1.4,0.1,2,0.3C15.3,6,16.8,6,16.8,6C17,6.6,17,7.2,17,7.6c0,0.8-0.1,1.2-0.2,1.4 c0.7,0.8,1.2,1.8,1.2,3c0,2.2-1.7,3.5-4,4c0.6,0.5,1,1.4,1,2.3v2.6c0,0.3,0.3,0.6,0.7,0.5c3.7-1.5,6.3-5.1,6.3-9.3 C22,6.1,16.9,1.4,10.9,2.1z"
                                    ></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <loading :isLoading="loading"></loading>
</template>

<script>
import apiClient, { defaultApiClient } from "../axios";
import Pagination from "./Pagination.vue";
import loading from "./loading.vue";

export default {
    name: "Home",
    components: {
        Pagination,
        loading,
    },
    data() {
        return {
            filters: [
                {
                    label: "Từ khóa",
                    placeholder: "Từ khóa, Đường, Quận, Địa điểm...",
                    icon: "material-icons-outlined search",
                },
                {
                    label: "Khu vực",
                    icon: "material-icons-outlined location_on",
                },
                {
                    label: "Diện tích",
                    icon: "material-icons-outlined category",
                },
                {
                    label: "Giá thuê",
                    icon: "material-icons-outlined attach_money",
                },
                {
                    label: "Lọc thêm",
                    icon: "material-icons-outlined filter_list",
                },
            ],
            posts: [
                {
                    id: 1,
                    title: "Phòng trọ giá rẻ Quận 1",
                    location: "123 Đường ABC, Quận 1, TP. Hồ Chí Minh",
                    price: "3.000.000",
                    image: "/images/room1.jpg",
                    type: "room",
                },
                {
                    id: 2,
                    title: "Tìm roommate ở ghép Quận 3",
                    location: "45 Đường XYZ, Quận 3, TP. Hồ Chí Minh",
                    price: "1.500.000",
                    image: "/images/roommate1.jpg",
                    type: "roommate",
                },
                {
                    id: 3,
                    title: "Phòng trọ mới xây Bình Thạnh",
                    location: "78 Đường DEF, Bình Thạnh, TP. Hồ Chí Minh",
                    price: "2.800.000",
                    image: "/images/room2.jpg",
                    type: "room",
                },
                {
                    id: 4,
                    title: "Cần tìm bạn ở ghép Thủ Đức",
                    location: "22 Đường LMN, Thủ Đức, TP. Hồ Chí Minh",
                    price: "1.800.000",
                    image: "/images/roommate2.jpg",
                    type: "roommate",
                },
            ],
            loading: false,
            user: null,
            products: [],
            currentPage: 1, // Trang hiện tại
            itemsPerPage: 12, // Số sản phẩm mỗi trang
            totalPages: 6, // Số sản phẩm mỗi trang
        };
    },
    mounted() {
        this.fetchRoomatesData();

        // Kiểm tra và lấy user từ localStorage khi component được mount
        const storedUser = localStorage.getItem("user");
        if (storedUser) {
            this.user = JSON.parse(storedUser);
        }
    },
    methods: {
        async fetchRoomatesData(page = 1) {
            this.loading = true;
            try {
                // Truyền tham số page và itemsPerPage vào API
                const response = await apiClient.get("/product", {
                    params: {
                        page: page,
                        limit: this.itemsPerPage, // hoặc 'per_page' tuỳ theo API của bạn
                    },
                });
                this.products = response.data.data;
                this.currentPage = response.data.pagination.current_page;
                this.itemsPerPage = response.data.pagination.per_page;
                this.totalPages = response.data.pagination.last_page;
            } catch (error) {
                console.error("Error fetching data", error);
            } finally {
                this.loading = false; // Ẩn spinner
            }
        },

        async fetchLogout() {
            this.loading = true;
            try {
                const response = await defaultApiClient.post("/logout");
                localStorage.removeItem("user");
                localStorage.removeItem("access_token");
                this.user = null;
                window.location.reload();
            } catch (error) {
                console.error("Error logging out", error);
            } finally {
                this.loading = false; // Ẩn spinner
            }
        },

        handlePageChange(page) {
            this.currentPage = page;
            this.fetchRoomatesData(page); // Gọi lại API với trang mới
        },
    },
};
</script>

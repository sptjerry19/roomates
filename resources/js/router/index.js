import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue"; // Đảm bảo đường dẫn này đúng
import Login from "../components/Auth/Login.vue";
import Dashboard from "../components/Admin/DashBoard.vue";

const routes = [
    {
        path: "/",
        component: Home,
    },
    {
        path: "/login",
        component: Login,
    },
    {
        path: "/admin",
        component: Dashboard,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

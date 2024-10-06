import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import apiClient from "./axios";

createApp(App).use(router).use(apiClient).mount("#app");

import axios from "axios";

// Tạo một axios instance
const apiClient = axios.create({
    baseURL: "http://127.0.0.1:8000/api/v1/admin", // Thay thế bằng URL API của bạn
    headers: {
        "Content-Type": "application/json",
    },
});

// Thêm interceptor để thêm token vào request
apiClient.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("access_token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Tương tự cho axiosInstance
const axiosInstance = axios.create({
    baseURL: "http://127.0.0.1:8000/api/v1", // Thay thế bằng URL API của bạn
    headers: {
        "Content-Type": "application/json",
    },
});

axiosInstance.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("access_token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Gán instance này cho các request của bạn
export const adminApiClient = apiClient;
export const defaultApiClient = axiosInstance;
export default apiClient;

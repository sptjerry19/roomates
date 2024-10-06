import axios from "axios";

// Tạo một instance của axios với cấu hình mặc định
const apiClient = axios.create({
    baseURL: "http://127.0.0.1:8000/api/v1/admin", // Thay thế bằng URL API của bạn
    headers: {
        "Content-Type": "application/json", // Định dạng dữ liệu mặc định
        Authorization: `Bearer ${localStorage.getItem("access_token")}`, // Thêm token (nếu có)
    },
});

const axiosInstance = axios.create({
    baseURL: "http://127.0.0.1:8000/api/v1", // Thay thế bằng URL API của bạn
    headers: {
        "Content-Type": "application/json", // Định dạng dữ liệu mặc định
    },
});

// Gán instance này cho các request của bạn
export const adminApiClient = apiClient;
export const defaultApiClient = axiosInstance;
export default apiClient;

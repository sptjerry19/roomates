// src/utils/common.js

export function formatVND(number) {
    return number.toLocaleString("vi-VN", {
        style: "currency",
        currency: "VND",
    });
}

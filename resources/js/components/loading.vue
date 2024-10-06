<template>
    <div
        v-if="isLoading"
        class="w-full h-full fixed block top-0 left-0 bg-white opacity-75 z-50"
    >
        <span
            class="text-green-500 opacity-75 top-1/2 my-0 mx-auto block relative w-0 h-0"
            style="top: 50%"
        >
            <i class="fas fa-circle-notch fa-spin fa-5x"></i>
        </span>
    </div>
</template>

<script>
export default {
    name: "LoadingSpinner",
    props: {
        isLoading: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style scoped>
/* Bạn có thể thêm CSS tùy chỉnh nếu cần */
</style>

<!-- Đảm bảo rằng bạn đã thêm link Font Awesome vào index.html hoặc trong một component khác -->

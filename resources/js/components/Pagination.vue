<template>
    <nav>
        <ul class="flex items-center justify-center">
            <li>
                <a
                    class="mx-1 flex h-9 w-9 items-center justify-center rounded-full border border-blue-gray-100 bg-transparent p-0 text-sm text-blue-gray-500 transition duration-150 ease-in-out hover:bg-light-300"
                    href="#"
                    aria-label="Previous"
                    @click.prevent="previousPage"
                >
                    <span class="material-icons text-sm"
                        >keyboard_arrow_left</span
                    >
                </a>
            </li>
            <li v-for="page in totalPages" :key="page">
                <a
                    :class="[
                        'mx-1 flex h-9 w-9 items-center justify-center rounded-full p-0 text-sm transition duration-150 ease-in-out',
                        currentPage === page
                            ? 'bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-md shadow-pink-500/20'
                            : 'border border-blue-gray-100 bg-transparent text-blue-gray-500 hover:bg-light-300',
                    ]"
                    href="#"
                    @click.prevent="setPage(page)"
                >
                    {{ page }}
                </a>
            </li>
            <li>
                <a
                    class="mx-1 flex h-9 w-9 items-center justify-center rounded-full border border-blue-gray-100 bg-transparent p-0 text-sm text-blue-gray-500 transition duration-150 ease-in-out hover:bg-light-300"
                    href="#"
                    aria-label="Next"
                    @click.prevent="nextPage"
                >
                    <span class="material-icons text-sm"
                        >keyboard_arrow_right</span
                    >
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        totalPages: {
            type: Number,
            required: true,
        },
        currentPage: {
            type: Number,
            required: true,
        },
    },
    methods: {
        previousPage() {
            if (this.currentPage > 1) {
                this.$emit("page-changed", this.currentPage - 1);
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.$emit("page-changed", this.currentPage + 1);
            }
        },
        setPage(page) {
            this.$emit("page-changed", page);
        },
    },
};
</script>

<!-- You can include the Material Tailwind CSS and Icons globally in your main project or use a CDN in the index.html -->
<style scoped>
/* @import url("https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css"); */
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");
</style>

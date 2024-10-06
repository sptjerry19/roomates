<template>
    <div id="app">
        <!-- <nav>
            <router-link to="/">Home</router-link> |
            <router-link to="/library">Library</router-link>
        </nav> -->
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "App",
};
</script>

<style scoped>
nav {
    padding: 1rem;
    background-color: #1db954;
    color: white;
    text-align: center;
}

nav a {
    color: white;
    margin: 0 10px;
    text-decoration: none;
}
</style>

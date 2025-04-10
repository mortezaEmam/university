<template>
    <div class="app-container">
        <!-- هدر -->
        <Header />

        <!-- محتوای اصلی داخل روتر ویو -->
        <div class="content">
            <router-view />
        </div>

        <!-- فوتر -->
        <Footer />
    </div>
</template>

<script>
import Header from '../Components/sections/Header.vue';
import Footer from '../Components/sections/Footer.vue';

export default {
    name: "App",
    components: {
        Header, Footer
    }
};
</script>

<style scoped>
    .content {
        background-image: url("/assets/icons/background.png");
    }
    .app-container {
        background-image: url("/assets/icons/background.png");
        height: 100vh;
        padding-bottom: 50px
    }
</style>

<template>
    <div class="background-container">
        <!-- پس‌زمینه خاکستری روشن -->
        <div class="light-gray-bg"></div>

        <!-- بخش سفید اصلی با کلایپت -->
        <div class="main-background">
            <svg width="100%" height="100%" viewBox="0 0 1440 1024" preserveAspectRatio="none">
                <rect width="100%" height="100%" fill="white"/>
                <rect y="990" width="100%" height="34" fill="#9E0B0F"/>
            </svg>
        </div>

        <!-- محتوای دیگر -->
        <div class="content">
        </div>
    </div>
</template>

<script>
export default {
    name: 'EnhancedBackgroundDesign',
}
</script>

<style>
.background-container {
    position: relative;
    width: 100%;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.light-gray-bg {
    width: 100%;
    height: 100%;
    background-color: #F5F5F5;
    z-index: -1;
}

.main-background {
    width: 100%;
    z-index: 0;
}

.main-background svg {
    display: block;
}

.content {
    z-index: 1;
    position: relative;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

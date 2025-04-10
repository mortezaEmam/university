<template>
    <header class="header bg-red-800 text-white px-4 py-3 flex items-center justify-end">
        <div class="flex items-center gap-2">
            <!-- نام کاربر و آیکن آن، با کمی فاصله -->
            <div class="flex items-center gap-1 ms-4">
                <span>{{ userName }}</span>
                <img src="/build/assets/icons/user-check.svg" alt="user" class="w-5 h-5" />
            </div>

            <!-- آیکون‌های دیگر -->
            <img src="/build/assets/icons/colorTheme.svg" alt="theme" class="w-5 h-5" />
            <img src="/build/assets/icons/flag 1.svg" alt="flag" class="w-5 h-5" />
        </div>
    </header>
</template>

<script>
export default {
    data() {
        return {
            userName: 'مرتضی امام وردی'
        };
    }
};
</script>

<style scoped>
.header {
    font-family: 'IRANSans', sans-serif;
    direction: rtl;
}
</style>

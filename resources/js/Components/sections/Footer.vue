<template>
    <footer class="footer bg-red-800 text-white px-4 py-3 position-fixed bottom-0 left-0 right-0 flex items-center justify-between rtl">
        <!-- متن سمت راست -->
        <div class="text-xs">
            دانشگاه آزاد اسلامی واحد مشهد
        </div>

        <!-- تاریخ داینامیک سمت چپ -->
        <div class="flex items-center gap-1 text-xs">
            <span>{{ todayLabel }}</span>
            <span>:</span>
            <span>{{ formattedDate }}</span>

        </div>
    </footer>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            formattedDate: '',
            todayLabel: 'امروز'
        };
    },
    async mounted() {
        await this.fetchPersianDate();
        this.interval = setInterval(this.fetchPersianDate, 60000);
    },
    beforeUnmount() {
        clearInterval(this.interval);
    },
    methods: {
        async fetchPersianDate() {
            try {
                const response = await axios.get('/api/date/persian-date');
                this.formattedDate = response.data.date;
                this.todayLabel = response.data.today || 'امروز';
            } catch (error) {
                this.useFallbackDate();
            }
        },
        useFallbackDate() {
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                numberingSystem: 'latn' // استفاده از اعداد انگلیسی
            };

            let date = new Date().toLocaleDateString('fa-IR', options);
            date = date.replace(/،/g, ' ').replace(/\s+/g, ' ').trim();
            this.formattedDate = date;
        }
    }
};
</script>

<style scoped>
.footer {
    font-family: 'IRANSans', sans-serif;
    direction: rtl;
    font-size: 0.75rem; /* 12px */
    line-height: 1rem; /* 16px */
}

.rtl {
    direction: rtl;
    unicode-bidi: embed;
}
</style>

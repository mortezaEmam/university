<template>
  <header class="header bg-red-800 text-white px-4 py-3 flex items-center justify-end" style="height: 54px">
    <div class="flex items-center gap-2">
      <!-- نام کاربر و آیکن آن، با کمی فاصله -->
      <div class="relative flex items-center gap-1 ms-4 ">
        <img src="/assets/icons/user-check.svg" alt="user" class="w-5 h-5" />
        <span @click="toggleDropdown" class="cursor-pointer whitespace-nowrap text-user">{{ userName }}</span>

        <!-- منوی پاپ‌آپ -->
        <div v-if="isDropdownOpen && userName" class="absolute right-0 mt-2 bg-white text-black rounded-lg shadow-lg p-2 z-50">
          <ul>
            <li @click="viewProfile" class="cursor-pointer hover:bg-gray-100 px-4 py-2 whitespace-nowrap">مشاهده پروفایل</li>
            <li @click="logout" class="cursor-pointer hover:bg-gray-100 px-4 py-2 whitespace-nowrap">خروج</li>
          </ul>
        </div>
      </div>

      <!-- آیکون‌های دیگر -->
      <img src="/assets/icons/colorTheme.svg" alt="theme" class="w-5 h-5" style="width: 22px;
height: 22px;
top: 14px;
left: 64px;
"/>
      <img src="/assets/icons/flag 1.svg" alt="flag" class="w-5 h-5" />
    </div>
  </header>
</template>

<script>
import api from '@/axios';
export default {
  data() {
    return {
      userName: '', // نام کاربر
      isDropdownOpen: false, // وضعیت منو
    };
  },
  mounted() {
    // قبل از درخواست به سرور بررسی کنید که آیا کاربر وارد شده است یا خیر
    if (localStorage.getItem('token')) {
      this.fetchUserData(); // دریافت اطلاعات کاربر فقط در صورتی که توکن موجود باشد
    } else {
      // اگر توکن وجود نداشت، به صفحه ورود هدایت کنید
      this.$router.push('/login');
    }
  },
  methods: {
    async fetchUserData() {
      try {
        const response = await api.get('/user');
        this.userName = response.data.first_name || response.data.name || 'کاربر';
      } catch (error) {
        console.error('خطا در دریافت اطلاعات کاربر:', error);
      }
    },
    // باز یا بسته کردن منوی پاپ‌آپ
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    // مشاهده پروفایل
    viewProfile() {
      // مسیر‌یابی به صفحه پروفایل
      this.$router.push('/profile');
    },
    logout() {
      // حذف توکن از حافظه مرورگر
      localStorage.removeItem('token');

      // حذف هدر Authorization از axios
      delete api.defaults.headers.common['Authorization'];

      // هدایت به صفحه ورود
      this.$router.push('/login');
    }
  }
};
</script>

<style scoped>
.header {
  font-family: 'IRANSans', sans-serif;
  direction: rtl;
}

.relative {
  position: relative;
}

.absolute {
  position: absolute;
  top: 100%; /* به پایین عنصر مادر برود */
  right: 0;
  max-height: 300px; /* حداکثر ارتفاع منو */
  overflow-y: auto; /* در صورت لزوم اسکرول می‌شود */
  z-index: 50; /* تنظیم لایه منو */
}

.whitespace-nowrap {
  white-space: nowrap; /* جلوگیری از رفتن متن به خط بعد */
}

.text-user{
  width: 86px;
  height: 17px;
  top: 18px;
  left: 124px;

}
</style>

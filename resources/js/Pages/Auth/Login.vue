<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = reactive({
  email: '',
  password: '',
  remember: false,
  errors: {
    email: null,
    password: null,
  }
});

const status = ref('');
const canResetPassword = ref(false);

const router = useRouter();

onMounted(() => {
  // مثلا بررسی URL برای تنظیم وضعیت canResetPassword
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('resetPassword')) {
    canResetPassword.value = true;
  }
});

const submit = async () => {
  try {
    const response = await axios.post('/api/login', {
      email: form.email,
      password: form.password,
    });

    localStorage.setItem('token', response.data.token);
    router.push('/');
  } catch (error) {
    if (error.response.status === 422) {
      // خطاهای ولیدیشن
      form.errors.email = error.response.data.errors.email?.[0] || null;
      form.errors.password = error.response.data.errors.password?.[0] || null;
    } else if (error.response.status === 401) {
      // خطای اعتبارسنجی JWT (مثلاً رمز اشتباه)
      form.errors.email = error.response.data.message;
    } else {
      // سایر خطاها
      console.error('Unexpected error:', error.response.data);
    }
  }

};
</script>


<template>
  <GuestLayout>
    <title>ورود</title>

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />

        <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />

        <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="current-password"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4 block">
        <label class="flex items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <span class="ms-2 text-sm text-gray-600"
          >Remember me</span
          >
        </label>
      </div>

      <div class="mt-4 flex items-center justify-end">
        <router-link
            v-if="canResetPassword"
            :to="{ name: 'password.request' }"
            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          Forgot your password?
        </router-link>

        <PrimaryButton
            class="ms-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
        >
          ورود
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>

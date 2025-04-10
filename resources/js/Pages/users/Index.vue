<template>
  <div v-if="loading" class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>

  <div v-else class="col-md-4" v-for="user in users" :key="user.id">
    <UserCardViwe :user="user" />
  </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import UserCardViwe from "@/components/users/CardView.vue";

export default {
  components: {
    UserCardViwe,
  },
  setup() {
    const users = ref([]);
    const loading = ref(true);

    function getUsers() {
      axios
        .get("api/students")
        .then(function (response) {
          users.value = response.data;
            console.log(users.value)
          loading.value = false;
        })
        .catch(function (error) {
          console.log(error);
        });
    }

    getUsers();

    return { users, loading };
  },
};
</script>

<style>
</style>

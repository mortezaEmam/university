<template>
  <div class="card">
    <div class="card-header">
        <router-link :to="{ name : 'userId' , params: { user: user.id } }">{{ user.first_name }}{{user.last_name}}</router-link>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">national_code : {{ user.national_code }}</li>
      <li class="list-group-item">Email : {{ user.email }}</li>
      <li class="list-group-item">Phone : {{ user.phone }}</li>
    </ul>
  </div>
</template>

<script>
export default {
    props: {
        user:Object
    }
};
</script>

<style>
</style>

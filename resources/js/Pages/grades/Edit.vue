<template>
    <div v-if="pageLoading" class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>

    <div v-else class="col-md-6">
        <h2 class="mb-5">Edit Post :</h2>

        <gradeForm
            @formData="updatePost"
            :button-loading="loading"
            button-text="Edit Post"
            :grade="garde"
            :student="student"
        />
    </div>
</template>

<script>
import gradeForm from "@/components/grades/Form.vue";
import { ref } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
import { useRoute } from "vue-router";

export default {
    components: {
        gradeForm,
    },
    setup() {
        const loading = ref(false);
        const pageLoading = ref(true);
        const student = ref({});
        const grade = ref({});
        const route = useRoute();

        function getGrade() {
            axios
                .get(`/api/students/${route.params.user}/grades/${route.params.courseTeacherId }`)
                .then(function (response) {
                    student.value = response.data.student;
                    grade.value = response.data.grade;
                    pageLoading.value = false
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        getGrade();

        function updatePost(formData) {
            loading.value = true;
            console.log();
            axios
                .put(`https://jsonplaceholder.typicode.com/posts/${route.params.id}`, {
                    id: route.params.id,
                    title: formData.title,
                    body: formData.body,
                    userId: 1,
                })
                .then(function () {
                    loading.value = false;

                    Swal.fire({
                        title: "Thanks!",
                        text: "Post update successfully",
                        icon: "success",
                        confirmButtonText: "Ok",
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        return { updatePost, loading,student,grade,pageLoading };
    },
};
</script>

<style>
</style>

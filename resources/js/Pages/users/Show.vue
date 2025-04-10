<template>
    <div v-if="loading" class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>

    <div class="table-responsive p-3">
        <!-- Student Information Table -->
        <div class="p-3 border bg-light mb-3">
            <!-- Student Information Fields here -->
        </div>

        <table id="gradesTable" class="table table-bordered text-center align-middle">
            <thead class="table-secondary">
            <tr class="w-100 p-1">
                <th>#</th>
                <th>کد درس</th>
                <th>نام درس</th>
                <th>واحد</th>
                <th>نمره</th>
                <th>وضعیت نمره</th>
                <th>استاد</th>
                <th>توضیحات</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(grade, index) in student?.grades || []" :key="grade.id">
                <td>{{ index + 1 }}</td>
                <td>{{ grade.course.course_code }}</td>
                <td>{{ grade.course.title }}</td>
                <td>{{ grade.course.credit }}</td>
                <td>{{ grade.grade }}</td>
                <td>{{ getGradeStatus(grade.status) }}</td>
                <td>{{ grade.teacher?.user.first_name }} {{ grade.teacher?.user.last_name }}</td>
                <td>{{ grade.description || '-' }}</td>
                <td>
                    <router-link class="btn btn-dark" :to="{name:'gradeEdit', params: { user:student.user_id,courseTeacherId : grade.course_teacher_id  }}">ویرایش</router-link>
                    <button @click="deleteGrade(grade.id)">حذف</button>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Grade Average -->
        <div class="row mt-3">
            <div class="col-md-4 d-flex align-items-center gap-3 flex-nowrap justify-content-end ms-auto">
                <label class="form-label text-nowrap">معدل نرم:</label>
                <div class="form-control input-style">{{ averageGrade }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted, nextTick } from "vue";
import { useRoute } from "vue-router";

export default {
    setup() {
        const student = ref({});
        const loading = ref(true);
        const route = useRoute();

        function getUser() {
            axios
                .get(`/api/students/${route.params.id}/grades`)
                .then(function (response) {
                    student.value = response.data;
                    loading.value = false;
                    // Initialize DataTable after the data is loaded
                    nextTick(() => {
                        initializeDataTable();
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function initializeDataTable() {
            // Destroy any previous DataTable instance to avoid reinitialization issues
            if ($.fn.dataTable.isDataTable('#gradesTable')) {
                $('#gradesTable').DataTable().destroy();
            }

            // Initialize DataTable again with the correct options
            $('#gradesTable').DataTable({
                paging: true, // Enable pagination
                searching: true, // Enable search
                ordering: true, // Enable sorting
                pageLength: 5, // Set default page length
                language: {
                    paginate: {
                        previous: 'قبلی',
                        next: 'بعدی',
                    },
                },
            });
        }

        onMounted(() => {
            getUser();
        });

        return { student, loading };
    },

    methods: {
        deleteGrade(gradeId) {
            axios.delete(`/api/grades/${gradeId}`)
                .then(response => {
                    console.log('Grade deleted', response.data);
                    // بعد از حذف موفق، می‌توانید جدول را بروزرسانی کنید
                })
                .catch(error => {
                    console.log('Error deleting grade', error);
                });
        },
        getGradeStatus(status) {
            switch (status) {
                case "passed":
                    return "قطعی";
                case "incomplete":
                    return "در حال بررسی";
                case "pending":
                default:
                    return "اعلام شده";
            }
        },
    },

    computed: {
        averageGrade() {
            if (!this.student || !this.student.grades) return null;

            const validGrades = this.student.grades.filter(
                (grade) => typeof grade.grade === "number" && grade.course?.credit
            );

            const totalCredits = validGrades.reduce((sum, grade) => sum + grade.course.credit, 0);
            const totalWeightedGrades = validGrades.reduce(
                (sum, grade) => sum + grade.grade * grade.course.credit,
                0
            );

            return totalCredits ? (totalWeightedGrades / totalCredits).toFixed(2) : null;
        },
    },
};
</script>

<style scoped>
/* DataTables Styling */
table.dataTable {
    width: 100%;
    border-collapse: collapse;
}

.dataTables_paginate {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
}
</style>

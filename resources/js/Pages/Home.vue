<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem
                    totam, ratione, voluptas eveniet soluta incidunt itaque optio beatae
                    id temporibus, ex exercitationem sint ad earum in sed? Quam, cum sunt.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem
                    totam, ratione, voluptas eveniet soluta incidunt itaque optio beatae
                    id temporibus, ex exercitationem sint ad earum in sed? Quam, cum sunt.
                </p>

                <router-link class="btn btn-dark" :to="{name:'users'}">Users</router-link>
                <router-link class="btn btn-light ms-3" :to="{name:'posts'}">Posts</router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style>
</style>



<!--<template>-->
<!--    &lt;!&ndash; grades Table &ndash;&gt;-->
<!--    <div class="table-responsive p-3">-->
<!--        <div class="p-3 border bg-light mb-3">-->
<!--            <div class="row g-3 information-student">-->
<!--                <div class="col-md-10">-->
<!--                    <div class="row g-2">-->
<!--                        <div class="col-md-4 d-flex align-items-center gap-3 flex-nowrap">-->
<!--                            <label class="form-label text-nowrap">نام:</label>-->
<!--                            <div class="form-control input-style ">{{ student?.user.first_name}}</div>-->
<!--                        </div>-->
<!--                        <div class="col-md-4 d-flex align-items-center gap-3 flex-nowrap">-->
<!--                            <label class="form-label text-nowrap">شماره دانشجویی:</label>-->
<!--                            <div class="form-control input-style ">{{student?.student_number}}</div>-->
<!--                        </div>-->
<!--                        <div class="col-md-4 d-flex align-items-center gap-3 flex-nowrap">-->
<!--                            <label class="form-label text-nowrap">دانشکده:</label>-->
<!--                            <div class="form-control input-style ">{{ student?.faculty.name }}</div>-->
<!--                        </div>-->
<!--                        <div class="col-md-4 d-flex align-items-center gap-3 flex-nowrap">-->
<!--                            <label class="form-label text-nowrap">نام خانوادگی:</label>-->
<!--                            <div class="form-control input-style ">{{ student?.user.last_name }}</div>-->
<!--                        </div>-->
<!--                        <div class="col-md-4 d-flex align-items-center gap-3 flex-nowrap">-->
<!--                            <label class="form-label text-nowrap">رشته:</label>-->
<!--                            <div class="form-control input-style ">{{student?.major}}</div>-->
<!--                        </div>-->
<!--                        <div class="col-md-4 d-flex align-items-center gap-3 flex-nowrap">-->
<!--                            <label class="mb-0 text-nowrap">گروه آموزشی:</label>-->
<!--                            <div class="form-control input-style ">{{student?.department.name}}</div>-->
<!--                        </div>-->
<!--                    </div>-->


<!--                </div>-->
<!--                <div class="col-md-2 text-center image-user">-->
<!--                    <img src="build/assets/icons/user-image.png" alt="عکس دانشجو" class="img-thumbnail rounded"/>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <table class="table table-bordered text-center align-middle">-->
<!--            <thead class="table-secondary">-->
<!--            <tr class="w-100 p-1">-->
<!--                <th>#</th>-->
<!--                <th>کد درس</th>-->
<!--                <th>نام درس</th>-->
<!--                <th>واحد</th>-->
<!--                <th>نمره</th>-->
<!--                <th>وضعیت نمره</th>-->
<!--                <th>استاد</th>-->
<!--                <th>توضیحات</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr v-for="(grade,index) in student?.grades || []" :key="index">-->
<!--                <td>{{index}}</td>-->
<!--                <td>{{ grade.course.course_code }}</td>-->
<!--                <td>{{ grade.course.title }}</td>-->
<!--                <td>{{ grade.course.credit }}</td>-->
<!--                <td>{{ grade.grade }}</td>-->
<!--                <td>{{ getGradeStatus(grade.status) }}</td>-->
<!--                <td>{{ grade.teacher?.user.first_name }} {{ grade.teacher?.user.last_name }}</td>-->
<!--                <td>{{ grade.description || '-' }}</td>-->
<!--            </tr>-->
<!--            </tbody>-->
<!--        </table>-->
<!--        <div class="text-end fw-bold mt-3">-->
<!--            معدل نرم: {{ averageGrade }}-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--    data() {-->
<!--        return {-->
<!--            student: null,-->
<!--        };-->
<!--    },-->
<!--    mounted() {-->
<!--        this.fetchStudent();-->
<!--    },-->
<!--    methods: {-->
<!--        async fetchStudent() {-->
<!--            try {-->
<!--                const response = await fetch(`/api/student/1/grades`);-->
<!--                const data = await response.json();-->
<!--                this.student = data;-->
<!--            } catch (error) {-->
<!--                console.error("خطا در دریافت اطلاعات:", error);-->
<!--            }-->
<!--        },-->
<!--        getGradeStatus(status) {-->
<!--            switch (status) {-->
<!--                case "passed":-->
<!--                    return "قطعی";-->
<!--                case "incomplete":-->
<!--                    return "در حال بررسی";-->
<!--                case "pending":-->
<!--                default:-->
<!--                    return "اعلام شده";-->
<!--            }-->
<!--        }-->
<!--    }-->
<!--    ,-->
<!--    computed: {-->
<!--        averageGrade() {-->
<!--            if (!this.student || !this.student.grades) return null;-->

<!--            const validGrades = this.student.grades.filter(-->
<!--                (grade) => typeof grade.grade === "number" && grade.course?.credit-->
<!--            );-->

<!--            const totalCredits = validGrades.reduce((sum, grade) => sum + grade.course.credit, 0);-->
<!--            const totalWeightedGrades = validGrades.reduce(-->
<!--                (sum, grade) => sum + grade.grade * grade.course.credit,-->
<!--                0-->
<!--            );-->

<!--            return totalCredits ? (totalWeightedGrades / totalCredits).toFixed(2) : null;-->
<!--        },-->
<!--    },-->

<!--};-->

<!--</script>-->

<!--<style scoped>-->
<!--tbody, thead {-->
<!--    border: 1px solid #EAEDEF;-->
<!--}-->

<!--tr {-->
<!--    width: 100%;-->
<!--}-->

<!--td {-->
<!--    border-right: 1px solid #EEEFF0;-->
<!--}-->

<!--tbody tr:nth-child(odd) {-->
<!--    background-color: #F2F2F2;-->
<!--}-->

<!--tbody, thead, tr, td {-->
<!--    text-align: center;-->
<!--}-->
<!--.input-style {-->
<!--    background: #D9D9D9;-->
<!--    outline: none !important;-->
<!--    border: 1px solid #00000066;-->
<!--    height: 32px;-->
<!--    border-radius: 5px;-->
<!--    width: 220px;-->
<!--}-->

<!--.image-user {-->
<!--    width: 106px;-->
<!--    height: 147px;-->
<!--    top: 90px;-->
<!--    left: 73px-->
<!--}-->

<!--.information-student {-->
<!--    height: 154px;-->
<!--    width: 1304px;-->
<!--    top: 83px;-->
<!--    left: 49px;-->
<!--    border-radius: 10px;-->
<!--    background-color: #FFFFFFCC;-->
<!--    opacity: 80%-->
<!--}-->
<!--</style>-->

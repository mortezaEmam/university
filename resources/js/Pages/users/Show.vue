<template>

  <div v-if="loading" class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
  <!-- Grades Table -->
  <div class="table-responsive p-3">
    <div class="p-3 border bg-light mb-3">
      <div class="row g-3 information-student">
        <div class="col-md-10">
          <div class="row g-2">
            <div class="col-md-4">
              <div class="d-flex align-items-center">
                <label class="form-label fixed-label text-nowrap">نام:</label>
                <div class="form-control input-style flex-grow-1">{{ student?.user.first_name }}</div>
              </div>
            </div>  <div class="col-md-4">
            <div class="d-flex align-items-center">
              <label class="form-label fixed-label text-nowrap">شماره دانشجویی:</label>
              <div class="form-control input-style flex-grow-1">{{student?.student_number}}</div>
            </div>
          </div>  <div class="col-md-4">
            <div class="d-flex align-items-center">
              <label class="form-label fixed-label text-nowrap">دانشکده:</label>
              <div class="form-control input-style flex-grow-1">{{ student?.faculty.name }}</div>
            </div>
          </div>  <div class="col-md-4">
            <div class="d-flex align-items-center">
              <label class="form-label fixed-label text-nowrap">نام خانوادگی:</label>
              <div class="form-control input-style flex-grow-1">{{ student?.user.last_name }}</div>
            </div>
          </div>
            <div class="col-md-4">
              <div class="d-flex align-items-center">
                <label class="form-label fixed-label text-nowrap">رشته:</label>
                <div class="form-control input-style flex-grow-1">{{student?.major}}</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="d-flex align-items-center">
                <label class="form-label fixed-label text-nowrap">گروه آموزشی:</label>
                <div class="form-control input-style flex-grow-1">{{student?.department.name}}</div>
              </div>
            </div>
          </div>


        </div>
        <div class="col-md-1 text-center image-user align-content-end">
          <img src="/assets/icons/user-image.png" alt="عکس دانشجو" class="img-thumbnail rounded"/>
        </div>
      </div>
    </div>
    <table class="table table-bordered text-center align-middle">
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
      </tr>
      </thead>
      <tbody>
      <tr v-for="(grade,index) in student?.grades || []" :key="index">
        <td>{{index}}</td>
        <td>{{ grade.course.course_code }}</td>
        <td>{{ grade.course.title }}</td>
        <td>{{ grade.course.credit }}</td>
        <td>{{ grade.grade }}</td>
        <td>{{ getGradeStatus(grade.status) }}</td>
        <td>{{ grade.teacher?.user.first_name }} {{ grade.teacher?.user.last_name }}</td>
        <td>{{ grade.description || '-' }}</td>
      </tr>
      </tbody>
    </table>
    <!-- معدل پایین جدول -->
    <div class="row mt-3">
      <div class="col-md-4 d-flex align-items-center gap-3 flex-nowrap justify-content-end ms-auto">
        <label class="form-label text-nowrap">معدل نرم:</label>
        <div class="form-control input-style ">{{ averageGrade }}</div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
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
          })
          .catch(function (error) {
            console.log(error);
          });
    }

    getUser();

    return { student, loading };
  },
  methods: {
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
    }
  }
  ,
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
tbody, thead {
  border: 1px solid #EAEDEF;
}

tr {
  width: 100%;
}

td {
  border-right: 1px solid #EEEFF0;
}

tbody tr:nth-child(odd) {
  background-color: #F2F2F2;
}

tbody, thead, tr, td {
  text-align: center;
}
.fixed-label {
  width: 80px;
  text-align: right;
  margin-left: 10px;
}

.input-style {
  background: #D9D9D9;
  outline: none !important;
  border: 1px solid #00000066;
  height: 32px;
  border-radius: 5px;
}


.image-user {
  width: 106px;
  height: 147px;
  top: 90px;
  left: 35px
}

.information-student {
  height: 154px;
  width: 1304px;
  top: 83px;
  left: 49px;
  border-radius: 10px;
  background-color: #FFFFFFCC;
  opacity: 80%
}

label.form-label {
  min-width: 80px;
  text-align: right;
  margin-bottom: 0;
}

</style>

<template>
  <div>
    <!-- Loading Spinner -->
    <div v-if="loading" class="spinner-border text-primary" role="status">
      <span class="visually-hidden">در حال بارگذاری...</span>
    </div>

    <!-- Student Information Card -->
    <div class="student-info-card" v-if="!loading">
      <!--      <div class="student-info-header">-->
      <!--        <h5>اطلاعات دانشجو</h5>-->
      <!--      </div>-->
      <div class="student-info-body">
        <div class="row g-2">
          <div class="col-md-10">
            <div class="row" style="padding: 14px">
              <div class="col-md-4 mb-3">
                <div class="info-field">
                  <span class="info-label">نام:</span>
                  <span class="info-value">{{ student?.user.first_name }}</span>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="info-field">
                  <span class="info-label">رشته:</span>
                  <span class="info-value">{{ student?.major }}</span>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="info-field">
                  <span class="info-label">دانشکده:</span>
                  <span class="info-value">{{ student?.faculty.name }}</span>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="info-field">
                  <span class="info-label">نام خانوادگی:</span>
                  <span class="info-value">{{ student?.user.last_name }}</span>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <div class="info-field">
                  <span class="info-label">شماره دانشجویی:</span>
                  <span class="info-value">{{ student?.student_number }}</span>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <div class="info-field">
                  <span class="info-label">گروه آموزشی:</span>
                  <span class="info-value">{{ student?.department.name }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-2 student-photo">
<!--            <div class="">-->
              <img :src="student?.user.profile_image || '/assets/icons/user-image.png'"
                   alt="عکس دانشجو"
                   class="img-thumbnail" />
<!--            </div>-->
          </div>
        </div>
      </div>
    </div>

    <!-- Grades Table -->
    <div class="grades-table-container" v-if="!loading">
      <!--      <div class="table-header">-->
      <!--        <h5>کارنامه تحصیلی</h5>-->
      <!--      </div>-->
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-header-bg">
          <tr>
            <th width="5%">#</th>
            <th width="10%">کد درس</th>
            <th width="25%">نام درس</th>
            <th width="8%">واحد</th>
            <th width="10%">نمره</th>
            <th width="15%">وضعیت نمره</th>
            <th width="17%">استاد</th>
            <th width="10%">توضیحات</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(grade, index) in student?.grades || []" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ grade.course.course_code }}</td>
            <td>{{ grade.course.title }}</td>
            <td>{{ grade.course.credit }}</td>
            <td>{{ grade.grade }}</td>
            <td :class="getStatusClass(grade.status)">
              {{ getGradeStatus(grade.status) }}
            </td>
            <td>{{ grade.teacher?.user.first_name }} {{ grade.teacher?.user.last_name }}</td>
            <td>{{ grade.description || '-' }}</td>
          </tr>
          </tbody>
        </table>
      </div>

      <!-- GPA Section -->
      <div class="gpa-section">
        <div class="gpa-box">
          <span class="gpa-label">معدل نرم:</span>
          <span class="gpa-value">{{ averageGrade }}</span>
        </div>
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
            loading.value = false;
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
    },
    getStatusClass(status) {
      switch (status) {
        case "passed":
          return "status-passed";
        case "incomplete":
          return "status-incomplete";
        case "pending":
        default:
          return "status-pending";
      }
    }
  },
  computed: {
    averageGrade() {
      if (!this.student || !this.student.grades) return "---";

      const validGrades = this.student.grades.filter(
          (grade) => typeof grade.grade === "number" && grade.course?.credit
      );

      if (validGrades.length === 0) return "---";

      const totalCredits = validGrades.reduce((sum, grade) => sum + grade.course.credit, 0);
      const totalWeightedGrades = validGrades.reduce(
          (sum, grade) => sum + grade.grade * grade.course.credit,
          0
      );

      return totalCredits ? (totalWeightedGrades / totalCredits).toFixed(2) : "---";
    },
  },
};
</script>

<style scoped>
body {
  font-family: 'Inter', sans-serif;
  font-weight: 500;
  font-size: 15px;
  line-height: 100%;
  letter-spacing: 0%;
}
.student-grade-report {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-bottom: 30px;
}

/* Student Info Card */
.student-info-card {
  height: 154px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  margin-bottom: 25px;
  background-color: #f9f9f9;
}

.student-info-header {
  background-color: #3f51b5;
  color: white;
  padding: 12px 20px;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
}

.student-info-header h5 {
  margin: 0;
  font-size: 18px;
}

.student-info-body {
  height: 154px;
  top: 83px;
  left: 49px;
  border-radius: 10px;

}
.info-field {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.info-label {
  font-weight: bold;
  min-width: 100px; /* قبلاً 120 بود */
  color: #555;
  margin-left: 6px; /* قبلاً 10px بود */
  flex-shrink: 0;
  text-align: left;
}

.info-value {
  background-color: #f0f0f0;
  padding: 8px 12px;
  border-radius: 5px;
  flex-grow: 1;
  width: 100%;
  border: 1px solid #ddd;
}


.student-photo {
  text-align: center;
  padding: 10px;
}

.student-photo img {
  width: 106px;
  height: 147px;
  border: 1px solid #ddd;
  background-color: #fff;
  top: 90px;
  left: 73px;
}

.photo-label {
  margin-top: 8px;
  font-size: 14px;
  color: #666;
}

/* Grades Table */
.grades-table-container {
  margin-top: 20px;
}

.table-header {
  background-color: #3f51b5;
  color: white;
  padding: 12px 20px;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
  margin-bottom: 0;
}

.table-header h5 {
  margin: 0;
  font-size: 18px;
}

.table-header-bg {
  background-color: #f5f5f5;
}

.table {
  margin-bottom: 0;
}

.table th {
  text-align: center;
  vertical-align: middle;
  font-weight: bold;
  background-color: #f8f9fa;
}

.table td {
  vertical-align: middle;
}

/* Status Classes */
.status-passed {
  color: #28a745;
  font-weight: bold;
}

.status-pending {
  color: #ffc107;
  font-weight: bold;
}

.status-incomplete {
  color: #dc3545;
  font-weight: bold;
}

/* GPA Section */
.gpa-section {
  margin-top: 20px;
  text-align: left;
}

.gpa-box {
  display: inline-block;
  padding: 10px 20px;
  background-color: #e9f7ef;
  border-radius: 5px;
  border: 1px solid #c3e6cb;
}

.gpa-label {
  font-weight: bold;
  margin-left: 10px;
}

.gpa-value {
  font-weight: bold;
  color: #28a745;
  font-size: 18px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .info-field {
    flex-direction: column;
    align-items: flex-start;
  }

  .info-label {
    margin-bottom: 5px;
    margin-left: 0;
  }

  .student-photo {
    margin-top: 20px;
  }
}
</style>

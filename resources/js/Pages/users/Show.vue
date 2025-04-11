<template>
  <div>
    <!-- Loading Spinner -->
    <div v-if="loading" class="spinner-border text-primary" role="status">
      <span class="visually-hidden">در حال بارگذاری...</span>
    </div>

    <!-- Student Information Card -->
    <div class="student-info-card" v-if="!loading">
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
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-header-bg">
          <tr>
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
            <td>{{ grade.comments || '-' }}</td>
            <td>
              <button
                  v-if="grade.status !== 'passed'"
                  @click="editGrade(grade)"
                  class="btn btn-sm btn-primary me-1"
              >
                ویرایش
              </button>
              <button
                  v-if="grade.status !== 'passed'"
                  @click="deleteGrade(grade.id)"
                  class="btn btn-sm btn-danger"
              >
                حذف
              </button>
            </td>

          </tr>
          </tbody>
        </table>
      </div>

      <!-- GPA Section -->
      <div class="gpa-section">
        <div class="gpa-box">
          <span class="gpa-label">معدل ترم:</span>
          <span class="gpa-value">{{ averageGrade }}</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Grade Modal -->
  <div v-if="editingGrade" class="modal-backdrop">
    <div class="modal-content-box">
      <h5>ویرایش نمره</h5>
      <div class="mb-2">
        <label>نمره:</label>
        <input type="number" v-model="editingGrade.grade" class="form-control" />
      </div>
      <div class="mb-2">
        <label>وضعیت:</label>
        <select v-model="editingGrade.status" class="form-control">
          <option value="finalized">قطعی</option>
          <option value="pending">در حال بررسی</option>
          <option value="reviewing">اعلام شده</option>
        </select>
      </div>
      <div class="mb-2">
        <label>توضیحات:</label>
        <textarea v-model="editingGrade.description" class="form-control" rows="3" />
      </div>
      <div class="d-flex justify-content-end">
        <button class="btn btn-secondary me-2" @click="editingGrade = null">بستن</button>
        <button class="btn btn-success" @click="updateGrade">ثبت تغییرات</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import Swal from "sweetalert2";

export default {
  setup() {
    const student = ref({});
    const loading = ref(true);
    const route = useRoute();
    const editingGrade = ref(null);

    const getUser = () => {
      axios
          .get(`/api/students/${route.params.user}/grades`)
          .then((response) => {
            student.value = response.data;
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            loading.value = false;
          });
    };


    const updateGrade = () => {
      if (!editingGrade.value) return;

      const studentId = route.params.user;
      const gradeId = editingGrade.value.id;

      const payload = {
        grade: editingGrade.value.grade,
        status: editingGrade.value.status,
        description: editingGrade.value.description || null,
      };

      axios.put(`/api/students/${studentId}/grades/${gradeId}`, payload)
          .then(() => {
            getUser();
            editingGrade.value = null;
            Swal.fire({
              title: "متشکرم!",
              text: "نمره دانشجو با موفقیت ویرایش شد",
              icon: "success",
              confirmButtonText: "Ok",
            });
          });
    };

    const deleteGrade = (gradeId) => {
      const studentId = route.params.student;

      if (confirm('آیا از حذف این نمره مطمئن هستید؟')) {
        axios.delete(`/api/students/${studentId}/grades/${gradeId}`)
            .then(() => {
              fetchStudentGrades();
            });
      }
    };


    const editGrade = (grade) => {
      editingGrade.value = { ...grade };
    };

    const getGradeStatus = (status) => {
      switch (status) {
        case "finalized":
          return "قطعی";
        case "pending":
          return "در حال بررسی";
        case "reviewing":
        default:
          return "اعلام شده";
      }
    };

    const getStatusClass = (status) => {
      switch (status) {
        case "finalized":
          return "status-passed";
        case "reviewing":
          return "status-incomplete";
        case "pending":
        default:
          return "status-pending";
      }
    };

    const averageGrade = computed(() => {
      if (!student.value.grades) return "---";

      const validGrades = student.value.grades.filter(
          (grade) =>
              typeof grade.grade === "number" && grade.course?.credit
      );

      if (validGrades.length === 0) return "---";

      const totalCredits = validGrades.reduce(
          (sum, grade) => sum + grade.course.credit,
          0
      );
      const totalWeightedGrades = validGrades.reduce(
          (sum, grade) => sum + grade.grade * grade.course.credit,
          0
      );

      return totalCredits
          ? (totalWeightedGrades / totalCredits).toFixed(2)
          : "---";
    });

    onMounted(getUser);

    return {
      student,
      loading,
      editingGrade,
      editGrade,
      updateGrade,
      deleteGrade,
      getGradeStatus,
      getStatusClass,
      averageGrade,
    };
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
  background-color: #FFFFFFCC;
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
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content-box {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
}

</style>

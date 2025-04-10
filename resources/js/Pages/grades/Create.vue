<template>
    <div>
        <form @submit.prevent="createGrade">
            <div>
                <label>کد درس</label>
                <input v-model="newGrade.course_code" type="text" required />
            </div>
            <div>
                <label>نام درس</label>
                <input v-model="newGrade.title" type="text" required />
            </div>
            <div>
                <label>واحد</label>
                <input v-model="newGrade.credit" type="number" required />
            </div>
            <button type="submit">ایجاد درس جدید</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            newGrade: {
                course_code: '',
                title: '',
                credit: 0,
            }
        };
    },
    methods: {
        createGrade() {
            axios.post('/api/grades', this.newGrade)
                .then(response => {
                    console.log('Grade created', response.data);
                    // بعد از ایجاد موفق، می‌توانید جدول را بروزرسانی کنید
                })
                .catch(error => {
                    console.log('Error creating grade', error);
                });
        }
    }
};
</script>

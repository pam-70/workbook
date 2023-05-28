<template>
  <div class="row">
    <div class="col-md-8">
      <div class="text">
        Ученик школы {{ data_student.school }} класс
        {{ data_student.klass }} номер {{ data_student.numer }} логин
        {{ data_student.name }}
      </div>
    </div>

    <div class="col-md-4">
      <div class="butv">
        <button
          @click="exit_user()"
          type="button"
          class="btn btn-outline-danger"
        >
          ВЫХОД
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    data_student: "",
  },
  data: function () {
    return {
      id_student: 0,
    };
  },

  mounted() {
    this.update();
    // axios.post("/all_quest").then((response) => {
    // this.all_quest = response.data.url_all_quest;
    // this.percent = response.data.url_percent;
    // });
  },
  methods: {
    update: function () {
      //this.formatdate();
      //  data_p={
      //    ds:34,
      //   };
      // axios.post("/updatestudent").then((response) => {
      //   console.log((this.name = response.data.name));
      //   // this.summar_id = response.data.url_summar_id;
      //   // this.list = response.data.url_odin_quest; // массив вопросов
      //   //this.answer = response.data.url_answer;
      // });
    },
    exit_user: function () {
      this.$emit("exit_user");
      //this.$router.push('www.pamgm.ru')
    },
  },
};
</script>

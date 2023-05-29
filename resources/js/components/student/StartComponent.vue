<template >
  <div v-if="formkontrol == 0" class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <label  class="form-label"
          >Введите номер задания</label
        >
        <label  class="form-label"
          > <font size="3" color="red"><b>{{notest}}</b></font></label
        >
        <input v-model=test_numer type="text" class="form-control" id="numer" />
      </div>
    </div>

    <div class="col-md-4">
      <div v-if="test_numer" class="mb-3">
        <label  class="form-label"
          >Начать выполнение задания</label
        >
        <p>
          <button  type="submit" class="btn btn-primary" @click="start()">
            Выполнить
          </button>
        </p>
      </div>
    </div>
    <div class="col-md-4">
      <div  class="mb-3">
        <label  class="form-label"
          >Просмотреть выполненных заданий</label
        >
        <p>
          <button type="submit" class="btn btn-info">Просмотреть</button>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    numer_testa: "",
    formkontrol: "",
    notest:"",
  },
  data: function () {
    return {
      //numer_testa: 353535353, //исправить на ноль после отладки номер вопроса самая основная переменная
      counter: 100,
      test_numer:"",
    };

  },

  mounted() {
   // console.log("Component mounted.");
  },
  methods: {
    update: function () {
      this.formatdate();
    },
    start: function () {

      this.$emit("start_test", this.test_numer);
      this.test_numer="";
    },
  },
};
</script>

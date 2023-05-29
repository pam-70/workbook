<template>
  <div v-if="formkontrol == -1">
    <div class="row g-2">
      <div class="col-md-12">
        <div class="p-3 border bg-light">
          <div class="row">
            <div class="col-md-10">
              <div class="text">
                <div v-if="mark === 2">
                  <font size="4" color="#000000"><b> Задание {{numer_testa}} выполненно на {{ mark }}</b></font>
                </div>
                <div v-if="mark === 3">
                  <font size="4" color="#4B0082"><b> Задание {{numer_testa}} выполненно на {{ mark }}</b></font>
                </div>
                <div v-if="mark === 4">
                  <font size="4" color="#008000"><b> Задание {{numer_testa}} выполненно на {{ mark }}</b></font>
                </div>
                <div v-if="mark === 5">
                  <font size="4" color="#FF0000"><b> Задание {{numer_testa}} выполненно на {{ mark }}</b></font>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="butv">
                <button @click="exit_view()" type="button" class="btn btn-outline-danger">
                  Закончить просмотр
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    formkontrol: "",
    mark: "",
    prozent: "",
    numer_testa: "",
  },
  mounted() {
    //console.log("Component mounted.");
  },
  methods: {
    exit_view: function () {
      this.$emit("exit_view");


    },
  },
};
</script>

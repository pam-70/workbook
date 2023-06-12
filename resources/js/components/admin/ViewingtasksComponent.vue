<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Просмотр результатов учащихся</div>
          <div class="card-header">
            <div class="container">
              <div class="row">
                <div class="col-sm-auto"></div>
                <div class="col-sm-2">
                  <input
                    class="form-control form-control-sm"
                    type="text"
                    v-model="numertest"
                    placeholder="№ задания"
                  />
                </div>
                <div class="col-sm-4">
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="alltest()"
                  >
                    Просмотреть
                  </button>
                </div>
                <div class="col">
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="allnumer()"
                  >
                    Все номера
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-11">
              <div v-for="(result, index) in all_quest" :key="result.id">
                <div class="row">
                  <font size="2"
                    ><b>
                      {{ index + 1 }} .
                      {{
                        result.t_numer +
                        " - " +
                        result.quest +
                        " (" +
                        result.id +
                        ")" +
                        result.pict
                      }}</b
                    ></font
                  >
                  <div class="row">
                    <span v-if="result.pict != ''">
                      <img
                        :src="put + result.pict"
                        class="img-thumbnail"
                      /><br />
                    </span>
                  </div>
                </div>
                <span>
                  <font color="red">{{ result.right_ansv }}</font>
                </span>
                <br />
                <li v-for="result_a in result.answer" :key="result_a.id">
                  <span v-if="result_a.meaning == 1"
                    ><font color="red">
                      {{ result_a.answer + " (" + result_a.id + ")" }}</font
                    ></span
                  >
                  <span v-else>
                    {{ result_a.answer + " (" + result_a.id + ")" }}</span
                  >
                </li>
              </div>
              <li v-for="result in all_test" :key="result.id">
                {{ result.t_numer }}
              </li>
            </div>
            <div class="col-md-1">
              <button
                type="button"
                class="btn btn-danger"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Очистить результаты"
                @click="clearform()"
              >
                X
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      all_quest: [],
      numertest: "",
      put: "pict_test/",
      all_test: "",
    };
  },
  mounted() {
    this.update();
  },
  methods: {
    update: function () {
      // axios.post("/updateadmin").then((response) => {
      //  this.all_school = response.data.school;
      //console.log(response.data);
      // });
    },

    alltest: function () {
      // вывод результатов
      // console.log("prosmotr");
      const data_post = {
        // передаем данные
        numertest: this.numertest,
      };
      axios.post("/alltest", data_post).then((response) => {
        this.all_quest = response.data.result;
        // console.log(response.data.result);
      });
    },
    allnumer: function () {
      axios.post("/allnumer").then((response) => {
        this.all_test = response.data.result;
        // console.log(response.data.result);
      });
    },
    clearform: function () {
      this.all_quest = "";
      this.all_test = "";
    },
  },
};
</script>

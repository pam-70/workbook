<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Просмотр результатов учащихся</div>
          <div class="card-header">
            <div class="container">
              <div class="row">
                <div class="col-sm-auto">
                  <select
                    id="selectschool"
                    v-model="selected"
                    @mouseup="filtrklass()"
                  >
                    <option
                      :value="school.id"
                      v-for="school in all_school"
                      :key="school.id"
                    >
                      {{ school.nameschool }}
                    </option>
                  </select>
                  <select v-model="selected_klass">
                    <option
                      :value="klass.id"
                      v-for="klass in all_klass"
                      :key="klass.id"
                    >
                      {{ klass.nameklass }}
                    </option>
                  </select>
                </div>
                <div class="col-sm-2">
                  <input
                    class="form-control form-control-sm"
                    type="text"
                    v-model="numertest"
                    placeholder="№ задания"
                  />
                </div>
                <div class="col-sm-2">
                  <input
                    class="form-control form-control-sm"
                    type="text"
                    v-model="numerstudent"
                    placeholder="№ ученика"
                  />
                </div>
                <div class="col">
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="outputresults"
                  >
                    Просмотреть
                  </button>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <input type="checkbox" id="checkbox" v-model="checkedtest" />
                  <label for="checkbox" v-if="checkedtest === false"
                    >По ученикам</label
                  >
                  <label for="checkbox" v-if="checkedtest === true"
                    >По номерам</label
                  >
                </div>
                <div class="col-sm-6">
                  <input type="radio" id="one" value="3" v-model="quarter" />
                  <label for="one">Первая</label>

                  <input type="radio" id="two" value="4" v-model="quarter" />
                  <label for="two">Вторая</label>
                  <input type="radio" id="one" value="5" v-model="quarter" />
                  <label for="one">Третья</label>

                  <input type="radio" id="two" value="6" v-model="quarter" />
                  <label for="two">Четвертая</label>
                </div>
                <div class="col"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-11">
              <div
                class="butv"
                v-for="result in allresult"
                :key="result.message"
              >
                <span v-if="(result.mark == 5)"
                  ><font color="#B32821">
                    {{
                      " Ученик  " +
                      result.numer +
                      " задание №" +
                      result.t_numer +
                      " отметка (" +
                      result.mark +
                      ")   время " +
                      new Date(result.updated_at).toLocaleString()
                    }}
                  </font>
                </span>
                <span v-if="(result.mark ==4)"
                  ><font color="#008000">
                    {{
                      " Ученик  " +
                      result.numer +
                      " задание №" +
                      result.t_numer +
                      " отметка (" +
                      result.mark +
                      ")   время " +
                      new Date(result.updated_at).toLocaleString()
                    }}
                  </font>
                </span>
                <span v-if="(result.mark == 3)"
                  ><font color="#4169E1">
                    {{
                      " Ученик  " +
                      result.numer +
                      " задание №" +
                      result.t_numer +
                      " отметка (" +
                      result.mark +
                      ")   время " +
                      new Date(result.updated_at).toLocaleString()
                    }}
                  </font>
                </span>
                <span v-if="(result.mark == 2)"
                  ><font color="#000000">
                    {{
                      " Ученик  " +
                      result.numer +
                      " задание №" +
                      result.t_numer +
                      " отметка (" +
                      result.mark +
                      ")   время " +
                      new Date(result.updated_at).toLocaleString()
                    }}
                  </font>
                </span>
              </div>
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
      all_school: [],
      all_klass: [],
      selected: "",
      selected_klass: "",
      numerstudent: "",
      numertest: "",
      allresult: "",
      checkedtest: false,
      quarter: "", //четверть
    };
  },
  mounted() {
    this.update();
  },
  methods: {
    update: function () {
      //получить данные об usere
      axios.post("/updateadmin").then((response) => {
        this.all_school = response.data.school;
      });
    },
    filtrklass: function () {
      //фильтруем классы
      const data_updat = {
        // передаем данные
        schoolid: this.selected,
      };
      if (this.selected > 0) {
        axios.post("/filtrklass", data_updat).then((response) => {
          this.all_klass = response.data.klass;
        });
      }
    },
    outputresults: function () {
      // вывод результатов
      // console.log("prosmotr");
      const data_post = {
        // передаем данные
        schoolid: this.selected,
        numerstudent: this.numerstudent,
        klassid: this.selected_klass,
        numertest: this.numertest,
        checkedtest: this.checkedtest,
        quarter: this.quarter,
      };
      if (this.selected > 0 && this.selected_klass > 0) {
        axios.post("/showresult", data_post).then((response) => {
          // this.all_klass = response.data.school;
          this.allresult = response.data.result;
          //console.log(response.data.result);
        });
      }
      // console.log(this.quarter);
      //console.log(this.selected_klass);
    },
    clearform: function () {
      this.allresult = "";
    },
  },
};
</script>

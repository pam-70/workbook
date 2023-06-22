<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Страница добавления учащихся</div>
          <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-6">
              для удаления или добавления ввести пароль
            </div>
            <div class="col-sm-2">
              <input type="checkbox" id="checkbox" v-model="checkeddel" />
              <label for="checkbox">Удалить класс</label>
            </div>
            <div class="col-sm-1">
              <button type="button" class="btn btn-danger" @click="deluser()">
                Del
              </button>
            </div>
            <div class="col-sm-1"></div>
          </div>
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
                <select v-model="selected_klass" @mouseup="filtrpassw()">
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
                  type="password"
                  v-model="password"
                  placeholder="Пароль"
                />
              </div>
              <div class="col-sm-2">
                <input
                  class="form-control form-control-sm"
                  type="text"
                  v-model="kolstudent"
                  placeholder="Кол. учеников"
                />
              </div>
              <div class="col">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="addstudent"
                >
                  Добавить
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2"></div>

              <div class="col"></div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-11">
              <div
                class="butv"
                v-for="result in user_data"
                :key="result.message"
              >
                <span>
                  {{
                    school_name+" кл "+
                    klass_name+" "+
                    " Ученик № " +
                    result.numer +
                    " логин " +
                    result.name +
                    " пароль " +
                    result.password_srtr
                  }}
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
      kolstudent: "",
      password: " ",
      password_str: "",
      user_data: "",
      allresult: "",
      checkedtest: false,
      quarter: "", //четверть
      checkeddel: false,
      school_name:"",
      klass_name:"",
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
        this.password_str = response.data.password;
      });
    },
    deluser: function () {
      const data_url = {
        // передаем данные
        klassid: this.selected_klass,
        selected: this.selected,
        checkeddel: this.checkeddel,
      };
      if (
        this.selected > 0 &&
        this.selected_klass > 0 &&
        this.checkeddel == true &&
        this.password === this.password_str
      ) {
        axios.post("/deluser", data_url).then((response) => {
          this.user_data = response.data.result;
        });
        this.filtrpassw();
        this.checkedtest= false;
        this.password_str="";
      }
    },
    filtrpassw: function (klass_id) {
      const data_url = {
        // передаем данные
        klassid: this.selected_klass,
        schoolid: this.selected,
      };

      if (this.selected > 0 && this.selected_klass > 0) {
        axios.post("/filtrpass", data_url).then((response) => {
          this.user_data = response.data.result;
          this.school_name=response.data.school_name;
          this.klass_name=response.data.klass_name;

        });
      }
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

    clearform: function () {
      this.allresult = "";
    },
    addstudent: function () {
      if (
        this.password === this.password_str &&
        this.kolstudent > 0 &&
        this.selected_klass > 0 &&
        this.selected > 0
      ) {
        const data_addst = {
          // передаем данные
          schoolid: this.selected,
          klassid: this.selected_klass,
          kolstudent: this.kolstudent,
        };

        axios.post("/addstudent", data_addst).then((response) => {});
      }
      this.filtrpassw();
      this.password = "";
    },
  },
};
</script>

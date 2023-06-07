<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <!-- Кнопка-триггер модального окна -->

      <!-- Модальное окно школы-->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div v-if="error != ''" class="container">
              <div class="row">
                <div class="alert alert-danger" role="alert">
                  {{ error }}
                </div>
              </div>
            </div>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Редактировать таблицу школы
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
              <input v-model="inputschool" class="form-control form-control-sm" type="text"
                placeholder="Необходимо выбрать школу. При редактировании" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="delschool()">
                Удалить школу
              </button>
              <button type="button" class="btn btn-primary" @click="addschool()">
                Добавть школу
              </button>
              <button type="button" class="btn btn-primary" @click="updateschool()">
                Сохранить изменения
              </button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="clearschool()">
                Закрыть
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- Модальное окно класс-->
      <div class="modal fade" id="exampleModalKl" tabindex="-1" aria-labelledby="exampleModalLabelKl" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div v-if="errorklass != ''" class="container">
              <div class="row">
                <div class="alert alert-danger" role="alert">
                  {{ errorklass }}
                </div>
              </div>
            </div>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabelKl">
                Редактировать классы
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
              <select v-model="selectedshkl">
                <option :value="school" v-for="school in all_school" :key="school.id">
                  {{ school.nameschool }}
                </option>
              </select>
              <input v-model="inputklass" class="form-control form-control-sm" type="text"
                placeholder="Необходимо выбрать класс. При редактировании" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="delklass()">
                Удалить класс
              </button>
              <button type="button" class="btn btn-primary" @click="addklass()">
                Добавть класс
              </button>
              <button type="button" class="btn btn-primary" @click="updateklass()">
                Сохранить изменения
              </button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="clearklass()">
                Закрыть
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Школы и классы</div>
          <div class="card-body">
            <div class="container">
              <div class="row">
                <div class="col-sm">
                  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    @click="editschool()">
                    Редактировать школу
                  </button>
                  <select v-model="selected" @mouseup="filtrklass()">
                    <option :value="school" v-for="school in all_school" :key="school.id">
                      {{ school.nameschool }}
                    </option>
                  </select>

                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Школа</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr scope="row" v-for="(school, index) in all_school" :key="school.id">
                        <th>{{ index + 1 }}</th>
                        <td>
                          {{ school.nameschool }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm">
                  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalKl"
                    @click="editklass()">
                    Редактировать класс
                  </button>
                  <select v-model="selected_klass">
                    <option :value="klass" v-for="klass in all_klass" :key="klass.id">
                      {{ klass.nameklass }}
                    </option>
                  </select>
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Классы</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr scope="row" v-for="(klass, index) in all_klass" :key="klass.id">
                        <th>{{ index + 1 }}</th>
                        <td>
                          {{ klass.nameklass }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: function () {
    return {
      all_school: [],
      all_klass: [],
      selected: "",
      selected_klass: [],
      selectedshkl: [],
      inputschool: "",
      klassid: "",
      klassname: "",
      inputklass: "",
      schoolid: "",
      error: "",
      errorklass: "",
    };
  },
  mounted() {
    this.update();
  },
  methods: {
    update: function () {
      //получить данные об usere
      //console.log("0000000000000000");
      // this.formatdate();
      axios.post("/updateadmin").then((response) => {
        this.all_school = response.data.school;
        this.all_klass = response.data.klass;
      });
    },
    updateklass: function () {
      if (this.inputklass == "") {
        this.errorklass = "Необходимо прежде выбрать класс";
      } else {
        // console.log("Обновление");
        const data_updat = {
          // передаем данные
          inputklass: this.inputklass,
          klassid: this.klassid,
        };
        axios.post("/updateklass", data_updat).then((response) => {
          //this.all_school = response.data.school;
          this.errorklass = response.data.klass;
          console.log(response.data.klass);
        });
        this.clearschool();
        this.update();
        this.inputschool = "";
        this.schoolid = "";
      }
    },
    clearklass: function () {
      this.inputschool = "";
      this.schoolid = "";
      this.klassname = "";
      this.inputklass = "";
      this.errorklass = "";
      this.nameklass = "";
      this.selected_klass = "";
    },
    filtrklass: function () {
      //фильтруем классы
      //console.log(this.selected.id);
      const data_updat = {
        // передаем данные
        schoolid: this.selected.id,
      };
      axios.post("/filtrklass", data_updat).then((response) => {
        this.all_klass = response.data.klass;
      });
    },
    addklass: function () {
      //добавление школы
      console.log(this.selectedshkl.nameschool);
      if (this.selectedshkl.nameschool != "undefined" ) {
        this.errorklass = "Необходимо написать название класса или выбрать школу";
        console.log("iiiii");
      } else {
        // const data_add = {
        //   // передаем данные
        //   schoolid: this.selected.id,
        // };
        // axios.post("/addschool", data_add).then((response) => {
        //   //this.all_school = response.data.school;
        //   console.log(response.data);
        // });
        // this.clearschool();
        // this.update();
        // this.error = "Школа добавлена.";
        console.log("0000000");
      }
    },
    updateschool: function (school_id) {
      //обновление названия школы
      if (this.inputschool == "") {
        this.error = "Необходимо прежде выбрать школу";
      } else {
        console.log("Обновление");
        const data_updat = {
          // передаем данные
          inputschool: this.inputschool,
          schoolid: this.schoolid,
        };
        axios.post("/updateschool", data_updat).then((response) => {
          //this.all_school = response.data.school;
          console.log(response.data.school);
        });
        this.clearschool();
        this.update();
        this.error = "Данные обновлены.";
        this.inputschool = "";
        this.schoolid = "";
      }
    },
    delschool: function () {
      //удаление школы из списка
      if (this.inputschool === "") {
        this.error = "Необходимо прежде выбрать школу";
      } else {
        const data_add = {
          // передаем данные
          schoolid: this.schoolid,
        };
        axios.post("/delschool", data_add).then((response) => {
          //this.all_school = response.data.school;
          console.log(response.data);
        });
        this.clearschool();
        this.update();
        this.error = "Школа успешно удалена.";
        this.inputschool = "";
        this.schoolid = "";
      }
    },
    addschool: function () {
      //добавление школы
      if (this.inputschool.trim() === "") {
        this.error = "Необходимо написать название школы";
      } else {
        const data_add = {
          // передаем данные
          inputschool: this.inputschool,
        };
        axios.post("/addschool", data_add).then((response) => {
          //this.all_school = response.data.school;
          console.log(response.data);
        });
        this.clearschool();
        this.update();
        this.error = "Школа добавлена.";
      }
    },
    clearschool: function () {
      this.inputschool = "";
      this.schoolid = "";
      this.error = "";
      this.selected = "";
    },
    editschool: function () {
      //console.log(this.selected.nameschool);
      if (this.selected.nameschool === undefined) {
        this.inputschool = "";
      } else {
        this.inputschool = this.selected.nameschool;
      }
      this.schoolid = this.selected.id;
    },
    editklass: function () {
      this.klassid = this.selected_klass.id;
      this.klassname = this.selected_klass.nameklass;
      this.inputklass = this.selected_klass.nameklass;
    },
    clicselekt: function (ert) {
      console.log(ert);
      console.log("88888888888888");
    },
  },
};
</script>

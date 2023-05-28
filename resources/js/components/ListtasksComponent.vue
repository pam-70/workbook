<template>
  <div class="container-fluid">
    <div class="container px-20">
      <div class="row gx-5">
        <div class="col-sm">
          <div>
            <div
              v-if="!addform"
              class="d-grid gap-2 d-md-flex justify-content-md-end"
            >
              <div class="container">
                <div class="row">
                  <div class="col-sm">Добавление заданий</div>
                </div>
              </div>
              <button
                type="button"
                style="font: bold 18px Arial"
                text-align="right"
                :title="titlbutton"
                :class="classbutton"
                @click="addlist()"
              >
                {{ titbutton }}
              </button>
            </div>
            Просмотр заданий
            <div style="height: 600px; background-color: rgba(0, 0, 0, 0)">
              <table class="table table-bordered border-primary">
                <tr bgcolor="#fff8dc" align="center">
                  <td>
                    <font size="2" color="darkblue" face="Arial">id</font>
                  </td>
                  <td>
                    <font size="2" color="darkblue" face="Arial">Название</font>
                  </td>
                  <td><font size="2" color="darkblue" face="Arial">№</font></td>
                  <td>
                    <font size="2" color="darkblue" face="Arial">Класс</font>
                  </td>
                  <td>
                    <font size="2" color="darkblue" face="Arial"
                      >Время выполнения</font
                    >
                  </td>
                  <td>
                    <font size="2" color="darkblue" face="Arial"
                      >Количество вопросов</font
                    >
                  </td>
                  <td>
                    <font size="2" color="darkblue" face="Arial"
                      >Назначение</font
                    >
                  </td>
                </tr>
                <tr v-for="listques in listquest" :key="listques.id">
                  <td>
                    <span @click="editlist(listques.id)">{{
                      listques.id
                    }}</span>
                  </td>
                  <td>{{ listques.name }}</td>
                  <td>{{ listques.numer }}</td>
                  <td>{{ listques.klass }}</td>
                  <td>{{ listques.time }}</td>
                  <td>{{ listques.num_quest }}</td>
                  <td>{{ listques.purpose }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="col-sm">
          <div>
            <div>
              <div
                v-if="addform"
                class="d-grid gap-2 d-md-flex justify-content-md-end"
              >
                <div class="container">
                  <div class="row">
                    <div class="col-sm">Добавление списка заданий</div>
                  </div>
                </div>
                <button
                  type="button"
                  style="font: bold 18px Arial"
                  text-align="right"
                  :title="titlbutton"
                  :class="classbutton"
                  @click="addlist()"
                >
                  {{ titbutton }}
                </button>
              </div>

              <div v-if="addform" class="card-body">
                <div class="row">
                  <div class="mb-3">
                    <label class="form-label">Название задания</label>
                    <input
                      v-model.trim="nametask"
                      type="text"
                      class="form-control"
                    />
                    <label class="form-label">Номер задания</label>
                    <input
                      v-model.number="numertask"
                      type="text"
                      class="form-control"
                    />
                    <label class="form-label">Для какого класса задание</label>
                    <p>
                      <select
                        v-model="klass"
                        class="form-select form-select-lg mb-3"
                        aria-label=".form-select-lg пример"
                      >
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                      </select>
                    </p>
                    <label class="form-label"
                      >Время выполнения задания (в минутах)</label
                    >
                    <input
                      v-model.number="timetask"
                      type="text"
                      class="form-control"
                    />
                    <label class="form-label">Количество вопросов</label>
                    <input
                      v-model.number="quanttask"
                      type="text"
                      class="form-control"
                    />
                    <label class="form-label"
                      >Назначение задания годовая или полугодовая или учебный
                      процесс</label
                    >
                    <input
                      v-model.trim="periodtask"
                      type="text"
                      class="form-control"
                    />

                    <div class="mb-3"></div>

                    <div class="container px-4">
                      <div class="row gx-5">
                        <div class="col">
                          <button
                            type="button"
                            class="btn btn-primary"
                            style="font: bold 18px Arial"
                            @click="addtask()"
                          >
                            {{ namebutton }}
                          </button>
                        </div>
                      </div>
                    </div>

                    <div class="demo-alert-box">
                      <strong v-if="!errormess == ''"
                        ><font color="red" size="2"
                          >Неверно ввели: {{ errormess }}
                        </font></strong
                      >
                      <slot></slot>
                    </div>
                  </div>
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
  mounted() {
    console.log("Component mounted.");
  },
  data: function () {
    return {
      counter: 100,
      polling: null,
      minutes: 0,
      seconds: 0,
      //formatted: "00:00",
      addform: false,
      titbutton: "+",
      classbutton: "btn btn-success",
      titlbutton: "Добавить задание",
      nametask: "", //   название задания
      numertask: 0, //  номер задания
      klass: "5", //  для какого класса
      timetask: 15, // время выполнения задания
      quanttask: 12, //   количесство вопросов в тесте
      periodtask: "", // период
      errormess: "",
      listquest: [],
      id: "",
      namebutton: "",
    };
  },
  mounted() {
    this.update();
    //console.log("Component mounted.");
  },
  methods: {
    update: function () {
      axios.post("/updatetask").then((response) => {
        this.listquest = response.data.all;
      });
    },
    addlist: function () {
      //зарывается или открывается форма редактирования
      if (this.addform == true) {
        this.titbutton = "+";
        this.addform = false;
        this.classbutton = "btn btn-success";
        this.titlbutton = "Добавить задание";
        this.nullforma();
      } else {
        this.titbutton = "X";
        this.addform = true;
        this.classbutton = "btn btn-danger";
        this.titlbutton = "Закрыть форму";
        this.namebutton = "Добавить";
      }
    },
    addtask: function () {
      //добавляем в базу данных
      const data_form = {
        nametask: this.nametask,
        numertask: this.numertask,
        klass: this.klass,
        timetask: this.timetask,
        quanttask: this.quanttask,
        periodtask: this.periodtask,
      };
      this.errormess = "";
      this.validform();
      if (this.namebutton == "Добавить") {
        if (this.errormess == "") {
          axios.post("/addtask", data_form).then((response) => {});
          alert("Данные добавлены!");
          this.addform = false;
          this.update();
          this.nullforma();
          this.addlist();
        }
      }
      if (this.namebutton == "Сохранить") {
        if (this.errormess == "") {
          //axios.post("/addtask", data_form).then((response) => {});
          alert("Данные обновлены!");
          //this.addform = false;
          //this.update();
          //this.nullforma();
          //this.addlist();
        }
      }

      //this.errormess = "Должно быть число";
      //this.errormess= this.validforms;
    },
    nullforma: function () {
      //обнуляем поля формы
      this.addform = false;
      this.id = "";
      this.nametask = ""; //   название задания
      this.numertask = 0; //  номер задания
      this.klass = "5"; //  для какого класса
      this.timetask = 15; // время выполнения задания
      this.quanttask = 12; //   количесство вопросов в тесте
      this.periodtask = ""; // период
      this.namebuttun = "";
    },

    editlist: function (idstr) {
      //заполняем форму для редактирования
      const idstroki = {
        idstr: idstr,
      };
      axios.post("/oneentry", idstroki).then((response) => {
        this.titbutton = "X";
        this.addform = true;
        this.classbutton = "btn btn-danger";
        this.titlbutton = "Закрыть форму";
        this.id = response.data.id;
        this.nametask = response.data.name; //   название задания
        this.numertask = response.data.numer; //  номер задания
        this.klass = response.data.klass; //  для какого класса
        this.timetask = response.data.time; // время выполнения задания
        this.quanttask = response.data.num_quest; //   количесство вопросов в тесте
        this.periodtask = response.data.purpose;
        this.namebutton = "Сохранить";

        //console.log(response.data.name);
      });
      //console.log(idstr); ///oneentry
    },

    validform: function () {
      //небольшая валидация
      if (this.numertask > 0) {
      } else {
        this.errormess = this.errormess + " Номер задания";
      }
      if (this.timetask > 0) {
      } else {
        this.errormess = this.errormess + " Время в минутах";
      }
      if (this.quanttask > 0) {
      } else {
        this.errormess = this.errormess + " Количество вопросов";
      }
      return this.errormess;
    },
  },
};
</script>



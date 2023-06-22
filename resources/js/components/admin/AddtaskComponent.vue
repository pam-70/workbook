<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Страница добавления вопросов
            <div class="row">
              <div class="form-group col-sm-2">
                <span
                  ><input
                    type="text"
                    class="form-control"
                    placeholder="№ задания"
                    v-model="numertest"
                /></span>
              </div>
              <div class="form-group col-sm-2">
                <span
                  ><input
                    type="text"
                    class="form-control"
                    placeholder="Рисунок"
                    v-model="pict"
                /></span>
              </div>
              <div class="form-group col-sm-3">
                <input type="checkbox" id="checkbox" v-model="show_r" />
                <label for="checkbox">Редактировать вопросы</label>
              </div>
              
              <div class="form-group col-sm-2" v-if="show_r==true">
                <span
                  ><input
                    type="text"
                    class="form-control"
                    placeholder="id задания"
                    v-model="quest_id"
                  />
                </span>
              </div>
              <div class="form-group col-sm-3" v-if="show_r==true">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="watchquest"
                >
                  W
                </button>
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="editquest"
                >
                  S
                </button>
                <button type="button" class="btn btn-primary" @click="delquest">
                  D
                </button>
              </div>
            </div>
          </div>
          <div class="card-header">
            <div class="row">
              <div class="form-group col-sm-12">
                <span
                  ><input
                    type="text"
                    class="form-control"
                    placeholder="Вопрос"
                    v-model="quest"
                /></span>
              </div>
              <div class="row">
                <div class="form-group col-sm-4">
                  <span v-if="this.vid == 3"
                    >Письменный ответ<input
                      type="text"
                      class="form-control"
                      placeholder="Ответ"
                      v-model="answer"
                  /></span>
                </div>
                <div class="form-group col-sm-6">
                  <input
                    type="radio"
                    id="two1"
                    value="3"
                    v-model="vid"
                    @click="news"
                  />
                  <label for="one">Письменный ответ</label>
                  <input
                    type="radio"
                    id="two2"
                    value="2"
                    v-model="vid"
                    @click="news"
                  />
                  <label for="two">Несколько</label>
                  <input
                    type="radio"
                    id="two3"
                    value="1"
                    v-model="vid"
                    @click="news"
                  />
                  <label for="two1">Один ответ</label>
                </div>
                <div class="form-group col-sm-2">
                  <br />
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="addquest"
                  >
                    Добавить
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body" v-if="this.vid != 3">
          <div class="row">
            <div class="col-md-10">
              <p v-for="(label, index) in labels" :key="label.id">
                <input type="checkbox" id="checkbox" v-model="checked[index]" />
                Верный ответ
                <input
                  type="text"
                  v-model="inputtext[index]"
                  class="form-control form-control-sm"
                  placeholder="Ответ"
                />
              </p>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary" @click="addinput">
                +
              </button>

              <button
                type="button"
                class="btn btn-danger"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Очистить результаты"
                @click="dellinput"
              >
                -
              </button>
            </div>
            <div class="row">
              <div class="form-group col-md-10"></div>
              <div class="form-group col-md-2"></div>
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
      allresult: "",
      //----------------
      vid: "3",
      labels: ["", "", "", ""],
      inputtext: ["", "", "", ""],
      checked: [false, false, false, false],
      numertest: "",
      pict: "",
      quest: "",
      answer: "",
      quest_id: "",
      show_r: false,
    };
  },
  mounted() {
    this.update();
  },
  methods: {
    update: function () {
      //получить данные об usere
      //  console.log("9999");
    },
    news: function () {
      if (this.quest_id > 0) {
      } else {
        this.labels = ["", "", "", ""];
        this.inputtext = ["", "", "", ""];
        this.checked = [false, false, false, false];
      }
    },
    editquest: function () {
      if (this.quest_id > 0) {
        const data_url = {
          // передаем данные
          checked: this.checked,
          inputtext: this.inputtext,
          numertest: this.numertest,
          pict: this.pict,
          quest: this.quest,
          answer: this.answer,
          vid: this.vid,
          quest_id: this.quest_id,
          answer_id: this.labels,
        };
        this.clearform();
        if (this.numertest > 0 && this.quest_id > 0) {
          axios.post("/editquest", data_url).then((response) => {});
        }
        // this.watchquest();
      }
    },
    delquest: function () {
      const data_url = {
        // передаем данные
        quest_id: this.quest_id,
        vid: this.vid,
      };
      // this.inputtext = [];
      // this.checked = [];
      if (this.quest_id > 0) {
        axios.post("/delquest", data_url).then((response) => {});
        this.clearform();
      }
    },
    watchquest: function () {
      const data_url = {
        // передаем данные
        quest_id: this.quest_id,
      };
      this.inputtext = [];
      this.checked = [];
      if (this.quest_id > 0) {
        axios.post("/watchquest", data_url).then((response) => {
          this.numertest = response.data.quest.t_numer;
          this.pict = response.data.quest.pict;
          this.quest = response.data.quest.quest;
          this.answer = response.data.quest.right_ansv;
          this.vid = response.data.quest.vid;
          this.checked = response.data.checked;
          this.inputtext = response.data.inputtext;
          this.labels = response.data.labels;
        });
      }
    },
    dellinput: function () {
      this.labels.pop();
      this.inputtext.pop();
      this.checked.pop();
    },
    addinput: function () {
      this.labels.push("");
      this.inputtext.push("");
      this.checked.push(false);
    },
    addquest: function () {
      const data_url = {
        // передаем данные
        checked: this.checked,
        inputtext: this.inputtext,
        numertest: this.numertest,
        pict: this.pict,
        quest: this.quest,
        answer: this.answer,
        vid: this.vid,
      };
      if (this.numertest > 0) {
        axios.post("/addquest", data_url).then((response) => {
          //console.log(response.data.school);
        });
      }
    },
    clearform: function () {
      this.inputtext = [];
      this.checked = [];
      this.labels = [];
      this.vid = 3;
      this.pict = "";
      this.quest = "";
      this.answer = "";
      this.quest_id = "";
      this.numertest = "";
    },
  },
};
</script>

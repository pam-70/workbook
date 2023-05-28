<template>
  <div>
    <header-component :data_student="data_student" @exit_user="exit_user" />
    <start-component
      :numer_testa="numer_testa"
      @start_test="start_test"
      :formkontrol="formkontrol"
      :notest="notest"
    />
    <show-component
      :timeshet="formatted"
      :formkontrol="formkontrol"
      :counter="counter"
      :numer_quest="numer_quest"
      :numer_testa="numer_testa"
      :all_quest="all_quest"
    />
    <div class="row">
      <div class="col-md-12">
        <quest-component
          :formkontrol="formkontrol"
          :quest="quest"
          :pict="pict"
        />
        <radio-component
          :formkontrol="formkontrol"
          :answer_test="answer_test"
          @radioclic="radioclic"
        />
        <check-component
          :formkontrol="formkontrol"
          :answer_test="answer_test"
          :reset_chec="reset_chec"
          @chec_arr="chec_arr"
        />
        <written-component
          :formkontrol="formkontrol"
          @text_writte="text_writte"
          :pr_textquest="pr_textquest"
        />
        <toanswer-component
          :formkontrol="formkontrol"
          @to_answert="to_answert"
          :empty_answer="empty_answer"
        />
      </div>
    </div>
    <result-component
      :formkontrol="formkontrol"
      :mark="mark"
      :prozent="prozent"
      @exit_view="exit_view"
    />
    <viewing-component
      :formkontrol="formkontrol"
      :mark="mark"
      :prozent="prozent"
      @exit_view="exit_view"
    />
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: function () {
    return {
      numer_testa: 0, //исправить на ноль после отладки номер вопроса самая основная переменная
      all_quest: 0, // всего вопросов
      counter: 0, //время выполнения теста
      formatted: "00:00",
      polling: null,
      minutes: 0,
      seconds: 0,
      formkontrol: 0, // контроль вывода форм
      data_student: "", //все данные
      notest: "",
      qestion: "", //
      pict: "",
      numer_quest: "", // номер вопроса теста
      quest: "",
      answer_test: [],
      radio_cl: 0,
      radio_stcl: 0, // обнулить при кнопке ответить
      empty_answer: "", //если пустой ответ
      result_id: "", // ади результатов
      checkedForm: [], //форма чеков для отправки
      reset_chec: 0,
      written_val: "", // ответ письменный
      pr_textquest: "",
      mark: "",
      prozent: "",
    };
  },

  mounted() {
    this.update();
  },
  methods: {
    update: function () {
      //получить данные об usere
      //console.log("0000000000000000");
      this.formatdate();
      axios.post("/updatestudent").then((response) => {
        this.data_student = response.data;
      });
    },
    next: function () {
      //следующий вопрос
      this.numer_quest++;
      if (this.all_quest >= this.numer_quest) {
        const data_next = {
          // передаем данные
          result_id: this.result_id,
          numer_quest: this.numer_quest,
        };
        this.answer_test = "";
        this.quest = "";
        axios.post("/next", data_next).then((response) => {
          this.formkontrol = response.data.quest_test[0].vid; //какую форму показать
          this.pict = "pict_test/" + response.data.quest_test[0].pict; //
          this.numer_testa = response.data.quest_test[0].t_numer; //
          this.quest = response.data.quest_test[0].quest; //
          this.result_id = response.data.quest_test[0].result_id; //
          this.answer_test = response.data.answer_test; //
        });
      } else {
        this.stop(); // остановка теста и подсчет очков
      }
    },
    text_writte: function (event) {
      //передача данных
      this.written_val = event;
    },
    chec_arr: function (arr_m) {
      //передача данных
      // перезаписываем массив
      this.checkedForm = arr_m;
      this.reset_chec = 0;
    },
    radioclic: function (click_id) {
      //передача данных
      this.radio_cl = click_id;
    },

    to_answert: function () {
      //кнока следующий вопрос
      //  this.radio_stcl=0;
      if (this.formkontrol == 1) {
        //еденичный выбор
        const data_radio = {
          click_id: this.radio_cl,
          clik_data: 1,
        };
        if (this.radio_cl != 0) {
          this.empty_answer = "";
          this.radio_cl = "";
          axios.post("/radioclic", data_radio).then((response) => {});
          this.next(); //следующий вопрос
        } else {
          this.empty_answer = " Выберите ответ!";
        }
      }
      if (this.formkontrol == 2) {
        // множественный выбор
        if (this.checkedForm != 0) {
          //если массив не пустой
          //this.empty_answer = " не пусой";
          const data_check = {
            check_arr: this.checkedForm,
            check_data: 1,
          };
          axios.post("/checkanswer", data_check).then((response) => {});
          this.next(); //следующий вопрос

          this.checkedForm = [];
          this.reset_chec = 1;
        } else {
          this.empty_answer = " Выберите ответ!";
        }
      }
      if (this.formkontrol == 3) {
        // текстовый выбор
        if (this.written_val != "") {
          const data_text = {
            text_var: this.written_val,
            result_id: this.result_id,
            numer_quest: this.numer_quest,
          };
          axios.post("/textansver", data_text).then((response) => {});
          this.written_val = "";
          this.pr_textquest = this.numer_quest;

          this.empty_answer = "";

          this.next(); //следующий вопрос
        } else {
          this.empty_answer = " Впишите ответ!";
        }
      }
      //console.log("DXALEE");
    },

    start_test: function (numer_testa) {
      //старт выполнения теста
      const data_numer = {
        test_numer: numer_testa,
        student_id: this.data_student.id,
      };
      if (isNaN(numer_testa)) {
        //проверка на число
        this.notest = "Введите номер задания!";
      } else {
        axios.post("/starttest", data_numer).then((response) => {
          if (response.data.numer_ts == "NO") {
            // console.log("PUSTO");
            this.notest = "Такого номера задания нет!";
          } else {
            this.notest = ""; //выполняем сам тест
            this.counter = response.data.time_test; //время выполнения
            this.formkontrol = response.data.quest_test[0].vid; //какую форму показать
            this.pict = "pict_test/" + response.data.quest_test[0].pict; //
            this.numer_quest = response.data.quest_test[0].numerquestion; //
            this.numer_testa = response.data.quest_test[0].t_numer; //
            this.quest = response.data.quest_test[0].quest; //
            this.result_id = response.data.quest_test[0].result_id; //
            this.answer_test = response.data.answer_test; //
            this.all_quest = response.data.all_quest; //

            this.pusk();
          }
        });
      }

      // console.log("UPS");
    },
    exit_user: function () {
      axios.post("/exit").then((response) => {});
      location.reload(); // обновить страницу
    },

    formatdate: function () {
      this.minutes = Math.floor(this.counter / 60);
      this.seconds = this.counter % 60;
      if (this.minutes < 10) {
        this.formatted = "0" + String(this.minutes);
      } else {
        this.formatted = String(this.minutes);
      }
      if (this.seconds < 10) {
        this.formatted = this.formatted + ":0" + String(this.seconds);
      } else {
        this.formatted = this.formatted + ":" + String(this.seconds);
      }
    },
    pusk: function () {
      //начало выполнения теста и счетчика
      this.polling = setInterval(() => {
        this.counter--;
        this.formatdate();
        this.analiz();
      }, 1000);
      //console.log("pusk");
    },

    stop: function () {
      this.counter = 0;
      this.formkontrol = -1;
      this.formatted = "00:00";
      this.numer_quest = 0;
      this.numer_testa = 0;
      clearInterval(this.polling);
      console.log("STOP TIME"); //здесь остановка выполнения теста подсчет заданий

      const data_result = {
        //text_var: this.written_val,
        result_id: this.result_id,
        all_quest: this.all_quest,
      };
      axios.post("/resulttest", data_result).then((response) => {
        this.mark = response.data.mark;
        this.prozent = response.data.prozent;
        console.log((this.counter = response.data.mark));
        console.log((this.counter = response.data.prozent));
      });

      //
    },
    exit_view: function () {
      this.formkontrol = 0;
      this.mark = "";
      this.prozent = "";
    },
    analiz: function () {
      if (this.counter < 1) {
        this.stop();
      }
    },

    clics: function (wer) {
      // console.log("Родительская форма");
      this.pusk();
    },
  },
};
</script>

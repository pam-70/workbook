<template>
  <div class="container">

    ВРЕМЯ : {{ formatted }}
    <button type="button" class="btn btn-link" @click="pusk()">
      Пуск счетчика
    </button>
    <button type="button" class="btn btn-link" @click="stop()">STOP</button>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data: function () {
    return {
      numer_testa: 0, //исправить на ноль после отладки номер вопроса самая основная переменная
      counter: 100,
      polling: null,
      minutes: 0,
      seconds: 0,
      formatted: "00:00",
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
      this.formatdate();
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
    },

    stop: function () {
      this.counter = 100;
      clearInterval(this.polling);
    },
    analiz: function () {
      if (this.counter < 1) {
        this.stop();
        //выполнить анализ выполнения теста и остановить тест
      }
    },

    minus: function () {
      //  if (this.numer_testa > 1) {
      //   this.numer_testa--;
      //    this.errors = "";
    },
    //  this.update_post(this.numer_testa);
    // },
    //повторяющаяся функция
    // update_post: function (numer_ans) {
    //   const data_form = {
    //     choice_post: this.choice, // выбор номера теста задания
    //     numer_testa: numer_ans,
    //     all_quest: this.all_quest,
    //     summar_id: this.summar_id,
    //   };
    //    axios.post("/run_test", data_form).then((response) => {
    //      this.all_quest = response.data.url_all_quest;
    //      this.summar_id = response.data.url_summar_id;
    //      this.list = response.data.url_odin_quest; // массив вопросов
    //      this.answer = response.data.url_answer;
    //    });
  },
};
//   var second=15;
//     function tiktak()
//      {
//       if(second<=9){second="0" + second;}
//       if(document.getElementById){timer.innerHTML=second;}
//       if(second==00){return false;}
//       second--;
//      setTimeout("tiktak()", 1000);
//    }
</script>
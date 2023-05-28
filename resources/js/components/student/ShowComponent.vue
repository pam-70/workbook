<template >
  <div v-if="formkontrol>0">
    <div class="row">
      <div class="col-md-3">
        <div class="p-3 border bg-light">
          <div class="w-50 mx-auto">
            <font size="3" color="red"
              ><b> ВРЕМЯ : {{ timeshet }} </b>
            </font>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="p-3 border bg-light">Вопрос № {{numer_quest}} из {{all_quest}}</div>
      </div>
      <div class="col-md-4">
        <div class="p-3 border bg-light">Задание № {{numer_testa}} </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    timeshet: "",
    formkontrol: "",
    counter: "",
    numer_quest: "",
    numer_testa:"",
    all_quest:"",
   
  },
  data: function () {
    return {
      //numer_testa: 0, //исправить на ноль после отладки номер вопроса самая основная переменная
      
      polling: null,
      minutes: 0,
      seconds: 0,
      formatted: "00:00",
    };
  },
  mounted() {
    this.update();
    //axios.post("/all_quest").then((response) => {
    //this.all_quest = response.data.url_all_quest;
    //this.percent = response.data.url_percent;
    //});
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

    minus: function () {},
    start: function () {
      console.log("&&&&&&&&&&&&");
    },
  },
};
</script>

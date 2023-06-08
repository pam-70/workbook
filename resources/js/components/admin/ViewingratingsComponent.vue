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
                  <select id="selectschool" v-model="selected" @mouseup="filtrklass()">
                    <option :value="school.id" v-for="school in all_school" :key="school.id">
                      {{ school.nameschool }}
                    </option>
                  </select>
                  <select v-model="selected_klass">
                    <option :value="klass.id" v-for="klass in all_klass" :key="klass.id">
                      {{ klass.nameklass }}
                    </option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <input class="form-control form-control-sm" type="text" v-model="numerstudent" placeholder="Порядковый номер ученика"></input>
                </div>
                <div class="col">
                  <button type="button" class="btn btn-success"  @click="outputresults">Просмотреть</button>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  1 of 3
                </div>
                <div class="col">
                  2 of 3
                </div>
                <div class="col">
                  3 of 3
                </div>
              </div>
            </div>







          </div>

        </div>

        <div class="card-body">

          <div class="col-md-2">
            <div class="butv">
              Вывод результатов
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div></template>

<script>
export default {
  data: function () {
    return {
      all_school: [],
      all_klass: [],
      selected: "",
      selected_klass: "",
      numerstudent:"",
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
        //console.log(response.data);
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
      };
    },
    outputresults: function(){// вывод результатов
      console.log("pusk");
      const data_updat = {
        // передаем данные
        schoolid: this.selected,
        numerstudent: this.numerstudent,
        selected_klass: this.selected_klass,

      };
       if (this.selected > 0 && this.selected_klass>0) {
      //   axios.post("/filtrklass", data_updat).then((response) => {
      //     this.all_klass = response.data.klass;
      //   });
       };


    },
  },
};
</script>

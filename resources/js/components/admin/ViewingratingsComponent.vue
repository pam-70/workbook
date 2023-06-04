<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Просмотр результатов учащихся</div>
          <div class="card-header">ннннннннн</div>

                    <div class="card-body">
            <select id="selectschool">
              <option
                :value="school.id"
                v-for="school in all_school"
                :key="school.id"
              >
                {{ school.nameschool }}
              </option>
            </select>
            <div class="col-md-2">
              <div class="butv">
                <button
                  @click="exit_view()"
                  type="button"
                  class="btn btn-outline-danger"
                >
                  Закончить просмотр
                </button>
              </div>
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
        console.log(response.data);
      });
    },
  },
};
</script>

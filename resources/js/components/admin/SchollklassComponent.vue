<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <!-- Кнопка-триггер модального окна -->

      <!-- Модальное окно -->
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Редактировать таблицу школы
              </h5>

              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Закрыть"
              ></button>
            </div>
            <div class="modal-body">
              <input
                v-model="inputschool"
                class="form-control form-control-sm"
                type="text"
                placeholder="Необходимо выбрать школу. При редактировании"
              />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger">Удалить СШ</button>
              <button type="button" class="btn btn-primary">
                Добавть школу
              </button>
              <button
                type="button"
                class="btn btn-primary"
                @click="updateschool()"
              >
                Сохранить изменения
              </button>
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Закрыть
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Школы и классы</div>
          <div class="card-header">ннннннннн</div>

          <div class="card-body">
            <div class="container">
              <div class="row">
                <div class="col-sm">
                  <button
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    @click="editschool()"
                  >
                    Редактировать
                  </button>
                  <select v-model="selected">
                    <option
                      :value="school"
                      v-for="school in all_school"
                      :key="school.id"
                    >
                      {{ school.nameschool }}
                    </option>
                  </select>

                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Школа</th>
                        <th scope="col">Ред.</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        scope="row"
                        v-for="school in all_school"
                        :key="school.id"
                      >
                        <th>{{ school.id }}</th>
                        <td>
                          {{ school.nameschool }}
                        </td>
                        <td>Otto</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm">Одна из трёх колонок</div>
              </div>
            </div>

            <select id="selectschool">
              <option
                :value="school.id"
                v-for="school in all_school"
                :key="school.id"
                @click="clicselekt(school.nameschool)"
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
      selected: "",
      inputschool: "",
      schoolid: "",
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
    updateschool: function (school_id) {
      this.$alert("Hello Vue Simple Alert.");
      console.log(school_id);
    },
    editschool: function () {
      console.log(this.selected.nameschool);
      this.inputschool = this.selected.nameschool;
      this.schoolid = this.selected.id;
    },
    clicselekt: function (ert) {
      console.log(ert);
      console.log("88888888888888");
    },
  },
};
</script>

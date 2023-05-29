<template>
  <div v-if="formkontrol == -2">
    <div class="row g-2">
      <div class="col-md-12">
        <div class="p-3 border bg-light">
          <div class="row">
            <div class="col-md-10">
              <div class="text">
                Выполнили задание на {{ mark }} процент выполнения =
                {{ prozent }}
              </div>
            </div>
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
  props: {
    formkontrol: "",
    mark: "",
    prozent: "",
  },
  mounted() {
    //console.log("Component mounted.");
  },
  methods: {
    exit_view: function () {
      this.$emit("exit_view");
    
     
    },
  },
};
</script>

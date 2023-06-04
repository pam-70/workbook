<template>
  <div v-if="formkontrol == -2">
    <div class="row g-2">
      <div class="col-md-12">
        <div class="p-3 border bg-light">
          <div class="row">
            <div class="col-md-10">
              <div class="text">
                <div v-for="all_ers in all_result" :key="all_ers.id">
                  <span v-if="(all_ers.mark === '2') | (all_ers.mark === 2)">
                    <font size="3" :color="color2">
                      {{ all_ers.school }} - {{ all_ers.klass }} - №
                      {{ all_ers.numer }} - {{ all_ers.name }} -
                      {{ all_ers.t_numer }} - отм {{ all_ers.mark }} -
                      {{ new Date(all_ers.updated_at).toLocaleString() }}
                    </font>
                  </span>
                  <span v-if="(all_ers.mark === '3') | (all_ers.mark === 3)">
                    <font size="3" :color="color3">
                      {{ all_ers.school }} - {{ all_ers.klass }} - №
                      {{ all_ers.numer }} - {{ all_ers.name }} -
                      {{ all_ers.t_numer }} - отм {{ all_ers.mark }} -
                      {{ new Date(all_ers.updated_at).toLocaleString() }}
                    </font>
                  </span>
                  <span v-if="(all_ers.mark === '4') | (all_ers.mark === 4)">
                    <font size="3" :color="color4">
                      {{ all_ers.school }} - {{ all_ers.klass }} - №
                      {{ all_ers.numer }} - {{ all_ers.name }} -
                      {{ all_ers.t_numer }} - отм {{ all_ers.mark }} -
                      {{ new Date(all_ers.updated_at).toLocaleString() }}
                    </font>
                  </span>
                  <span v-if="(all_ers.mark === '5') | (all_ers.mark === 5)">
                    <font size="3" :color="color5">
                      {{ all_ers.school }} - {{ all_ers.klass }} - №
                      {{ all_ers.numer }} - {{ all_ers.name }} -
                      {{ all_ers.t_numer }} - отм {{ all_ers.mark }} -
                      {{ new Date(all_ers.updated_at).toLocaleString() }}
                    </font>
                  </span>
                </div>
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
    all_result: "",
  },
  data: function () {
    return {
      color2: "#000000",
      color3: "#4B0082",
      color4: "#008000",
      color5: "#FF0000",
      color_vr: "",
    };
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

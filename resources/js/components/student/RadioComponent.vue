<template>
  <div v-if="formkontrol == 1">
    <div class="p-3 border bg-light">
      <div v-for="ans_ts in answer_test" :key="ans_ts.id" class="form-check">
        <input
          class="form-check-input"
          type="radio"
          :value="ans_ts.id"
          id="flexRadioDefault1"
          name="ans"
          @click="radioclic(ans_ts.id)"
        />
        <label class="form-check-label" for="flexRadioDefault1">
          {{ ans_ts.result_answer }}
        </label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      id_ans: 0,
    };
  },
  props: {
    formkontrol: "",
    answer_test: "",
  },
  mounted() {
    //console.log("Component mounted.");
  },
  methods: {
    radioclic: function (click_id) {
      this.$emit("radioclic", click_id);
    },
    // clicradio: function (tr) {
    //   console.log(tr);
    // },
  },
};
</script>

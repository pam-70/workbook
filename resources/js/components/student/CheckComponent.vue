<template>
  <div v-if="formkontrol == 2">
    <div class="p-3 border bg-light">
      <div
        v-for="(ans_ts, index) in answer_test"
        :key="ans_ts.id"
        class="form-check"
      >
        <input
          class="form-check-input"
          type="checkbox"
          :value="ans_ts.id"
          :id="ans_ts.id"
          :index="index"
          v-model="checkedForm"
          @click="reset_arr"
        />
        <label class="form-check-label" for="flexCheckDefault"
          >{{ ans_ts.result_answer }},{{ ans_ts.index }}
        </label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      checkedForm: [],
    };
  },
  props: {
    formkontrol: "",
    answer_test: "",
    reset_chec: 0,
  },

  mounted() {
   // console.log("yyyyyyyyyyyyyyyyy.");
  },
  watch: {
    // при изменении массива
    checkedForm: function () {
      this.$emit("chec_arr", this.checkedForm);
    },
  },

  methods: {
    reset_arr: function () {
      if (this.reset_chec == 1) {
        this.checkedForm = [];
      }
    },
  },
};
</script>

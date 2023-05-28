<template>
  <div v-if="formkontrol > 0">
    <div class="p-3 border bg-light">
      <button @click="to_answert()" type="button" class="btn btn-success">
        Ответить
      </button>
      <label for="exampleInputPassword1" class="form-label">
        <font size="3" color="red"
          ><b>{{ empty_answer }}</b></font
        ></label
      >
    </div>
  </div>
</template>

<script>
export default {
  props: {
    formkontrol: "",
    empty_answer: "",
  },
  mounted() {
    //console.log("Component mounted.");
  },
  methods: {
    to_answert: function () {
      this.$emit("to_answert");
    },
  },
};
</script>

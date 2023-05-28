<template>
  <div v-if="formkontrol == 3">
    <div class="p-3 border bg-light">
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label"
          >Введите письменный ответ</label
        >
        <input
          v-model="text_quest"
          @input="updateInput"
          type="text"
          class="form-control"
          id="numer"
          v-on:keypress="isLetterOrNumber($event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      text_quest: "",
    };
  },
  props: {
    formkontrol: "",
    pr_textquest: "",
  },

  mounted() {
    //console.log("Component mounted.");
  },

  watch: {
    // при изменении массива
    pr_textquest: function () {
      this.text_quest = 0;
      this.text_quest = "";
    },
  },
  methods: {
    updateInput(event) {
      this.$emit("text_writte", this.text_quest);
    },
    isLetterOrNumber(e) {
      // проверка на ввод символов//сделать проверку на ввод спец символов
      let char = String.fromCharCode(e.keyCode);
      if (/^[А-Яа-яA-Za-z0-9]+$/.test(char)) return true;
      else e.preventDefault();
    },
  },
};
</script>

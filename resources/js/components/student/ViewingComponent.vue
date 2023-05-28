<template>
  <div v-if="formkontrol == -1">
    <div class="row g-2">
      <div class="col-md-12">
        <div class="p-3 border bg-light">
          Блок просмотра результатов выполнения задания
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    formkontrol: "",
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>

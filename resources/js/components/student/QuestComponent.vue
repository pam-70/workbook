<template>
  <div v-if="formkontrol>0" >
    <div class="p-3 border bg-light">{{quest}}</div>

    <div v-if="pict!= 'pict_test/'" class="p-3 border bg-light">
      
      <img :src="pict" class="img-thumbnail" />
    </div>
  </div>
</template>

<script>
export default {
    props: {
    formkontrol: "",
    quest:"",
    pict:"",
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>

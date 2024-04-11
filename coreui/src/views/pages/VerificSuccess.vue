<template>
     <div class="container text-center p-5 px-5">
    <img class="ax-center my-10 w-10 my-5" style="width: 20%;" src="../../../public/img/icon_success.png" />
    <div class="card p-6 p-lg-10 space-y-4 p-5 mx-5">
      <h1 class="h3 fw-700 text-dark">
        Éxito
      </h1>
      <p class="text-dark">
        Exelente, Tu cuenta ha sido verificada con éxito.
      </p>
      <a class="btn btn-dark  p-3 fw-700" href="#" @click="linkHome()">Ir al home</a>
    </div>
   
  </div>

</template>
  
<script>


export default {
  name: "VerificSuccess",
  data() {
    return {
   
    };
  },
  methods: {
    linkHome() {
      this.$router.push({ path: "/" });
    },
  },
};
</script>
<style scoped>

</style>
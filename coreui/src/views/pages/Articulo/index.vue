<template>
  <div class="vld-parent">
    <!-- ESOS SON LOS PROPS PERSONALIZABLE PARA EL PRE LOADER-->
    <loading-overlay
      :active="Loading"
      :is-full-page="true"
      loader="spinner"
      color="#19751D"
      background-color="#196E75"
    />

    <button @click.prevent="FUNCTION_CUALQUIERA">PROBAR EL PRE-LOADER</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      Loading: false,
    };
  },
  components: {},
  methods: {
    FUNCTION_CUALQUIERA() {
      this.Loading = true;
      // simulate AJAX
      setTimeout(() => {
        this.Loading = false;
      }, 5000);
    },
    onCancel() {
      console.log("User cancelled the loader.");
    },
  },
};
</script>

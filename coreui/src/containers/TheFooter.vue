<template>
  <CFooter :fixed="false">
    <div>
      <a href="https://coreui.io" target="_blank">YareStylo</a>
      <span class="ml-1"
        >&copy; {{ new Date().getFullYear() }} Todos los derechos
        reservados.</span
      >
    </div>
    <!-- <div class="ml-auto">
      <span class="mr-1">Powered by</span>
      <a href="https://coreui.io/vue" target="_blank">Antonio y Gianfranco</a>
    </div> -->
  </CFooter>
</template>

<script>
export default {
  name: "TheFooter",
};
</script>

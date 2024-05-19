<template>
  <div class="img-logo-dashboard">
    <CRow class="w-100">
      <img src="../../public/logo_alterno/logo alterno color oro.png" width="100%" height="100%" alt="logo">
       </CRow>
  </div>
</template>

<script>
//import image from "../../public/logo_alterno/logo alterno color bronce"




export default {
  name: "Dashboard",
  data() {
    return {
      isAdmin: false,
      collapsedSection: null,
      
    };
  },
  mounted: function () {
    if (localStorage.getItem("roles") == "user,admin") {
      this.isAdmin = true;
    }
  },
};
</script>
<style scoped>
#next {
  float: right;
}
.customs-section {
  cursor: pointer;
}
.img-logo-dashboard{
  background-color: #202020 !important;
}
</style>

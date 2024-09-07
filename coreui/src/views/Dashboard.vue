<template>
  <div class="img-logo-dashboard">
    <CRow class="w-100">
      <img
        src="../../public/logo_alterno/logo alterno color oro.png"
        width="100%"
        height="100%"
        alt="logo"
      />
    </CRow>
  </div>
</template>

<script>
//import image from "../../public/logo_alterno/logo alterno color bronce"

import axios from "axios";
function validateSesion() {
  let self = this;
  axios
    .get(
      this.$apiAdress +
        "/api/user/validatesesion?token=" +
        localStorage.getItem("api_token")
    )
    .then(function (response) {
    console.log('tehn validar sesion',response);
    })
    .catch(function (error) {
      console.log('catch validar sesion',error);
      if (error.response.status == 401) {
        self.Loading = false;
        self.$router.push({ path: "/login" });
        //self.$toastr.warning('Sesión no activa, inicie nuevamente');
        
        localStorage.clear();
        self.$swal.fire({
          position: "top-end",
          icon: "warning",
          title: "Sesión no activa, inicie nuevamente",
          showConfirmButton: false,
          timer: 1400
        });
      }
    });
}

export default {
  name: "Dashboard",
  data() {
    return {
      isAdmin: false,
      collapsedSection: null,
    };
  },
  mounted: function () {
    this.validateSesion();
    if (localStorage.getItem("roles") == "user,admin") {
      this.isAdmin = true;
    }
  },
  methods: {
    validateSesion,
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
.img-logo-dashboard {
  background-color: #202020 !important;
}
</style>

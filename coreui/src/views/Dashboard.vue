<template>
  <div class="img-logo-dashboard">
    <CRow class="w-100">
      <img
        :src="bannerSrc"
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
      bannerSrc: require("../../public/logo_alterno/logo alterno color oro.png"),
    };
  },
  mounted: function () {
    this.validateSesion();
    this.loadBanner();
    if (localStorage.getItem("roles") == "user,admin") {
      this.isAdmin = true;
    }
  },
  methods: {
    validateSesion,
    loadBanner() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/site-resources/dashboard_banner")
        .then(function (response) {
          if (response.data.url) {
            self.bannerSrc = response.data.url;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
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

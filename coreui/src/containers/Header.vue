<template>
  <header
    class="navbar fixed-top navbar-expand-lg navbar-light bg-light px-3 header-main-modif"
  >
    <div
      class="w-100 row ml-0 mr-0 d-flex justify-content-between align-items-center"
    >
      <div class="col-md-2 col-sm-6 col-6">
        <!--<a class="text-white navbar-brand" href="#">YareStylo</a>-->
        <a class="text-white navbar-brand w-auto" href="#">
          <div>
            <img
              class="w-100"
              src="https://teboribrows.com/wp-content/uploads/2022/09/Logo-Tebori-Brows.webp"
              alt="Logo Tebori Brows"
            />
          </div>
        </a>
      </div>
      <button
        class="navbar-toggler offset-sm-4"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="col-md-8 col-sm-12 col-12 collapse navbar-collapse my-2"
        id="navbarNavAltMarkup"
      >
        <div class="navbar-nav m-auto">
          <a class="text-color-header nav-link active link-nav-mod" href="#"
            >Inicio <span class="sr-only">(current)</span></a
          >
          <a
            v-if="logueado"
            class="nav-link text-color-header link-nav-mod"
            @click="goDashboard()"
          >
            Panel de control
          </a>
          <a
            v-if="logueado == false"
            class="nav-link text-color-header link-nav-mod"
            @click="goLogin()"
          >
            Iniciar Sesión
          </a>
          <a
            v-if="logueado == false"
            class="nav-link text-color-header link-nav-mod"
            @click="goRegister()"
          >
            Registrate
          </a>
        </div>
      </div>

      <div class="col-md-2 col-sm-12 col-12 my-2">
        <a
          href="tel:+34622341648"
          class="action_button top-bar-right-button d-flex justify-content-center"
          >Llamanos!</a
        >
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: "Header",
  data() {
    return {
      email: "",
      password: "",
      showMessage: false,
      Loading: false,
      message: "",
      collapse: false,
      Productitems: [],
      Cursositems: [],
      currentPage: 1,
      perPage: 5,
      user: "",
      logueado: false,
    };
  },
  methods: {
    getRowCount(Productitems) {
      return Productitems.length;
    },
    goRegister() {
      this.$router.push({ path: "register" });
    },
    goLogin() {
      this.$router.push({ path: "login" });
    },
    goDashboard() {
      this.$router.push({ path: "Dashboard" });
    },
  },
  mounted() {
    if (localStorage.getItem("id")) {
      this.logueado = true;
    }
  },
};
</script>
<style scoped>
.c-header-brand {
  text-decoration: none;
}

.c-header-nav-item {
  cursor: pointer;
  font-size: 1.032rem;
  height: 100%;
  padding: 13px;
}
.c-header-nav-item:hover {
  border-bottom: 4px solid rgb(182, 108, 204);
}

.nav-link:hover {
  cursor: pointer;
}
.link-nav-mod {
  font-size: 20px;
  padding-left: 8px;
  padding-right: 8px;
}
@media (min-width: 992px) {
  .navbar-expand-lg .navbar-nav .nav-link {
    padding-right: 1.5rem;
    padding-left: 1.5rem;
  }
}

.action_button {
  display: flex;
  align-items: center;
  margin: 0 5px;
  white-space: nowrap;
  flex-shrink: 0;
}

.action_button.top-bar-right-button:hover {
  background-color: #c38154 !important;
}
.action_button.top-bar-right-button {
  font-family: "Poppins", sans-serif;
  font-weight: 600;
  padding: 13px 31px;
  text-transform: uppercase;
  font-size: 15px;
  letter-spacing: 1px;
  transition: background-color 0.3s, color 0.3s, border 0.3s;
  position: relative;
}
.action_button,
.action_button:hover {
  background-color: #884a39;
  color: #ffff;
}
.header-main-modif {
  background-color: #fff;
  opacity: 0.97;
  -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.1);
  -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.1);
}
</style>

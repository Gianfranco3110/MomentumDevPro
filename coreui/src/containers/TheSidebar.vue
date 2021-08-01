<template>
  <CSidebar
    class="bg-dark"
    fixed
    :minimize="minimize"
    :show="show"
    @update:show="(value) => $store.commit('set', ['sidebarShow', value])"
  >
    <CSidebarBrand class="d-md-down-none" to="/">
      <h3>YareStylo</h3>
    </CSidebarBrand>
    <!-- <CRenderFunction flat :content-to-render="nav"/>
    <CSidebarMinimizer
      class="d-md-down-none"
      @click.native="$store.commit('set', ['sidebarMinimize', !minimize])"
    />-->
    <ul id="hovers" class="c-sidebar-nav">
      <li class="c-sidebar-nav-item">
        <strong>
          <a class="c-sidebar-nav-link" href="#/dashboard">
            <CIcon size="lg" name="cil-home" class="mr-2" /> INICIO
          </a>
        </strong>
      </li>
      <li class="c-sidebar-nav-item" v-if="isAdmin">
        <strong>
          <a class="c-sidebar-nav-link" href="#/cursos">
            <CIcon size="lg" name="cil-education" class="mr-2" /> CURSOS
          </a>
        </strong>
      </li>
      <li class="c-sidebar-nav-item" v-if="isAdmin">
        <strong>
          <a class="c-sidebar-nav-link" href="#/users">
            <CIcon name="cil-user" class="mr-2" /> USUARIOS
          </a>
        </strong>
      </li>
      <li class="c-sidebar-nav-item">
        <strong>
          <a class="c-sidebar-nav-link" href="#/mis-cursos">
            <CIcon size="lg" name="cil-education" class="mr-2" /> MIS CURSOS
          </a>
        </strong>
      </li>
      <li class="c-sidebar-nav-item" v-if="isAdmin">
        <strong>
          <a class="c-sidebar-nav-link" href="#/products">
            <CIcon size="lg" name="cil-card-travel" class="mr-2" /> PRODUCTOS
          </a>
        </strong>
      </li>

      <li class="c-sidebar-nav-item" v-if="isAdmin">
        <strong>
          <a class="c-sidebar-nav-link" href="#/Registro">
            <CIcon size="lg" name="cil-address-card" class="mr-2" /> REGISTRAR
            USUARIO
          </a>
        </strong>
      </li>
      <li class="c-sidebar-nav-item">
        <strong>
          <a class="c-sidebar-nav-link" href="#/settings">
            <CIcon name="cil-settings" class="mr-2" /> CAMBIAR CONTRASEÑA
          </a>
        </strong>
      </li>
    </ul>
  </CSidebar>
</template>

<script>
export default {
  name: "TheSidebar",
  data() {
    return {
      //minimize: false,
      nav: [],
      //show: true,
      buffor: [],
      isAdmin: false,
    };
  },
  computed: {
    show() {
      return this.$store.state.sidebarShow;
    },
    minimize() {
      return this.$store.state.sidebarMinimize;
    },
  },
  methods: {
    goSettings() {
      this.$router.push({ path: "settings" });
    } /*
    dropdown(data) {
      let result = {
        _name: "CSidebarNavDropdown",
        name: data["name"],
        route: data["href"],
        icon: data["icon"],
        _children: [],
      };
      for (let i = 0; i < data["elements"].length; i++) {
        if (data["elements"][i]["slug"] == "dropdown") {
          result._children.push(this.dropdown(data["elements"][i]));
        } else {
          result._children.push({
            _name: "CSidebarNavItem",
            name: data["elements"][i]["name"],
            to: data["elements"][i]["href"],
            icon: data["elements"][i]["icon"],
          });
        }
      }
      return result;
    },
    rebuildData(data) {
      this.buffor = [
        {
          _name: "CSidebarNav",
          _children: [],
        },
      ];
      for (let k = 0; k < data.length; k++) {
        switch (data[k]["slug"]) {
          case "link":
            if (data[k]["href"].indexOf("http") !== -1) {
              this.buffor[0]._children.push({
                _name: "CSidebarNavItem",
                name: data[k]["name"],
                href: data[k]["href"],
                icon: data[k]["icon"],
                target: "_blank",
              });
            } else {
              this.buffor[0]._children.push({
                _name: "CSidebarNavItem",
                name: data[k]["name"],
                to: data[k]["href"],
                icon: data[k]["icon"],
              });
            }
            break;
          case "title":
            this.buffor[0]._children.push({
              _name: "CSidebarNavTitle",
              _children: [data[k]["name"]],
            });
            break;
          case "dropdown":
            this.buffor[0]._children.push(this.dropdown(data[k]));
            break;
        }
      }
      return this.buffor;
    },*/,
  },
  mounted() {
    this.$root.$on("toggle-sidebar", () => {
      const sidebarOpened = this.show === true || this.show === "responsive";
      this.show = sidebarOpened ? false : "responsive";
    });
    this.$root.$on("toggle-sidebar-mobile", () => {
      const sidebarClosed = this.show === "responsive" || this.show === false;
      this.show = sidebarClosed ? true : "responsive";
    });
    let self = this;
    if (localStorage.getItem("roles") == "user,admin") {
      self.isAdmin = true;
    }
    /*
    axios
      .get(
        this.$apiAdress + "/api/menu?token=" + localStorage.getItem("api_token")
      )
      .then(function(response) {
        self.nav = self.rebuildData(response.data);
      })
      .catch(function(error) {
        console.log(error);
        self.$router.push({ path: "/login" });
      });*/
  },
};
</script>
<style scoped>
.c-sidebar-brand {
  text-decoration: none;
}
</style>

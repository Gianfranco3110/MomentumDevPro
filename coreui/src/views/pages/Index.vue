<template>
  <div class="home">
    <header class="c-header fixed-top c-header-light px-3">
      <div class="container d-flex flex-row pr-5">
        <a class="c-header-brand" href="#">
          <h3>
            YareStylo
          </h3>
        </a>
        <ul class="c-header-nav ml-auto pr-4">
          <li class="c-header-nav-item active">
            <strong>
              Inicio
            </strong>
            <span class="sr-only">(current)</span>
          </li>
          <li class="c-header-nav-item">
            <strong>
              Contacto
            </strong>
          </li>
          <li v-if="logueado" class="c-header-nav-item" @click="goDashboard()">
            <strong>
              Panel de control
            </strong>
          </li>
          <li
            v-if="logueado == false"
            class="c-header-nav-item"
            @click="goLogin()"
          >
            <strong>
              Login
            </strong>
          </li>
        </ul>
      </div>
    </header>
    <div id="carousel-home" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/slider1.jpg" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="img/slider2.jpg" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="img/slider3.jpg" class="d-block w-100" alt="..." />
        </div>
      </div>
      <a
        class="carousel-control-prev"
        href="#carousel-home"
        role="button"
        data-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a
        class="carousel-control-next"
        href="#carousel-home"
        role="button"
        data-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <div id="seccion-estadisticas">
      <div class="container">
        <div class="row">
          <div class="column1">
            <div class="card">
              <div class="row">
                <h4>
                  <strong>
                    Certificate
                  </strong>
                  <br />
                  <span
                    >Completa cualquiera de nuestros cursos y obtén tu
                    certificado</span
                  >
                </h4>
              </div>
            </div>
          </div>
          <div class="column2">
            <div class="card">
              <div class="row">
                <h4>
                  <strong>
                    Aprendé
                  </strong>
                  <br />
                  <span
                    >Completa cualquiera de nuestros cursos y obtén tu
                    certificado</span
                  >
                </h4>
              </div>
            </div>
          </div>
          <div class="column3">
            <div class="card">
              <div class="row">
                <h4>
                  <strong>
                    Comparté
                  </strong>
                  <br />
                  <span
                    >Completa cualquiera de nuestros cursos y obtén tu
                    certificado</span
                  >
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="seccion-cursos">
      <div class="container">
        <CCard>
          <CCardHeader>
            <strong>
              CURSOS MAS POPULARES
            </strong>
          </CCardHeader>
          <CCardBody>
            <CRow>
              <template>
                <CCol md="4" v-for="(item, index) in Cursositems" :key="index">
                  <div class="card" style="width: 18rem;">
                    <img
                      :src="'public/curso/' + item.image"
                      class="bd-placeholder-img card-img-top"
                      width="100%"
                      height="180"
                      aria-label="Placeholder: Image cap"
                      role="img"
                    />

                    <div class="card-body">
                      <h5 class="card-title">{{ item.CourseName }}</h5>
                      <p class="card-text">${{ item.price }}</p>
                    </div>
                  </div>
                </CCol>
              </template>
            </CRow>
          </CCardBody>
        </CCard>
      </div>
    </div>
    <div id="seccion-productos">
      <div class="container">
        <CCard>
          <CCardHeader>
            <strong>
              TODOS LOS PRODUCTOS
            </strong>
          </CCardHeader>
          <CCardBody>
            <CRow>
              <template>
                <CCol md="4" v-for="(item, index) in Productitems" :key="index">
                  <div class="card" style="width: 18rem;">
                    <img
                      :src="'public/products/' + item.image"
                      class="bd-placeholder-img card-img-top"
                      width="100%"
                      height="180"
                      aria-label="Placeholder: Image cap"
                      role="img"
                    />

                    <div class="card-body">
                      <h5 class="card-title">{{ item.title }}</h5>
                      <p class="card-text">${{ item.price }}</p>
                    </div>
                  </div>
                </CCol>
              </template>
            </CRow>
          </CCardBody>
        </CCard>
      </div>
    </div>
    <footer id="footer" class="text-white">
      <div class="container">
        <div class="row">
          <div class="col-md-12 p-3">
            <div class="footer-seccion">
              <ul class="list-group">
                <li class="list-group-item footer-title">
                  <h3>Contacto</h3>
                </li>
                <li class="list-group-item">
                  <CIcon name="cil-envelope-open" />
                  email@email.com
                </li>
                <li class="list-group-item">
                  <CIcon name="cil-phone" />
                  +1 458 125478
                </li>
                <li class="list-group-item">
                  <CIcon name="cil-location-pin" />
                  Address
                </li>
              </ul>
            </div>
            <div class="footer-seccion">
              <ul class="list-group footer-social">
                <li class="list-group-item footer-title">
                  <h3>Redes Sociales</h3>
                </li>
                <li class="list-group-item">
                  <span style="font-size: 2.7em; color: rgb(64, 148, 243)">
                    <i class="fab fa-twitter-square"></i>
                  </span>
                  Twitter
                </li>
                <li class="list-group-item">
                  <span style="font-size: 2.7em; color: rgb(20, 42, 163)">
                    <i class="fab fa-facebook"></i>
                  </span>
                  Facebook
                </li>
                <li class="list-group-item">
                  <span style="font-size: 2.7em; color: rgb(54, 29, 9)">
                    <i class="fab fa-instagram-square"></i>
                  </span>
                  Instagram
                </li>
              </ul>
            </div>
            <div class="footer-seccion">
              <ul class="list-group">
                <li class="list-group-item footer-title">
                  <h3>Newsletter</h3>
                </li>
                <li class="list-group-item">
                  Dapibus ac facilisis in Morbi leo risus. Porta ac consectetur
                  ac Vestibulum at eros
                  <input
                    type="email"
                    class="form-control mt-2"
                    id="Input-email"
                    placeholder="name@example.com"
                  />
                  <button class="btn btn-success mt-2" type="button">
                    Submit
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="background-color:#aa8caf">
        <div class="footer-copyright-seccion m-auto mt-3 p-2">
          <div class="container">
            <p>© 2021 YareStylo, Todos los derechos reservados.</p>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <!--  
  
  -->
</template>

<script>
import axios from "axios";
import { freeSet } from "@coreui/icons";
import General from "@/_mixins/general";

export default {
  name: "Index",
  mixins: [General],
  freeSet,
  components: {
    General,
  },
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
    getProducts() {
      let self = this;
      axios
        .get(
          this.$apiAdress +
            "/api/products?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          self.Productitems = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getCourses() {
      let self = this;
      axios
        .get(
          this.$apiAdress +
            "/api/courses?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          self.Cursositems = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
  },
  mounted: function() {
    this.getProducts();
    this.getCourses();
    if (
      localStorage.getItem("name") != null &&
      localStorage.getItem("name") != ""
    ) {
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

#seccion-estadisticas {
  padding: 0px 50px;
  text-align: center;
}

#seccion-estadisticas .column1,
#seccion-estadisticas .column2,
#seccion-estadisticas .column3 {
  padding: 30px 15px;
  flex: 1;
}
#seccion-estadisticas .column1 {
  background-color: #8e6795;
}
#seccion-estadisticas .column2 {
  background-color: #b398b7;
}
#seccion-estadisticas .column3 {
  background-color: #a17fa6;
}

#seccion-estadisticas .card {
  border: none;
  background-color: transparent;
}

#seccion-estadisticas .card .row {
  justify-content: center;
  margin-right: 20px;
  display: flex;
  overflow: hidden;
}

#seccion-estadisticas h4 {
  color: rgb(255, 255, 255);
  margin: auto 0 auto 10px;
}

#seccion-estadisticas h4 span {
  font-size: 12px;
}

#footer {
  background-color: #8e6795;
}
</style>

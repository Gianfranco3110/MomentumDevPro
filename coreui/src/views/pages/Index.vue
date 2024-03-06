<template>
  <div class="home">
    <header class="botonesP navbar fixed-top navbar-expand-lg navbar-light bg-light px-3">
       <div class="container">
          <a class="text-white navbar-brand" href="#">YareStylo</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse my-2" style="float:right" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
              <a class="text-white nav-link active" href="#">Inicio <span class="sr-only">(current)</span></a>
              <a v-if="logueado" class="nav-link text-white" @click="goDashboard()">            
                Panel de control            
              </a>
              <a v-if="logueado == false" class="nav-link text-white" @click="goLogin()">              
                  Iniciar Sesión              
              </a>
              <a v-if="logueado == false" class="nav-link text-white" @click="goRegister()">              
                  Registrate              
              </a>
            </div>
          </div>
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
                <CCol md="6" lg="4" v-for="(item, index) in Cursositems" :key="index">
                  <div class="card" style="width: 18rem;">
                    <img
                      :src="$apiAdress +'/storage/courses/'+ item.image"
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
                  lo nueevo
                </CCol>
              </template>
            </CRow>
          </CCardBody>
        </CCard>
      </div>
    </div>
    <div>
      <a target="_blank" href="https://api.whatsapp.com/send?phone=584245064512&text=Hola que tál, me interesa obtener información de los cursos" class="btn p-0 floating-button"><i class="text-white fab fa-whatsapp w-auto"></i></a>
    </div>
    <!--<div id="seccion-productos">
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
                <CCol md="6" lg="4" v-for="(item, index) in Productitems" :key="index">
                  <div class="card" style="width: 18rem;">
                    <img
                      :src="$apiAdress + '/storage/products/'+ item.image"
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
    </div>-->
    
    <footer id="footer" class="text-white">
      <div class="container">
        <div class="row pt-3 pb-3">
          <div class="col-md-4">
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
          </div>
          <div class="col-md-4">
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
          </div>
          <div class="col-md-4">
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
      <div class="row footer-copyright-seccion">
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
          console.log("Get course");
          console.log(response.data);
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
    let self = this;
  axios
    .get(
      this.$apiAdress +
        "/api/courses/mycourses?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      //self.items = response.data;
      console.log("Response de pedro",response);
      self.logueado = true;
    })
    .catch(function(error) {
      console.log(error);
      self.logueado = false;      
    });    
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

@media only screen and (min-width:514px){
  #seccion-estadisticas {
  padding: 0px 50px;
  text-align: center;
}
}

@media only screen and (max-width:513px){
  #seccion-estadisticas {
  padding: 0px;
  text-align: center;
}
}
.footer-copyright-seccion{
  background-color: #C38154;
}

#seccion-estadisticas .column1,
#seccion-estadisticas .column2,
#seccion-estadisticas .column3 {
  padding: 30px 15px;
  flex: 1;
}
#seccion-estadisticas .column1 {
  background-color: #FFC26F;
}
#seccion-estadisticas .column2 {
  background-color: #FFC26F;
}
#seccion-estadisticas .column3 {
  background-color: #FFC26F;
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
.nav-link:hover{
  cursor:pointer;
}
</style>

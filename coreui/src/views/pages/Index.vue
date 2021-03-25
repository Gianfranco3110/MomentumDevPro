<template>
  <div class="home">
  <header class="c-header fixed-top c-header-light px-3">
    <div class="container d-flex flex-row pr-5">
  <a class="c-header-brand" href="#">
    <img src="../../../public/apple-icon-180x180.png" width="40" height="40" class="d-inline-block align-top" alt="CoreUI Logo">
    CoreUI
  </a>
  <ul class="c-header-nav ml-auto pr-4">
    <li class="c-header-nav-item active">
      <a class="c-header-nav-link" href="#">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="c-header-nav-item">
      <a class="c-header-nav-link" href="#">Features</a>
    </li>
    <li class="c-header-nav-item">
      <a class="c-header-nav-link" href="#">Pricing</a>
    </li>
    <li class="c-header-nav-item dropdown">
      <a class="c-header-nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
        Dropdown link
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
      </div>
    </li>
    <li class="c-header-nav-item">
      <router-link :to="{ name: 'Auth'}">Login</router-link>
    </li>
  </ul>
    
    </div>
</header>
<div id="carousel-home" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img/slider1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="img/slider2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="img/slider3.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carousel-home" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-home" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
<div id="seccion-cursos">
    <div class="container">
      <h2 style="color:white">Cursos</h2><br>
      <div class="row">
        <div class="col-md-3">
          <div class="card" style="width: 15rem;">
            <img src="img/slider2.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

            <div class="card-body">
              <h5 class="card-title">Curso 1</h5>
              <p class="card-text">Descripción</p>                                        
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card" style="width: 15rem;">
            <img src="img/slider2.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

            <div class="card-body">
              <h5 class="card-title">Curso 2</h5>
              <p class="card-text">Descripción</p>                                        
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card" style="width: 15rem;">
            <img src="img/slider2.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

            <div class="card-body">
              <h5 class="card-title">Curso 3</h5>
              <p class="card-text">Descripción</p>                                        
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card" style="width: 15rem;">
            <img src="img/slider2.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

            <div class="card-body">
              <h5 class="card-title">Curso 4</h5>
              <p class="card-text">Descripción</p>                                        
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="seccion-productos">
    <div class="container">
      <h2 style="color:white">Productos</h2><br>
      <div class="row">
        <div class="col-md-3">
          <div class="card" style="width: 15rem;">
            <img src="img/slider2.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

            <div class="card-body">
              <h5 class="card-title">Producto 1</h5>
              <p class="card-text">Descripción</p>                                        
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card" style="width: 15rem;">
            <img src="img/slider2.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

            <div class="card-body">
              <h5 class="card-title">Producto 2</h5>
              <p class="card-text">Descripción</p>                                        
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card" style="width: 15rem;">
            <img src="img/slider2.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

            <div class="card-body">
              <h5 class="card-title">Producto 3</h5>
              <p class="card-text">Descripción</p>                                        
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card" style="width: 15rem;">
            <img src="img/slider2.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

            <div class="card-body">
              <h5 class="card-title">Producto 4</h5>
              <p class="card-text">Descripción</p>                                        
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="footer-seccion">
            <ul class="list-group">
              <li class="list-group-item">
                <h3>Contacto</h3>
              </li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Morbi leo risus</li>
              <li class="list-group-item">Porta ac consectetur ac</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
          </div>
          <div class="footer-seccion">
            <ul class="list-group">
              <li class="list-group-item">
                <h3>De interes</h3>
              </li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Morbi leo risus</li>
              <li class="list-group-item">Porta ac consectetur ac</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
          </div>
          <div class="footer-seccion">
            <ul class="list-group">
              <li class="list-group-item">
                <h3>Newsletter</h3>
              </li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Morbi leo risus</li>
              <li class="list-group-item">Porta ac consectetur ac</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>
  <!--  
  
  -->
</template>

<script>
import axios from "axios";

export default {
  name: "Index",
  data() {
    return {
      email: "",
      password: "",
      showMessage: false,
      Loading: false,
      message: "",
    };
  },
  methods: {
    goRegister() {
      this.$router.push({ path: "register" });
    },
    goLogin() {
      this.$router.push({ path: "login" });
    },
  },
};
</script>
<style scoped>

</style>
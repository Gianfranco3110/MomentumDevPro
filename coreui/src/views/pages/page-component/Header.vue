<template>
    <header class=" navbar fixed-top navbar-expand-lg navbar-light bg-light px-4 header-main-modif">
        <div class="w-100 d-flex justify-content-between  align-items-center">
            <div>
                <!--<a class="text-white navbar-brand" href="#">YareStylo</a>-->
                <a class="text-white navbar-brand w-auto" href="#">
                    <div>
                        <img class="w-50" src="https://teboribrows.com/wp-content/uploads/2022/09/Logo-Tebori-Brows.webp" alt="Logo Tebori Brows" >
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse my-2"  id="navbarNavAltMarkup">
                <div class="navbar-nav m-auto">
                <a class="text-color-header nav-link active link-nav-mod" href="#">Inicio <span class="sr-only">(current)</span></a>
                <a v-if="logueado" class="nav-link text-color-header" @click="goDashboard()">            
                    Panel de control            
                </a>
                <a v-if="logueado == false" class="nav-link text-color-header link-nav-mod" @click="goLogin()">              
                    Iniciar Sesión              
                </a>
                <a v-if="logueado == false" class="nav-link text-color-header link-nav-mod" @click="goRegister()">              
                    Registrate              
                </a>
                </div>
            </div>
            <div>
                <a href="tel:+34622341648" class="action_button top-bar-right-button ">Llamanos!</a>
            </div>
        </div>
    </header>
  </template>
  
  <script>
  import axios from "axios";
  
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
  .link-nav-mod{
    font-size: 20px;
    padding-left: 8px;
    padding-right: 8px;
  }
  @media (min-width: 992px){
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
        background-color: #C38154 !important;
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
    .action_button, .action_button:hover {
        background-color: #884A39;
        color: #ffff;
    }
    .header-main-modif{
        background-color: #fff;
        opacity: .97;
        -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,0.1);
        -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.1);
        box-shadow: 0 2px 5px 0 rgba(0,0,0,0.1);
    }
  </style>
  
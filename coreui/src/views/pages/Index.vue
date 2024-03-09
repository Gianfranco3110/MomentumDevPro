<template>
	<div
		class="home">
		<!--<header class="botonesP navbar fixed-top navbar-expand-lg navbar-light bg-light px-3">
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
				    </header>-->
		<Headers/>
		<!--<div id="carousel-home" class="carousel slide" data-ride="carousel">
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
				    </div>-->

		<section class="section mcb-section mcb-section-video-maim has-video" style="">
			<div class="section_video">
				<video poster="" autoplay="true" loop="true" muted="muted" playsinline="true"><source type="video/mp4" src="https://teboribrows.com/wp-content/uploads/2021/09/shutterstock_1055920118.mov"></video>
			</div>
			<div class="mcb-background-overlay"></div>
			<div class="section_wrapper">
				<div class="wrap mcb-wrap one">
					<div class="mcb-wrap-inner ">
						<div class="column mcb-column mcb-item-video-text two-third">
							<div class="mcb-column-inner mcb-item-column-inner">
								<div class="column_attr mfn-inline-editor">
									<h2 class="h2-xxl">La mejor formación<br>en Microblading</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

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
										<img :src="$apiAdress +'/storage/courses/'+ item.image" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img"/>

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
			<a target="_blank" href="https://api.whatsapp.com/send?phone=584245064512&text=Hola que tál, me interesa obtener información de los cursos" class="btn p-0 floating-button">
				<i class="text-white fab fa-whatsapp w-auto"></i>
			</a>
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
			<div class="container container-footer">
				<div class="row pt-5 pb-5">
          <div class="col-md-3">
						<div class="footer-seccion">
              <div class="footer-msj-div">
                Expertos en <br>
                Belleza Natural
                <div class="social-links-footer">
                  <ul class="pl-0">
                  <li><a href="https://www.instagram.com/teboribrows/" target="_blank"><img decoding="async" src="../../../public/img/instagram.webp" alt="instagram"></a></li>
                  <li><a href="https://www.facebook.com/TeboriBrows/" target="_blank"><img decoding="async" src="../../../public/img/facebook-2.webp" alt="facebook"></a></li>
                  <li><a href="https://www.youtube.com/channel/UCgFGTGnisVwTTl98JTFH7-w" target="_blank"><img decoding="async" src="../../../public/img/youtube-1.webp" alt="youtube"></a></li>
                  <li><a href="https://api.whatsapp.com/send?phone=+34622341648&amp;text=%C2%A1Hola!" target="_blank"><img decoding="async" src="../../../public/img/whatsapp-1.webp" alt="whatsapp"></a></li>
                  </ul>
                </div>
              </div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="footer-seccion">
							<ul class="list-group">
								<li class="list-group-item footer-title">
									<h3 class="mb-4">Link</h3>
								</li>
								<li class="list-group-item link-hover-footer pt-0">
									INICIO
								</li>
								<li class="list-group-item link-hover-footer pt-0">
									INICIAR SESIÓN
								</li>
								<li class="list-group-item link-hover-footer pt-0">
									REGISTRATE
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-3">
						<div class="footer-seccion">
							<div class="div-footer-h">
                <h4>Horarios</h4>
                <ul class="pl-0">
                  <li>LUN - VIE:  10AM - 20PM</li>
                  <li>SÁBADOS:  11AM - 15PM</li>
                  <li>DÓMINGOS:  CERRADO</li>
                </ul>
              </div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="footer-seccion">
              <div class="div-footer-h">
                <h4>Información</h4>
                <ul class="info-iconos pl-0">
                <li><a href="https://g.page/TeboriBrows?share" class="text-white" target="_blank">Calle del General Díaz Porlier, 57, 28006 Madrid</a></li>
                <li><a href="tel:+34622341648" target="_blank" class="text-white">622 341 648</a></li>
                <li><a href="mailto:clientes@teboribrows.com" class="text-white" target="_blank">clientes@teboribrows.com</a></li>
                </ul>
              </div>
						</div>
					</div>
				</div>
			</div>
			<div class="row footer-copyright-seccion">
				<div class=" pt-4 m-auto mt-1 p-2">
					<div class="container">
						<p class="text-footer-botom">© 2021 YareStylo, Todos los derechos reservados.</p>
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
  import {freeSet} from "@coreui/icons";
  import General from "@/_mixins/general";
  import Headers from "./page-component/Header"

  export default {
    name: "Index",
    mixins: [General],
    freeSet,
    components: {
      Headers
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
        logueado: false
      };
    },
    methods: {
      getRowCount(Productitems) {
        return Productitems.length;
      },
      goRegister() {
        this.$router.push({path: "register"});
      },
      goLogin() {
        this.$router.push({path: "login"});
      },
      goDashboard() {
        this.$router.push({path: "Dashboard"});
      },
      getProducts() {
        let self = this;
        axios.get(this.$apiAdress + "/api/products?token=" + localStorage.getItem("api_token")).then(function (response) {
        self.Productitems = response.data;
        }).catch(function (error) {
        console.log(error);
        });
      },
      getCourses() {
        let self = this;
        axios.get(this.$apiAdress + "/api/courses?token=" + localStorage.getItem("api_token")).then(function (response) {
        console.log("Get course");
        console.log(response.data);
        self.Cursositems = response.data;
        }).catch(function (error) {
        console.log(error);
        });
      }
    },
    mounted: function () {
      this.getProducts();
      this.getCourses();
      let self = this;
      axios.get(this.$apiAdress + "/api/courses/mycourses?token=" + localStorage.getItem("api_token")).then(function (response) { // self.items = response.data;
      console.log("Response de pedro", response);
      self.logueado = true;
      }).catch(function (error) {
      console.log(error);
      self.logueado = false;
      });
    }
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

	@media only screen and(min-width:514px) {
		#seccion-estadisticas {
			padding: 0 50px;
			text-align: center;
		}
	}

	@media only screen and(max-width:513px) {
		#seccion-estadisticas {
			padding: 0;
			text-align: center;
		}
	}
	.footer-copyright-seccion {
		background-color: #864a39;
    border-top: 1px solid #f9e0bb5e;
    padding-bottom: 15px;
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
		background-color: #864a39;
	}
	.nav-link:hover {
		cursor: pointer;
	}

	/*-------------section video auto-------------*/
  .mcb-section-video-maim {
		padding-top: 130px;
		padding-bottom: 100px;
		background-image: url('../../../public/img/videohome/formacion-en-microblading-scaled.webp');
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
	}
	.section > .mcb-background-overlay {
		width: 100%;
		height: 100%;
		position: absolute;
		z-index: 1;
		top: 0;
		left: 0;
	}
	.mcb-section-video-maim .mcb-background-overlay {
		background-color: #00000080;
	}
	.section.has-video {
		position: relative;
		overflow: hidden;
	}
	.section.has-video .section_video {
		position: absolute;
		top: 0;
		left: 0;
		min-height: 100%;
		min-width: 100%;
		overflow: hidden;
	}
	.section.has-video .section_wrapper {
		position: relative;
	}
	.one.mcb-wrap {
		width: 100%;
		padding-bottom: 100px;
		padding-top: 100px;
	}

	.mcb-wrap {
		float: left;
		position: relative;
		z-index: 1;
		box-sizing: border-box;
	}
	.mcb-wrap,
	.mcb-wrap-inner,
	.section_wrapper {
		display: flex;
		align-items: flex-start;
		justify-content: center;
	}
	.mcb-column,
	.mcb-wrap,
	.section {
		background-position: 0 0;
		background-repeat: no-repeat;
	}
	.h2-xxl {
		font-size: 80px;
		line-height: 90px;
		font-family: "Playfair display";
		color: white;
	}
	.mcb-section .mcb-wrap .mcb-item-video-text .column_attr {
		text-align: center;
	}
	.mcb-item-column-inner {
		width: 100%;
		word-break: break-word;
	}
	.two-third.column {
		width: 100%;
	}
  /*-------------End section video auto-------------*/

/* --------------------------footer--------------------------*/
.container-footer{
    max-width: 1338px !important;
  }
  .social-links-footer {
      margin-top: 33px;
  }
  .social-links-footer ul {
      margin-left: 0px;
      list-style: none;
  }
  .social-links-footer ul li {
      display: inline-block;
      margin-right: 7px;
  }
  .social-links-footer ul li a img {
      height: 38px;
  }
  .footer-msj-div {
      font-family: "Playfair Display", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
      color: #F2E7DF !important;
      font-size: 41px;
      line-height: 54px;
  }
  .link-hover-footer:hover{
    cursor: pointer;
  }
  ul {
      list-style: none outside;
  }
  .div-footer-h ul li {
      padding: 0px 5px !important;
      margin-bottom: 3px !important;
      border: 1px solid rgba(0, 0, 0, .04);
      font-weight: 500 !important;
      text-transform: uppercase !important;
      font-size: 15px !important;
      color: #f2e7df !important;
      letter-spacing: 1px !important;
  }

  ul.info-iconos li {
      padding-left: 45px !important;
      background-image: url("../../../public/img/phone-footer.webp");
      background-position: top 0px left;
      background-repeat: no-repeat;
      background-size: 30px;
      margin-bottom: 11px !important;
      height: 51px;
  }
  ul.info-iconos li:first-child {
      background-image: url("../../../public/img/location.webp") !important;
  }
  ul.info-iconos li:last-child {
      background-image: url("../../../public/img/mailfooter.webp") !important;
  }
  .text-footer-botom{
    font-size: 20px;
    font-family: "Playfair Display", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif !important;
  }
  /*--------------------------------------------------------------End Footer--------------------------------------------------------------*/
</style>

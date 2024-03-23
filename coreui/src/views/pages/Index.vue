<template>

  <div class="home">
    <!--Header off the website-->
    <Headers />
    <!--End Header off the website-->

    <!--section video off the website-->
    <section
      class="section mcb-section mcb-section-video-maim has-video"
      style=""
    >
    <modalCourseDetails :modal="VerModalCourseDetail" @cerrarModal="VerModalCourseDetail = false" />
      <div class="section_video">
        <video
          poster=""
          autoplay="true"
          loop="true"
          muted="muted"
          playsinline="true"
        >
          <source
            type="video/mp4"
            src="https://teboribrows.com/wp-content/uploads/2021/09/shutterstock_1055920118.mov"
          />
        </video>
      </div>
      <div class="mcb-background-overlay"></div>
      <div class="section_wrapper">
        <div class="wrap mcb-wrap one">
          <div class="mcb-wrap-inner">
            <div class="column mcb-column mcb-item-video-text two-third">
              <div class="mcb-column-inner mcb-item-column-inner">
                <div class="column_attr mfn-inline-editor">
                  <h2 class="h2-xxl">
                    La mejor formación<br />en Microblading
                  </h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--End section video off the website-->

    <!--Section Course off the website-->
    <div id="seccion-cursos">
      <div class="container">
        <CCard class="bg-transparent border-0">
          <CCardHeader class="bg-transparent">
            <strong> CURSOS MAS POPULARES </strong>
          </CCardHeader>
          <CCardBody class="px-0">
            <CRow>
              <template>
                <CCol
                  md="6"
                  lg="4"
                  v-for="(item, index) in Cursositems"
                  :key="index"
                  class="d-flex justify-content-center"
                >
                  <div
                    class="card cursor-pointer border-0 course_box"
                    style="width: 19rem"
                    @click="VerModalCourseDetail = item"
                  >
                    <img
                      :src="$apiAdress + '/storage/courses/' + item.image"
                      class="bd-placeholder-img card-img-top"
                      width="100%"
                      height="180"
                      aria-label="Placeholder: Image cap"
                      role="img"
                    />

                    <div class="card-body text-center pb-5">
                      <h5 class="card-title fw-bold">{{ item.CourseName }}</h5>
                      <p class="card-text text-muted">{{ item.description }}</p>
                      <small class="card-text"
                        ><b>${{ item.price }}</b></small
                      >
                    </div>
                  </div>
                </CCol>
              </template>
            </CRow>
          </CCardBody>
        </CCard>
      </div>
    </div>
    <!--End Section Course off the website-->
    <!--Btn whatsapp float off the website-->
    <div>
      <a
        target="_blank"
        href="https://api.whatsapp.com/send?phone=584245064512&text=Hola que tál, me interesa obtener información de los cursos"
        class="btn p-0 floating-button"
      >
        <i class="text-white fab fa-whatsapp w-auto"></i>
      </a>
    </div>
    <!--End Btn whatsapp float off the website-->
    <Footer />
  </div>
</template>

<script>
import axios from "axios";
import { freeSet } from "@coreui/icons";
import General from "@/_mixins/general";
import Headers from "../../containers/Header.vue";
import Footer from "../../containers/TheFooter.vue";
import modalCourseDetails from "./modalCourseDetails";

function detail_curso(id) {
  console.log(id);
  // this.$router.push({
  //   name: "singleCourse",
  //   params: {
  //     id: id,
  //   },
  // });
  this.modalCourseDetails = true;
}

export default {
  name: "Index",
  mixins: [General],
  freeSet,
  components: {
    Headers,
    Footer,
    modalCourseDetails
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
      VerModalCourseDetail: false,
    };
  },
  methods: {
    detail_curso,
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
        .then(function (response) {
          self.Productitems = response.data;
        })
        .catch(function (error) {
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
        .then(function (response) {
          self.Cursositems = response.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  mounted: function () {
    this.getCourses();
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

/*-------------section video auto-------------*/
.mcb-section-video-maim {
  padding-top: 130px;
  padding-bottom: 100px;
  background-image: url("../../../public/img/videohome/formacion-en-microblading-scaled.webp");
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
  height: 70vh;
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
  /* line-height: 90px; */
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
</style>

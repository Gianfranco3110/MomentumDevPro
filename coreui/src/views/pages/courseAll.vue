<template>

    <div class="home">
      <!--Header off the website-->
      <Headers />
      <!--End Header off the website-->
      <modalCourseDetails :modal="VerModalCourseDetail"   @cerrarModal="VerModalCourseDetail = false" />
      <!--Section Course off the website-->
      <div class="seccion-cursos" id="seccion-cursos ">
        <div class="px-5">
          <CCard class="bg-transparent border-0">
            <CCardHeader class="botonesP mt-5 mt-md-0 text-white row d-flex align-items-center">
                <div class="col-md-8">
                    <p class="mb-0">{{totalCourse}} CURSOS DISPONIBLES </p>

                </div>
              <div class="col-md-4">
                <div class="input-group ">
                    <input  class="form-control" @focus="handleFocus" @blur="handleBlur" type="text" v-model="searchQuery" placeholder="Buscar curso...">
                    <span class="input-group-text" id="basic-addon1"><CIcon name="cil-search" /></span>
                </div>
                </div>
            </CCardHeader>
            <CCardBody class="px-0">
              <CRow>
                <template>
                  <CCol
                    md="6"
                    lg="3"
                    v-for="(item, index) in paginatedItems"
                    :key="index"
                    class="d-flex justify-content-center"
                  >
                    <div
                      class="card cursor-pointer border-0 course_box"
                    
                      @click="VerModalCourseDetail = item"
                    >
                        <div>
                        <img
                            :src="$apiAdress + '/api/courses/img/' + item.image"
                            class="bd-placeholder-img card-img-top"
                            width="100%"
                            height="180"
                            aria-label="Placeholder: Image cap"
                            role="img"
                        />
                        </div>
                      
  
                      <div class="card-body  pb-5 botonesP">
                        <div class="text-justify">
                          <h5 class="card-title fw-bold">{{ item.CourseName }}</h5>
                        <p class="card-text text-white">{{ truncateDescription(item.description,120) }}</p>
                        </div>
                       <div class="text-end mt-3">
                          <h5 class="text-white">${{ item.price }}</h5>
                       </div>
                      </div>
                    </div>
                  </CCol>
                </template>
              </CRow>
            </CCardBody>
            <div v-if="totalPages>1">
                <h3>Pagina: {{currentPage}}</h3>
                <CPagination
                    :activePage.sync="currentPage"
                    :pages="totalPages"
                    size="lg"
                    align="center"
                />
            </div>
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
    // this.modalCourseDetails = true;
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
        Loading: false,
        Productitems: [],
        Cursositems: [],
        user: "",
        logueado: false,
        VerModalCourseDetail: false,
        searchQuery: '',
        itemsPerPage: 8,
        currentPage: 1
      };
    },
    computed: {
        filteredItems() {
            return this.Cursositems.filter(item => {
            return (
            item.CourseName.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
            item.description.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        });
        },
        paginatedItems() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage; // 9 cursos por página
            const endIndex = startIndex + this.itemsPerPage;
            return this.filteredItems.slice(startIndex, endIndex);
        },
        totalPages() {
            return Math.ceil(this.filteredItems.length / this.itemsPerPage);
        },
        totalCourse() {
            return this.Cursositems.length;
        }
    },
    methods: {
        detail_curso,
        getRowCount(Productitems) {
            return Productitems.length;
        },
        getCourses() {
            let self = this;
            axios
            .get(
                this.$apiAdress +
                "/api/courses?limit=all&&token=" +
                localStorage.getItem("api_token")
            )
            .then(function (response) {
                console.log(response.data)
                self.Cursositems = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        truncateDescription(text, limit) {
            if (text.length <= limit) {
            return text;
            }
            return text.substring(0, limit) + "...";
        },
        handleFocus() {
            // Lógica a ejecutar cuando el input recibe foco
            console.log('Input enfocado');
           this.currentPage = 1
        },
        handleBlur() {
            // Lógica a ejecutar cuando el input pierde foco
            console.log('Input desenfocado'+ this.Cursositems.length);
            this.currentPage = 1;

        }
      
    },
    mounted: function () {
      this.getCourses();
    },
  };
  </script>
  <style scoped>

  .seccion-cursos{
    margin-top:7vw !important; 
  }
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
  
<template>
  <div >
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      :title="tituloModal"
      color="dark"
      size="lg"
      :closeOnBackdrop="false"
      :show.sync="VerModalCourseDetail"
    >
    <div slot="header" class="w-100 text-end">
      <b-btn
      size="sm"
        class=" btn bg-transparent p-1  b-0"
        @click="cerrarModal"
      >
        <CIcon class="text-white" name="cil-x" />
      </b-btn>
    </div>
    
      <div class="row g-0 p-2">
        <div class="col-md-12 col-lg-12 d-none d-md-block">
          <iframe
          v-if="ur_video_curso"
            class="w-100"
            height="415"
            :src="ur_video_curso"
            title="YouTube video player"
            frameborder="10"
            allowfullscreen
          ></iframe>
          <img
            v-if="!ur_video_curso"
            :src="$apiAdress + '/storage/courses/img_default.webp'"
                class="bd-placeholder-img card-img-top"
                width="100%"
                aria-label="Placeholder: Image cap"
                role="img"
            />
        </div>
        <div class="col-md-12 col-lg-12 d-flex align-items-center">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-body px-0 text-black">
                        <span class="badge bg-warning">TOP VENTAS</span>
                        <h2>{{ course.CourseName }}</h2>
                        <p class="lead">
                        {{ course.description }}
                        </p>
                        <div>
                            <p class="more-info">
                            <a href="#" @click="infoCourse">Más información
                            <CIcon class="mr-2" name="cil-arrow-right" />
                            </a></p>
                        </div>
                       
                    
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-body px-0 text-black">
                      
                        <div>
                        <button
                            @click="comprar(course)"
                            type="button"
                            class="btn btn-info w-100 d-flex align-items-center"
                        >
                            <CIcon class="mr-2" name="cil-cart" /> Comprar ,
                            <strong class="h5 mb-0">${{ course.price }} USD</strong>
                        </button>
                        </div>
                        <ul class="course-stats ml-0 pl-0 mb-3">
                        <li class=" pl-0">
                            <CIcon class="mr-2" name="cil-star" />Nivel:&nbsp;<span
                            class="badge text-dark badge--course-level-beginner"
                            >Iniciación</span
                            >
                        </li>
                        <li v-if="course.count_video > 0" class="pl-0">
                            <CIcon class="mr-2" name="cil-subtitles" />
                            {{ course.count_video }} lecciones (4h 40m)
                        </li>
                        <li v-if="course.count_estudent > 0" class="pl-0">
                            <CIcon class="mr-2" name="cil-user" />
                            {{ course.count_estudent }} Estudiantes
                        </li>
                        <li class="pl-0">
                            <CIcon class="mr-2" name="cil-thumb-up" />
                            100% valoraciones positivas (<a
                            class="link-underlined"
                            href="https://www.domestika.org/es/courses/5159-tipografia-de-marca-avanzada/reviews"
                            >2</a
                            >)
                        </li>
                        <li class="pl-0">
                            <CIcon class="mr-2" name="cil-smile" />
                            Online y a tu ritmo
                        </li>
                        <li class="pl-0">
                            <CIcon class="mr-2" name="cil-volume" />
                            Audio: Español
                        </li>
                        </ul>
                    
                    </div>
                </div>      
            </div>
          
        </div>
      </div>
      <template #footer >
       <div></div>
       
     </template>
    </CModal>
  </div>
</template>
  <script>
import axios from "axios";
import General from "@/_mixins/general";
//DATA
function data() {
  return {
    // VARIABLES
    VerModalCourseDetail: false,
    Loading: false,
    tituloModal: "",
    course: {},
    ur_video_curso:"",
  };
}

export default {
  name: "modalCourseDetails",
  data,
  mixins: [General],
  props: {
    modal: null,
  },
  watch: {
    modal: async function () {
      console.log("Pepito",this.VerModalCourseDetail);
      if (this.modal) {
        this.Loading= true;
        this.VerModalCourseDetail = true;
        // console.log(this.modal);
        //   this.tituloModal = this.modal.id;


        let dataResp = await this.getCourseDetailsLanding(this.modal.id);
        this.course = dataResp.course;
        localStorage.setItem('course', JSON.stringify(this.course));
        console.log(dataResp.course.video_presentation);
        this.ur_video_curso = dataResp.course.video_presentation==null? false :this.formLinkIframeVideo(dataResp.course.video_presentation.url_video);
        this.Loading= false;
      }
    }
  
  },
  methods: {
    infoCourse(){
        // this.VerModalCourseDetail = false;
        // console.log("hola");
          this.$router.push({
                name: "singleCourse",
                params: {
                id: this.course.id,
                },
            });
    },
    comprar(course){
      console.log(localStorage.getItem("id"));
      localStorage.setItem('comprar', 1);
      if (localStorage.getItem("id") === null) {
        this.$router.push({
                name: "Auth",
            });
      } else if (localStorage.getItem("id") === '' || localStorage.getItem("id") === null || localStorage.getItem("id") === undefined) {
        this.$router.push({
                name: "Auth",
            });
      } else {
          this.AssignCourse();
          // localStorage.removeItem("course");
      }

    },
    cerrarModal(){
      this.VerModalCourseDetail = false;
      localStorage.removeItem("course");
    },
    AssignCourse() {
      let self = this;
      self.Loading = true;
      axios
        .post(
          this.$apiAdress +
            "/api/usercourses/create?token=" +
            localStorage.getItem("api_token"),
          {
            course_id: this.course.id,
            user_id: localStorage.getItem("id"),
            status: '',
          }
        )
        .then(function(response) {
          console.log(response.data);
          self.Loading = false;
          // self.AddModal = false;
          self.$toastr.success("¡Curso asignado con exito!");
          self.$router.push({ path: "mis-cursos" });
        })
        .catch(function(error) {
            // Capturar y manejar los errores
          if (error.response) {
            // Error de respuesta del servidor
            const errorDetails = {
              status: error.response.status,
              data: error.response.data,
            };
            console.log(errorDetails);
            
            // Manejar errores específicos
            if ([404, 422, 500].includes(error.response.status)) {
              // Manejar errores 404, 422, 500
              // console.log("Error " + error.response.status + ": " + error.response.data);
              self.$toastr.warning("¡"+error.response.data.messague+"!");
            }
          } else if (error.request) {
            // Error de solicitud (sin respuesta del servidor)
            console.log("Error de solicitud:", error.request);
          } else {
            // Otros errores
            console.log("Error:", error.message);
          }
          self.Loading = false;
          
        });
    },
    
  },
  mounted: function () {
    this.cerrarModal();
  },

};
</script>
  <style scoped>
.course-stats {
  margin: 10px 0 0;
  list-style: none;
}
.course-stats li {
  position: relative;
  padding: 0 0 6px 24px;
  font-size: 0.8125rem;
}
.course-stats li i {
  position: absolute;
  left: 0;
  line-height: inherit;
}
.badge--course-level-beginner {
  background-color: #5bd881;
}
.badge {
  overflow: hidden;
  max-width: 100%;
  text-overflow: ellipsis;
  white-space: nowrap;
  word-wrap: normal;
  z-index: 2;
  padding: 0 0.25rem;
  line-height: 1.8em;
  vertical-align: middle;
  color: #fff;
  border-radius: 2px;
  transform: translateY(-1px);
}
.content-top {
  margin-top: 4vw;
}
</style>
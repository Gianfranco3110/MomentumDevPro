<template>
  <div id="cursos-usuario">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <div>
      <div class="row d-flex align-items-center">
          <div class="col-md-9">
            <h2 class="mb-0">Mis cursos</h2>
          </div>
          <div class="col-md-3">
            <div>
              <div class="input-group ">
                <input  class="form-control" type="text" v-model="searchQuery" placeholder="Buscar curso...">
                <span class="input-group-text" id="basic-addon1"><CIcon name="cil-search" /></span>
              </div>
            </div>
          </div>
      </div>
      <hr />
    </div>
    <div class="">
      <div class="row">
        <div
          class="col-lg-3 col-md-3"
          v-for="(item, index) in filteredItems"
          :key="index"
          @click="send_id_curso(item)"
        >
          <div class="card border-0 course_box">
            <!--<img src="..." class="card-img-top" alt="...">-->
            <iframe
              v-if="item.video_presentation != null"
              class="h-video-list bd-placeholder-img card-img-top"
              :src="item.video_presentation"
              title="YouTube video player"
              frameborder="10"
              allowfullscreen
            ></iframe>
            <img
              v-if="item.video_presentation == null"
              :src="$apiAdress + '/storage/courses/img_default.webp'"
              class="bd-placeholder-img card-img-top"
              width="100%"
              aria-label="Placeholder: Image cap"
              role="img"
            />
            <div class="card-body">
              <span class="badge rounded-pill bg-primary py-1 px-2 text-white mb-2" :class="'bg-'+item.status_video_class" style="border-radius: 0% !important;">{{item.status_video}}</span>
              <h5 class="card-title">
                <b>{{ item.name }}</b>
              </h5>
              <p class="card-text">{{ item.description }}</p>
              <CBadge color="success" v-if="item.status"> Pagado</CBadge>
              <CBadge v-if="!item.status" color="warning">
                Pendiente por pagar</CBadge
              >
            </div>
            <div class="card-footer">
              <div class="progress">
                <div
                  class="progress-bar"
                  role="progressbar"
                  style="width: 25%"
                  aria-valuenow="25"
                  aria-valuemin="0"
                  aria-valuemax="100"
                >
                  25%
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import General from "@/_mixins/general";

function send_id_curso(curso) {
    if(curso.status){
      if(curso.status_id_video == 1){
        this.$router.push({
          name: "show_course_user",
          params: {
            id: curso.course_id,
          },
        });
      }else if(curso.status_id_video == 2){
        this.alertNotifi("CURSO INACTIVO","El curso "+curso.name+", se encuentra inactivo, debes comunicarte con el administrador.");
      }else if(curso.status_id_video == 3){
        this.alertNotifi("CURSO EXPIRADO","El curso "+curso.name+" expiró, debes comunicarte con el administrador.");
      }
    }else{
      this.alertNotifi("CURSO PENDIENTE POR PAGAR","El curso "+curso.name+", esta pendiente por cancelar, debes comunicarte con el administrador.");
    }
 
}

export default {
  name: "UserCourses",
  mixins: [General],
  data: () => {
    return {
      Loading: false,
      items: [],
      searchQuery: ''
    };
  },
  computed: {
    filteredItems() {
      return this.items.filter(item => {
        return (
          item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          item.description.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      });
    }
  },
  methods: {
    send_id_curso,
    async getCourses() {
      let self = this;
      self.items = await self.getCourseUserAll(localStorage.getItem("id"));
    },
    alertNotifi(title,text){
      this.$swal
      .fire({
        title,
        text,
        icon: "warning",
        showCancelButton: false,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Cerrar",
      })
      .then((result) => {
       console.log("Hola")
      });
    }
  },
  mounted: function () {
    this.getCourses();
  },
};
</script>

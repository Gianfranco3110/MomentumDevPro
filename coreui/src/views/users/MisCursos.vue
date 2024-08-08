<template>
  <div id="cursos-usuario">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <div>
      <div class="row d-flex align-items-center">
        <CCardHeader class="text-center botonesP text-white col-md-10">
          <b>Mis cursos</b>
        </CCardHeader>
        <div class="col-md-2">
          <div>
            <div class="input-group">
              <input
                class="form-control"
                type="text"
                v-model="searchQuery"
                placeholder="Buscar curso..."
              />
              <span class="input-group-text" id="basic-addon1"
                ><CIcon name="cil-search"
              /></span>
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
              @click="send_id_curso(item)"
            ></iframe>
            <img
              v-if="item.video_presentation == null"
              :src="$apiAdress + '/api/courses/img/default.jpg'"
              class="bd-placeholder-img card-img-top"
              width="100%"
              aria-label="Placeholder: Image cap"
              role="img"
              @click="send_id_curso(item)"
            />
            <div @click="send_id_curso(item)" class="card-body botonesP">
              <span
                v-if="item.status_id_video == 3"
                class="badge rounded-pill bg-primary py-1 px-2 text-white mb-2"
                :class="'bg-' + item.status_video_class"
                style="border-radius: 0% !important"
                >{{ item.status_video }}</span
              >
              <h5 class="card-title text-white">
                {{ truncateDescription(item.name,50) }}
              </h5>
              <p class="card-text">{{ truncateDescription(item.description,100) }}</p>
              <CBadge class="text-white" color="success" v-if="item.status">
                Pagado</CBadge
              >
              <CBadge class="text-white" v-if="!item.status" color="warning">
                Pendiente por pagar</CBadge
              >
            </div>
            <div class="card-footer">
              <div @click="send_id_curso(item)" class="progress">
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
              <CCol v-if="item.certificado === '1'" @click="GetPdf(item.course_id)" sm="12" class="pl-0 mt-4">
                <CButton class="botonesCan text-white">
                  <CIcon name="cil-education" />
                  Generar Certificado
                </CButton>
              </CCol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import General from "@/_mixins/general";
import axios from "axios";


function send_id_curso(curso) {
  if (curso.status) {
    if (curso.status_id_video == 1) {
      this.$router.push({
        name: "show_course_user",
        params: {
          id: curso.course_id,
        },
      });
    } else if (curso.status_id_video == 2) {
      this.alertNotifi(
        "CURSO INACTIVO",
        "El curso " +
          curso.name +
          ", se encuentra inactivo, debes comunicarte con el administrador."
      );
    } else if (curso.status_id_video == 3) {
      this.alertNotifi(
        "CURSO EXPIRADO",
        "El curso " +
          curso.name +
          " expiró, debes comunicarte con el administrador."
      );
    }
  } else {
    this.alertNotifi(
      "CURSO PENDIENTE POR PAGAR",
      "El curso " +
        curso.name +
        ", esta pendiente por cancelar, debes comunicarte con el administrador."
    );
  }
}

function GetPdf(course_id) {
  let self = this;
  self.Loading = true;
  let listado = [];
  self.items = [];
  axios
    .post(
      this.$apiAdress +
        "/api/usercertificado" +
        "?token=" +
        localStorage.getItem("api_token"),
      {
        user_id: localStorage.getItem("id"),
        course_id: course_id,
      }
    )
    .then(function (response) {
      console.log(response.data);
      listado = response.data;

      window.open(response.data.certificado_url, "_blank");
      self.Loading = false;
      self.getCourses();
      self.$toastr.success("¡Certificado generado con exito!");
    })
    .catch(function (error) {
      console.log(error);
      console.log(listado);
      self.getCourses();
      self.Loading = false;
      //self.$router.push({ path: "/login" });
    });
}
export default {
  name: "UserCourses",
  mixins: [General],
  data: () => {
    return {
      Loading: false,
      items: [],
      searchQuery: "",
    };
  },
  computed: {
    filteredItems() {
      return this.items.filter((item) => {
        return (
          item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          item.description
            .toLowerCase()
            .includes(this.searchQuery.toLowerCase())
        );
      });
    },
  },
  methods: {
    truncateDescription(text, limit) {
      if (text.length <= limit) {
        return text;
      }
      return text.substring(0, limit) + "...";
    },
    send_id_curso,
    GetPdf,
    async getCourses() {
      let self = this;
      self.items = await self.getCourseUserAll(localStorage.getItem("id"));
    },
    alertNotifi(title, text) {
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
          console.log("Hola");
        });
    },
  },
  mounted: function () {
    this.getCourses();
  },
};
</script>
<style scoped>
iframe {
  height: 30vh !important;
}
img {
  height: 30vh !important;
}
svg {
  color: white !important;
}
</style>

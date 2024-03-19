<template>
  <div id="cursos-usuario">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <h1>Mis cursos</h1>

    <hr />
    <CRow>
      <!--
            <CCol md="4" v-for="(item, index) in items" :key="index">
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
                      <CRow class="mt-2">
                        <CCol style="text-align:Center">
                            <a href="#" class="btn btn-success">Ver curso</a>
                        </CCol>
                      </CRow>
                    </div>
                  </div>
                </CCol>  
                -->
      <CCol v-if="!show_curso" md="12">
        <div class="card" v-for="(item, index) in items" :key="index">
          <div class="card-body">
            <CRow>
              <CCol md="6">
                <CRow>
                  <CCol md="3">
                    <img
                      :src="$apiAdress + '/storage/courses/' + item.image"
                      class="bd-placeholder-img card-img-top"
                      width="80"
                      height="80"
                      aria-label="Placeholder: Image cap"
                      role="img"
                    />
                  </CCol>
                  <CCol md="3">
                    {{ item.CourseName }}
                  </CCol>
                  <CCol md="3">
                    {{ item.Video }}
                  </CCol>
                  <CCol md="3">
                    <CBadge :color="getBadge(item.status)">{{
                      item.status
                    }}</CBadge>
                  </CCol>
                </CRow>
              </CCol>
              <CCol md="6">
                <CRow>
                  <CCol md="12 " class="text-end">
                    <button
                      @click="viewsCourseUser(item.course_id)"
                      class="btn btn-success"
                    >
                      Ver
                    </button>
                  </CCol>
                </CRow>
              </CCol>
            </CRow>
          </div>
        </div>
      </CCol>
      <div class="col-md-12" v-if="show_curso">
        <CRow class="w-100">
          <CCol sm="6" class="row">
            <iframe
              class="w-100"
              height="415"
              :src="ur_video_curso"
              title="YouTube video player"
              frameborder="10"
              allowfullscreen
            ></iframe>
            <CCol sm="3">
              <CButton @click="move_video()" color="success">
                <CIcon name="cil-check-circle" />&nbsp; Leccion anterior
              </CButton>
            </CCol>
            <CCol sm="3">
              <CButton id="next" color="dark">
                <CIcon name="cil-chevron-circle-left-alt" />&nbsp; Leccion
                siguiente
              </CButton>
            </CCol>
          </CCol>

          <CCol sm="6">
            <div class="card">
              <div class="card-header h4 text-center mb-0">
                {{ titleVideo }}
              </div>
              <div class="card-body pt-0 pb-0">
                <ol
                  v-for="(videos, sectionName) in Secciones"
                  :key="sectionName"
                  class="list-group list-group-numbered"
                >
                  <li class="b-b-ligth px-0 list-group-item">
                    <div
                      class="w-100 d-flex justify-content-between align-items-start"
                    >
                      <div
                        @click="
                          collapsedSection =
                            collapsedSection === sectionName
                              ? null
                              : sectionName
                        "
                      >
                        <div class="fw-bold text-bold customs-section">
                          {{ sectionName }}
                        </div>
                      </div>
                      <span class="badge bg-primary rounded-pill text-white">
                        {{ videos.length }}
                      </span>
                    </div>
                    <CCollapse :show="collapsedSection === sectionName">
                      <CListGroup>
                        <CListGroupItem
                          v-for="video in videos"
                          :key="video.id_video"
                        >
                          <p
                            class="customs-section"
                            @click="send_url_video(video.url_video)"
                          >
                            Descripción: {{ video.description_video }}
                          </p>
                        </CListGroupItem>
                      </CListGroup>
                    </CCollapse>
                  </li>
                </ol>
              </div>
              <div class="card-footer text-body-secondary">2 days ago</div>
            </div>
          </CCol>
        </CRow>
      </div>
    </CRow>
  </div>
</template>
<script>
import axios from "axios";
import General from "@/_mixins/general";

function move_video() {
  console.log("1");
  if (this.secciones && this.ur_video_curso) {
    for (let key in this.Secciones) {
      console.log("2");
      console.log("seccion", this.secciones[key]);
      let seccion = this.secciones[key];
      console.log("seccion", seccion);
      for (let i = 0; i < seccion.length; i++) {
        console.log("3");
        if (seccion[i].url_video === ur_video_curso) {
          // Verificamos si hay un siguiente elemento en la sección
          if (i < seccion.length - 1) {
            let siguienteURL = seccion[i + 1].url_video;
            this.ur_video_curso = siguienteURL;
            console.log("La URL del video siguiente es: " + siguienteURL);
          } else {
            console.log("No hay un video siguiente en esta sección.");
          }
          break; // Salimos del bucle una vez encontramos la URL actual
        }
      }
    }
  }
}

function viewsCourseUser(id_curso) {
  console.log("id", id_curso);
  let self = this;
  self.Loading = true;
  /* const data =  {
    id_curso: id_curso,
    id_user: localStorage.getItem("id")
  }; */
  axios
    .get(
      this.$apiAdress +
        "/api/viewcoursestart/" +
        id_curso +
        "/" +
        localStorage.getItem("id") +
        "?token=" +
        localStorage.getItem("api_token")
    )
    .then(function (response) {
      console.log("response", response);
      self.Secciones = response.data.groupedVideos;
      self.titleVideo = response.data.courseName;
      console.log("Secciones", self.Secciones);
      self.Loading = false;
      self.show_curso = true;
    })
    .catch(function (error) {
      console.log(error);
    });
}

function send_url_video(val) {
  console.log("val", val);
  this.ur_video_curso = val;
}

export default {
  name: "UserCourses",
  mixins: [General],
  components: {
    General,
  },
  data: () => {
    return {
      Loading: false,
      items: [],
      ur_video_curso: "https://www.youtube.com/embed/xo9ZPZRPEB8",
      Secciones: [],
      titleVideo: "",
      show_curso: false,
      collapsedSection: null,
    };
  },
  methods: {
    move_video,
    send_url_video,
    getCourses() {
      let self = this;
      self.Loading = true;
      axios
        .get(
          this.$apiAdress +
            "/api/usercourses/" +
            localStorage.getItem("id") +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function (response) {
          self.items = response.data;
          console.log("response.data");
          console.log(response.data);
          self.Loading = false;
        })
        .catch(function (error) {
          console.log(error);
          //self.$router.push({ path: "/login" });
        });
    },
    viewsCourseUser,
  },
  mounted: function () {
    this.getCourses();
  },
};
</script>
<style scoped>
.customs-section {
  cursor: pointer;
}
</style>

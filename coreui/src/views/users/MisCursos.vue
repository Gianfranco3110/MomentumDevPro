<template>
  <div id="cursos-usuario">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <div v-if="!show_curso">
      <h2>Mis cursos</h2>
      <hr />
    </div>

    <CRow>
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
            <CCol sm="6" class="pl-0 mt-3">
              <CButton @click="move_video(1)" color="success">
                <CIcon name="cil-check-circle" />&nbsp; Leccion anterior
              </CButton>
            </CCol>
            <CCol sm="6" class="text-end pr-0 mt-3">
              <CButton @click="move_video(2)" id="next" color="dark">
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

function move_video(val) {
  let currentSection = null;
  let currentIndex = -1;

  // Encontrar la sección y el índice del video actual
  for (let section of Object.keys(this.Secciones)) {
    let index = this.Secciones[section].findIndex(
      (video) => video.url_video === this.ur_video_curso
    );
    if (index !== -1) {
      currentSection = section;
      currentIndex = index;
      break;
    }
  }

  if (currentSection === null || currentIndex === -1) {
    return; // No se encontró el video actual
  }

  if (val === 1) {
    // Video anterior
    if (currentIndex > 0) {
      this.ur_video_curso =
        this.Secciones[currentSection][currentIndex - 1].url_video;
    } else {
      // Ir al último video de la sección anterior
      let prevSection = Object.keys(this.Secciones)[
        Object.keys(this.Secciones).indexOf(currentSection) - 1
      ];
      if (prevSection) {
        this.ur_video_curso =
          this.Secciones[prevSection][
            this.Secciones[prevSection].length - 1
          ].url_video;
      }
    }
  } else {
    // Video siguiente
    if (currentIndex < this.Secciones[currentSection].length - 1) {
      this.ur_video_curso =
        this.Secciones[currentSection][currentIndex + 1].url_video;
    } else {
      // Ir al primer video de la siguiente sección
      let nextSection = Object.keys(this.Secciones)[
        Object.keys(this.Secciones).indexOf(currentSection) + 1
      ];
      if (nextSection) {
        this.ur_video_curso = this.Secciones[nextSection][0].url_video;
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
      ur_video_curso: "",
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

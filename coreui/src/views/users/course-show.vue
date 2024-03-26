<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CRow>
      <CRow class="w-100">
        <CCol v-if="show_curso" sm="6" class="row">
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
        <CCol v-if="show_task" sm="6">
          <Quick :show="show_task" :data="data_task" :tipo="'1'" />
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
                          collapsedSection === sectionName ? null : sectionName
                      "
                    >
                      <div class="fw-bold text-bold customs-section">
                        {{ sectionName }}
                      </div>
                    </div>
                    <span
                      @click="
                        collapsedSection =
                          collapsedSection === sectionName ? null : sectionName
                      "
                      class="rounded-pill text-black cursor-pointer"
                    >
                      <CIcon name="cil-caret-bottom" />
                    </span>
                  </div>
                  <CCollapse
                    id="customs-li"
                    :show="collapsedSection === sectionName"
                  >
                    <CListGroup>
                      <CListGroupItem
                        v-for="video in videos"
                        :key="video.id_video"
                      >
                        <div class="flex d-flex">
                          <input
                            type="checkbox"
                            @click="selectVideo(video.id_video)"
                          />

                          <p
                            class="customs-section ml-2 mt-3"
                            @click="send_url_video(video.url_video)"
                          >
                            Descripción: {{ video.description_video }}
                          </p>
                        </div>
                      </CListGroupItem>
                    </CListGroup>
                    <p
                      @click="show_question(videos[0].course_section_id)"
                      v-if="
                        videos.length > 0 && videos[0].question_user.length > 0
                      "
                    >
                      Iniciar cuestionario:
                      {{ videos[0].question_user[0].question }}
                    </p>
                  </CCollapse>
                </li>
              </ol>
            </div>
            <div class="card-footer text-body-secondary">2 days ago</div>
          </div>
        </CCol>
      </CRow>
    </CRow>
  </div>
</template>

<script>
import Quick from "../../components/Quick.vue";
import General from "@/_mixins/general";
import axios from "axios";


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

function show_question(id_seccion) {
  console.log('show_question',id_seccion);
  this.show_curso = false;
  this.show_task = true;

}

function viewsCourseUser(id_curso) {
  let self = this;
  self.Loading = true;
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
      self.ur_video_curso = response.data.first_video_url;
      self.Loading = false;
    })
    .catch(function (error) {
      console.log(error);
    });
}

function send_url_video(val) {
  this.ur_video_curso = val;
  this.show_curso = true;
  this.show_task = false;
}

export default {
  name: "Course-show-user",
  mixins: [General],
  components: {
    Quick,
  },
  data: () => {
    return {
      Loading: false,
      ur_video_curso: "",
      Secciones: [],
      titleVideo: "",
      show_curso: true,
      collapsedSection: null,
      show_task: false,
      id_curso: "",
      data_task: [
        {
          title: "hola input",
        },
        {
          title: "hola check",
        },
        {
          title: "hola check",
        },
        {
          title: "hola check",
        },
        {
          title: "hola check",
        },
        {
          title: "hola check",
        },
        {
          title: "hola check",
        },
      ],
    };
  },
  methods: {
    show_question,
    move_video,
    send_url_video,
    viewsCourseUser,
  },
  mounted: function () {
    this.viewsCourseUser(this.$route.params.id);
  },
};
</script>
<style scoped>
.customs-section {
  cursor: pointer;
}
#customs-li li {
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}
</style>

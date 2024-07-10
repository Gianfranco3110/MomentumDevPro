<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CRow>
      <CRow class="w-100">
        <CCol v-if="show_curso" sm="6">
          <iframe
            class="w-100"
            height="415"
            :src="ur_video_curso"
            title="Yari-cursos"
            frameborder="10"
            allowfullscreen
          />
          <CCol sm="12" class="d-flex justify-content-between mt-3 mb-3">
            <CButton class="botonesCan text-white btn-sm" @click="move_video(1)">
              <CIcon name="cil-chevron-circle-left-alt" />&nbsp; Lección anterior
            </CButton>
          <CButton class="btn-sm" @click="move_video(2)" id="next" color="dark">
            Lección siguiente &nbsp;<CIcon name="cil-chevron-circle-right-alt" />
          </CButton>
        </CCol>
        </CCol>
        <CCol v-if="show_task" sm="6">
          <Quick
            ref="refModal_"
            :show="show_task"
            :data="data_task"
            :tipo="type_question"
          />
        </CCol>
        <CCol sm="6">
          <div class="card">
            <div class="card-header h4 text-center mb-0 botonesP text-white">
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
                            @click="selectVideo(video.url_video)"
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
                    <div class="col-md-12">
                      <CButton
                        class="btn-block botonesP text-white"
                        v-if="
                          videos.length > 0 &&
                          videos[0].question_user.length > 0
                          && !videos[0].question_user[0].user_answered
                        "
                        @click="show_question(videos[0].question_user)"
                      >
                        <CIcon name="cil-task" />&nbsp; Iniciar cuestionario
                      </CButton>
                    </div>
                  </CCollapse>
                </li>
              </ol>
            </div>
            
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

function selectVideo(url) {
  console.log("id", url);
  let self = this;
  self.Loading = true;
  axios
    .post(
      this.$apiAdress +
        "/api/position/urlcurso/?token=" +
        localStorage.getItem("api_token"),
      {
        course_id: this.$route.params.id,
        url: url,
      }
    )
    .then(function (response) {
      console.log(response);
      self.Loading = false;
    })
    .catch(function (error) {
      console.log(error);
      self.Loading = false;
    });
}

function move_video(val) {
  let currentSection = null;
  let currentIndex = -1;

  // Encontrar la sección y el índice del video actual
  for (let section of Object.keys(this.Secciones)) {
    let index = this.Secciones[section].findIndex(
      (video) =>
        video.url_video === this.ur_video_curso
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
      this.ur_video_curso = this.Secciones[currentSection][currentIndex - 1].url_video;
      ;
    } else {
      // Ir al último video de la sección anterior
      let prevSection = Object.keys(this.Secciones)[
        Object.keys(this.Secciones).indexOf(currentSection) - 1
      ];
      if (prevSection) {
        this.ur_video_curso = this.Secciones[prevSection][this.Secciones[prevSection].length - 1].url_video;
      }
    }
  } else {
    // Video siguiente
    if (currentIndex < this.Secciones[currentSection].length - 1) {
      this.ur_video_curso = this.Secciones[currentSection][currentIndex + 1].url_video;
    } else {
      // Validar si el usuario ha respondido el cuestionario de la sección actual
      if (!this.Secciones[currentSection][0].question_user[0].user_answered) {
        console.log(
          "s",
          this.Secciones[currentSection][0].question_user[0].user_answered
        );
        this.$swal.fire({
          title: "",
          text: "Debes completar el test de la sección actual antes de avanzar.",
          icon: "warning",
          showCancelButton: false,
          cancelButtonColor: "#d33",
        });
        return;
      }

      // Ir al primer video de la siguiente sección
      let nextSection = Object.keys(this.Secciones)[
        Object.keys(this.Secciones).indexOf(currentSection) + 1
      ];
      if (nextSection) {
        this.ur_video_curso =this.Secciones[nextSection][0].url_video;
      }
    }
  }
}

function show_question(question) {
  const vm = this;
  vm.show_curso = false;
  vm.show_task = true;

  vm.type_question = question[0].type_question;
  if (vm.type_question === "3") {
    //showQuestionMultiple(question[0].id);
   
    vm.Loading = true;
    axios
      .get(
        vm.$apiAdress +
          "/api/questionfields/listoptionsquestion/" +
          vm.$route.params.id +
          "/" +
          vm.type_question +
          "?token=" +
          localStorage.getItem("api_token")
      )
      .then(function (response) {
        console.log("responsePreguntas", response.data);
        vm.data_task = response.data;
        console.log("vm", vm.data_task);
        vm.Loading = false;
      })
      .catch(function (error) {
        console.log(error);
      });
  } else vm.data_task = question;
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
      self.Secciones = response.data.groupedVideos;
      self.titleVideo = response.data.courseName;
      self.ur_video_curso = response.data.first_video_url;
      self.Loading = false;
      console.log('1',response);
    })
    .catch(function (error) {
      console.log(error);
    });
}

function showQuestionMultiple(id_question) {
  console.log("id_question", id_question);

  this.Loading = true;
  axios
    .get(
      this.$apiAdress +
        "/api/questionfields/listoptionsquestion/" +
        id_question +
        "?token=" +
        localStorage.getItem("api_token")
    )
    .then(function (response) {
      console.log("responsePreguntas", response);
      this.data_task = response.data;
      this.Loading = false;
    })
    .catch(function (error) {
      console.log(error);
    });
}

function send_url_video(val) {
  let currentSection = null;

  // Encontrar la sección actual
  /*for (let section of Object.keys(this.Secciones)) {
    let index = this.Secciones[section].findIndex(
      (video) =>
        this.formLinkIframeVideo(video.url_video) === this.ur_video_curso
    );
    if (index !== -1) {
      currentSection = section;
      break;
    }
  }

  // Verificar si se está cambiando de sección
  if (this.formLinkIframeVideo(val) !== this.ur_video_curso) {
    let nextSection = Object.keys(this.Secciones)[Object.keys(this.Secciones).indexOf(currentSection) + 1];
    if (nextSection && !this.Secciones[currentSection].user_answered) {
      alert('Debes completar el test de la sección actual antes de cambiar de sección.');
      return;
    }
  }
*/
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
      type_question: "",
      data_task: null,
    };
  },
  methods: {
    show_question,
    move_video,
    send_url_video,
    viewsCourseUser,
    showQuestionMultiple,
    selectVideo,
  },
  mounted: function () {
    this.viewsCourseUser(this.$route.params.id);
    this.$bus.$on('sendanswer', () => {
      this.show_curso = true;
      this.show_task = false;
      this.move_video(2);
      this.viewsCourseUser(this.$route.params.id);
    });
  },
  destroyed() {
    this.$bus.$off("sendanswer");
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
#customs-li p {
  color: black !important;
}
svg {
  color: white !important;
}
@media only screen and (max-width: 1400px) {
  iframe {
    height: 28vh !important;
  }
}
</style>

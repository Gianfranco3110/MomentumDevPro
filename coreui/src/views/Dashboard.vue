<template>
  <div>
    <!--
    <CCardGroup class="mb-4">
      <CRow lg="12" style="width:100%">
        <CCol sm="6" lg="3">
          <CWidgetProgressIcon
            header="87.500"
            text="Visitors"
            color="info"
            inverse
          >
            <CIcon name="cil-people" height="36" />
          </CWidgetProgressIcon>
        </CCol>
        <CCol sm="6" lg="3">
          <CWidgetProgressIcon
            header="385"
            text="New Clients"
            color="success"
            inverse
          >
            <CIcon name="cil-userFollow" height="36" />
          </CWidgetProgressIcon>
        </CCol>
        <CCol sm="6" lg="3">
          <CWidgetProgressIcon
            header="1238"
            text="Products sold"
            color="warning"
            inverse
          >
            <CIcon name="cil-basket" height="36" />
          </CWidgetProgressIcon>
        </CCol>
        <CCol sm="6" lg="3">
          <CWidgetProgressIcon
            header="28%"
            text="Returning Visitors"
            color="primary"
            inverse
          >
            <CIcon name="cil-chartPie" height="36" />
          </CWidgetProgressIcon>
        </CCol>
      </CRow>
    </CCardGroup>
-->

    <div>
      <CRow class="w-100">
        <CCol sm="6">
          <iframe
            class="w-100"
            height="415"
            :src="ur_video_curso"
            title="YouTube video player"
            frameborder="10"
            allowfullscreen
          ></iframe>
          <br />
          <br />
          <CCol sm="3">
            <CButton color="success">
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
                          collapsedSection === sectionName ? null : sectionName
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
                        <p @click="send_url_video(video.url_video)">Descripción: {{ video.description_video }}</p>
                        <p>Url: {{ video.url_video }}</p>
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
  </div>
</template>

<script>
import axios from "axios";

function send_url_video(val){
  console.log('val',val);
}

function obtenerCourse() {
  let self = this;
  self.Loading = true;
  axios
    .get(
      this.$apiAdress +
        "/api/viewcoursestart/" +
        localStorage.getItem("id") +
        "?token=" +
        localStorage.getItem("api_token")
    )
    .then(function (response) {
      console.log("response", response);
      self.Secciones = response.data.groupedVideos;
      self.titleVideo = response.data.courseName
      console.log("Secciones", self.Secciones);
      self.Loading = false;
    })
    .catch(function (error) {
      console.log(error);
    });
}
export default {
  name: "Dashboard",
  data() {
    return {
      isAdmin: false,
      collapsedSection: null,
      Secciones: [],
      titleVideo: "",
      ur_video_curso:"https://www.youtube.com/embed/xo9ZPZRPEB8"
     
    };
  },
  methods: {
    color(value) {
      let $color;
      if (value <= 25) {
        $color = "info";
      } else if (value > 25 && value <= 50) {
        $color = "success";
      } else if (value > 50 && value <= 75) {
        $color = "warning";
      } else if (value > 75 && value <= 100) {
        $color = "danger";
      }
      return $color;
    },
    obtenerCourse,
    send_url_video
  },

  mounted: function () {
    if (localStorage.getItem("roles") == "user,admin") {
      this.isAdmin = true;
    }
    this.obtenerCourse();
    /*
    let self = this;
    self.Loading = true;
    axios
      .get(
        this.$apiAdress +
          "/api/courses/mycourses?token=" +
          localStorage.getItem("api_token")
      )
      .then(function(response) {
        self.items = response.data;
        self.Loading = false;
      })
      .catch(function(error) {
        console.log(error);
        self.$router.push({ path: "/login" });
      });
      */
  },
};
</script>
<style scoped>
#next {
  float: right;
}
.customs-section{
  cursor: pointer;
}
</style>
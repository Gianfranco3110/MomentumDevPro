<template>
  <div>
    <CRow class="w-100"> </CRow>
  </div>
</template>

<script>
import axios from "axios";

function send_url_video(val) {
  console.log("val", val);
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
      self.titleVideo = response.data.courseName;
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
      ur_video_curso: "https://www.youtube.com/embed/xo9ZPZRPEB8",
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
    send_url_video,
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
.customs-section {
  cursor: pointer;
}
</style>

<template>
  <div id="cursos-usuario">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <div>
      <h2>Mis cursos</h2>
      <hr />
    </div>
    <div class="">
      <div class="row">
        <div
          class="col-lg-3 col-md-3"
          v-for="(item, index) in items"
          :key="index"
          @click="send_id_curso(item.course_id)"
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

function send_id_curso(id) {
  this.$router.push({
    name: "show_course_user",
    params: {
      id: id,
    },
  });
}

export default {
  name: "UserCourses",
  mixins: [General],
  data: () => {
    return {
      Loading: false,
      items: [],
    };
  },
  methods: {
    send_id_curso,
    async getCourses() {
      let self = this;
      self.items = await self.getCourseUserAll(localStorage.getItem("id"));
    },
  },
  mounted: function () {
    this.getCourses();
  },
};
</script>

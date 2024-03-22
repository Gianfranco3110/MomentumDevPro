<template>
  <div>
    <Headers />
    <CContainer fluid>
      <CCard class="px-3 mx-5 content-top">
        <CCardBody class="pt-5 pb-5">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <iframe
              class="w-100"
              height="415"
              :src="ur_video_curso"
              title="YouTube video player"
              frameborder="10"
              allowfullscreen
            ></iframe>
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <span class="badge bg-warning">TOP VENTAS</span>
                <h2>{{course.CourseName}}</h2>
                <p class="lead">
                  {{course.description}}
                </p>
  
                <ul class="course-stats ml-0 pl-0 mb-3">
                  <li class="course-level">
                    <CIcon class="mr-2" name="cil-star"/>Nivel:&nbsp;<span
                      class="badge text-dark badge--course-level-beginner"
                      >Iniciación</span
                    >
                  </li>
                  <li v-if="course.count_video > 0" class="hours-stat">
                    <CIcon class="mr-2"  name="cil-subtitles"/>
                    {{course.count_video}} lecciones (4h 40m)
                  </li>
                  <li v-if="course.count_estudent > 0" class="users-stat">
                    <CIcon class="mr-2"  name="cil-user"/>
                    {{course.count_estudent}} Estudiantes
                  </li>
                  <li class="opinions-stat">
                    <CIcon class="mr-2"  name="cil-thumb-up"/>
                    100% valoraciones positivas (<a
                      class="link-underlined"
                      href="https://www.domestika.org/es/courses/5159-tipografia-de-marca-avanzada/reviews"
                      >2</a
                    >)
                  </li>
                  <li class="online">
                    <CIcon class="mr-2"  name="cil-smile"/>
                    Online y a tu ritmo
                  </li>
                  <li>
                    <CIcon class="mr-2"  name="cil-volume"/>
                    Audio: Español
                  </li>
                  
                </ul>
                <div>
                  <button type="button" class="btn btn-info  d-flex align-items-center"><CIcon class="mr-2"  name="cil-cart"/> Comprar , <strom class="h5 mb-0">${{course.price}} USD</strom></button>
                </div>
              </div>
            </div>
          </div>
        </CCardBody>
      </CCard>
    </CContainer>
    <Footer />
  </div>
</template>
<script>
import Headers from "../../containers/Header.vue";
import Footer from "../../containers/TheFooter.vue";
import General from "@/_mixins/general";

function mounted() {
  console.log("id_course", this.$route.params.id);
}

export default {
  name: "courseDetail",
  components: {
    Headers,
    Footer,
  },
  mixins: [General],
  data(){
    return{
      ur_video_curso:"https://www.youtube.com/embed/xo9ZPZRPEB8",
      course:{}
    }
  },
  methods: {
    async getcourses() {
     let dataResp =  await this.getCourseDetailsLanding(this.$route.params.id);
     this.course = dataResp.course;
    //  console.log(dataResp);
    },
  },
  mounted: function() {
     this.getcourses()
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
    font-size: .8125rem;
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
.content-top{
  margin-top: 4vw;
}
</style>

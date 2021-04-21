<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      title="ASIGNAR CURSO"
      :closeOnBackdrop="false"
      color="dark"
      size="lg"
      :show.sync="AddModal"
    >
      <CCard no-header>
        <CCardBody>
          <CSelect
            label="CURSOS DISPONIBLES"
            :value.sync="courseData.course_id"
            :plain="true"
            :options="courses"
          >
          </CSelect>
          <CSelect
            label="ESTADO"
            :value.sync="courseData.status"
            :plain="true"
            :options="statuses"
          >
          </CSelect>     
        </CCardBody>
      </CCard>

      <template #footer>
        <CButton color="success" @click="AssignCourse">
          <CIcon name="cil-check-circle" />&nbsp; ASIGNAR
        </CButton>
        <CButton color="dark" @click="AddModal = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>
<script>
import General from "@/_mixins/general";
import axios from "axios";

function data() {
  return {
    // VARIABLES
    AddModal: false,
    Loading: false,
    user_name: "",
    courseData: {
      course_id: 1,
      user_id: 1,
      status: '',
    },
    courses: [],
    statuses: ['Pagado','No pagado'],
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
  },
  watch: {
    modal: function() {
      if (this.modal) {
        this.AddModal = true;
        if (this.modal != false) {
          this.user_name = this.modal.name;
          this.courseData.user_id = this.modal.id;          
        }
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    AssignCourse() {
      let self = this;
      self.Loading = true;
      axios
        .post(
          this.$apiAdress +
            "/api/usercourses/create?token=" +
            localStorage.getItem("api_token"),
          self.courseData
        )
        .then(function(response) {
          self.Loading = false;
          self.AddModal = false;
          self.$toastr.success("¡Curso asignado con exito!");
        })
        .catch(function(error) {
          console.log(error);
          self.Loading = false;
          self.$toastr.warning("¡Error al asignar curso!");
        });
    },
  },
  computed: {},
  mounted: function() {    
    let self = this;
    self.Loading = true;
    axios
      .get(
        this.$apiAdress +
          "/api/courses/list?token=" +
          localStorage.getItem("api_token")
      )
      .then(function(response) {
        self.courses = response.data;
        self.Loading = false;
      })
      .catch(function(error) {
        console.log(error);
        self.Loading = false;
        //self.$router.push({ path: 'login' });
      });
  },
};
</script>
<style scoped></style>

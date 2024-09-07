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
        <CButton class="btn botonesCan text-white" @click="AssignCourse">
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
      status: "No pagado",
    },
    courses: [],
    statuses: ["Pagado", "No pagado"],
    asignado: false,
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
    refrescarComponente: null,
  },
  watch: {
    modal: function () {
      if (this.modal) {
        this.AddModal = true;
        if (this.modal != false) {
          this.user_name = this.modal.name;
          this.courseData.user_id = this.modal.id;
          this.getCourseSelect();
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
        .then(function (response) {
          // Emitir un evento para notificar al componente padre
          self.$bus.$emit("cursoasignado");
          self.Loading = false;
          self.AddModal = false;
          self.$swal.fire({
            position: "top-end",
            icon: "success",
            title: "¡Curso asignado con exito!",
            showConfirmButton: false,
            timer: 1400,
          });
          self.asignado = true;
        })
        .catch(function (error) {
          console.log(error.response.data); // Imprimir los errores en formato JSON
          self.Loading = false;

          // Obtener los errores específicos
          if (error.response.status === 422) {
            console.log(error.response.data);
            self.$toastr.warning(error.response.data.message);
          } else if (error.response.status === 404) {
            console.log("Error 404: Recurso no encontrado");
          } else if (error.response.status === 500) {
            console.log("Error 500: Error interno del servidor");
          }
        });
    },
    getCourseSelect() {
      let self = this;
      self.Loading = true;
      axios
        .get(
          this.$apiAdress +
            "/api/courses/list?user_id=" +
            self.courseData.user_id +
            "&&?token=" +
            localStorage.getItem("api_token")
        )
        .then(function (response) {
          self.courses = response.data;
          console.log(response.data);
          self.$emit("child-refresh", true);
          self.Loading = false;
        })
        .catch(function (error) {
          console.log(error);
          self.Loading = false;
          //self.$router.push({ path: 'login' });
        });
    },
  },
  computed: {},
  mounted: function () {},
};
</script>
<style scoped>
svg {
  color: white !important;
}
</style>

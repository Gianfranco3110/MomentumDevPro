<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      :title="tituloModal"
      :closeOnBackdrop="false"
      color="dark"
      size="lg"
      :show.sync="AddModal"
    >
      <CRow class="mt-2">
        <CCol sm="12">
          <CInput
            addLabelClasses="required"
            placeholder="Nombre de la sección"
            invalid-feedback="Campo requerido"
            label="Nombre"
            v-model="$v.section.name.$model"
            :is-valid="hasError($v.section.name)"
          />
        </CCol>
        <CCol sm="12">
          <CInput
            addLabelClasses="required"
            type="number"
            placeholder="Orden"
            invalid-feedback="Campo requerido solo enteros"
            label="Orden"
            v-model="$v.section.orden.$model"
            :is-valid="hasError($v.section.orden)"
          />
        </CCol>
       
      </CRow>

      <template #footer>
        <CButton class="btn botonesCan text-white" :disabled="isDisabled" @click="guardar">
          <CIcon name="cil-check-circle" />&nbsp; ACEPTAR
        </CButton>
        <CButton color="dark" @click="CerrarLimpiar">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import UpperCase from "@/_validations/uppercase-directive";
import General from "@/_mixins/general";
import CursosSectionVal from "@/_validations/sectioncourse/SectionCourseVal";
import axios from "axios";

//METODOS
function CerrarLimpiar() {
  this.section.name = "";
  this.section.orden = "";
  this.AddModal = false;
  this.files = "";
}




//GUARDA Y ACTUALIZA
function guardar() {
  let self = this;
  self.Loading = true;
  if (self.actualizar) {

    axios
      .put(
        this.$apiAdress +
          "/api/course-sections/" +
          self.section.id +
          "?token=" +
          localStorage.getItem("api_token"),
          self.section,
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      )
      .then(function(response) {
        self.$toastr.success("Sección actualizado con exito!");
        self.Loading = false;
        self.AddModal = false;
        self.limpiarDatos();
        self.$emit("child-refresh", true);
      })
      .catch(function(error) {
       // Capturar y manejar los errores
       if (error.response) {
            // Error de respuesta del servidor
            const errorDetails = {
              status: error.response.status,
              data: error.response.data,
            };
            console.log(errorDetails);
            
            // Manejar errores específicos
            if ([404, 422, 500].includes(error.response.status)) {
              // Manejar errores 404, 422, 500
              // console.log("Error " + error.response.status + ": " + error.response.data);
              self.$toastr.warning("¡"+errorDetails.data.orden[0]+"!");
            }
          } else if (error.request) {
            // Error de solicitud (sin respuesta del servidor)
            console.log("Error de solicitud:", error.request);
          } else {
            // Otros errores
            console.log("Error:", error.message);
          }
          self.Loading = false;
      });
  } else {

    axios
      .post(
        this.$apiAdress +
          "/api/course-sections?token=" +
          localStorage.getItem("api_token"),
        self.section,
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      )
      .then(function(response) {
        self.$toastr.success("¡"+response.data.message+"!");
        self.limpiarDatos();
        console.log(response);
        self.Loading = false;
        self.AddModal = false;
        self.$emit("child-refresh", true);
      })
      .catch(function(error) {
       // Capturar y manejar los errores
       if (error.response) {
            // Error de respuesta del servidor
            const errorDetails = {
              status: error.response.status,
              data: error.response.data,
            };
            console.log(errorDetails);
            
            // Manejar errores específicos
            if ([404, 422, 500].includes(error.response.status)) {
              // Manejar errores 404, 422, 500
              // console.log("Error " + error.response.status + ": " + error.response.data);
              self.$toastr.warning("¡"+errorDetails.data.message+"!");
            }
          } else if (error.request) {
            // Error de solicitud (sin respuesta del servidor)
            console.log("Error de solicitud:", error.request);
          } else {
            // Otros errores
            console.log("Error:", error.message);
          }
          self.Loading = false;
      });
  }
  this.$v.$reset();
}
//LIMPIA LOS CAMPOS
function limpiarDatos() {
  this.section.name = "";
  this.section.orden = "";

  this.AddModal = false;
  this.files = "";
}



//COMPUTED
function isDisabled() {
  return this.$v.$invalid;
}

//DATA
function data() {
  return {
    //MODELOS
    section: {
      name: "",
      orden: "",
    },
    // VARIABLES
    AddModal: false,
    Loading: false,
    actualizar: false,
    tituloModal: "",
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
    type: String,
    default: "User id",
    caption: {
      type: String,
      default: "curso id",
    },
  },
  directives: UpperCase,
  validations: CursosSectionVal,
  watch: {
    modal: function() {
      if (this.modal) {
        this.limpiarDatos();
        this.AddModal = true;
        if (this.modal == true) {
          this.tituloModal = "Nueva sección";
          this.actualizar = false;
        } else {
          this.actualizar = true;
          this.tituloModal = "Editar sección";
          this.section.id = this.modal.id;
          this.section.name = this.modal.name;
          this.section.orden = this.modal.orden;

          console.log(this.modal);
        }
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    limpiarDatos,
    guardar,
    CerrarLimpiar,
  },
  computed: {
    isDisabled,
 
  },
  mounted: function() {

  },
};
</script>
<style scoped>
.custom-input-file {
  background-color: #535d6d;
  color: #fff;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
  margin: 0;
  min-height: 15px;
  overflow: hidden;
  padding: 10px;
  position: relative;
  text-align: center;
  width: 200px;
}

.custom-input-file .input-file {
  border: 10000px solid transparent;
  cursor: pointer;
  font-size: 10000px;
  margin: 0;
  opacity: 0;
  outline: 0 none;
  padding: 0;
  position: absolute;
  right: -1000px;
  top: -1000px;
}
.block {
  cursor: pointer;
}
</style>

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
          <p v-if="request.type === '2'" class="text-dark mb-0">{{ request.text }}</p>
          <img class="w-100" :src="$apiAdress + request.img" v-if="request.type === '1'">
        </CCol>
      </CRow>

      <template #footer>
        <CButton color="dark" @click="CerrarLimpiar">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CERRAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import UpperCase from "@/_validations/uppercase-directive";
import General from "@/_mixins/general";
import CursosSectionVal from "@/_validations/sectioncourse/SectionCourseVal";

//METODOS
function CerrarLimpiar() {
  this.AddModal = false;
}


//DATA
function data() {
  return {
    //MODELOS
    request: {
      text: "",
      img: "",
      type: "",
    },
    // VARIABLES
    AddModal: false,
    Loading: false,
    actualizar: false,
    tituloModal: "",
  };
}
export default {
  name: "modalViewsTestRequest",
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
        this.AddModal = true;
          this.tituloModal = "Repuesta";
          this.request.text = this.modal.request;
          this.request.img = this.modal.url_img;
          this.request.type = this.modal.type_question_num;

          console.log(this.modal);
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    CerrarLimpiar,
  },
};
</script>
<style scoped>
.custom-input-file {
  background-color: #aa8caf;
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

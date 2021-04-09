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
        <CCol sm="6">
          <CInput
            addLabelClasses="required"
            placeholder="Url del video"
            invalid-feedback="Campo requerido"
            label="URL DEL VIDEO"
          />
        </CCol>
        <CCol sm="6">
          <CSelect
            addLabelClasses="required"
            label="CURSO A RELACIONAR"
            placeholder="SELECCIONE"
            :options="itemsC"
            v-model="Curso_id"
            :value.sync="Curso_id"
          />
        </CCol>
        <CCol sm="12">
          <CTextarea
            addLabelClasses="required"
            rows="5"
            invalid-feedback="Campo requerido. {A..Z ,-.*-/#}"
            label="DESCRIPCION DEL VIDEO"
            maxlength="256"
            placeholder="Ingrese su descripción aqui.."
          />
        </CCol>
      </CRow>
      <template #footer>
        <CButton color="success">
          <CIcon name="cil-check-circle" />&nbsp; ACEPTAR
        </CButton>
        <CButton class="botonesP" color="dark" @click="AddModal = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>
<script>
import General from "@/_mixins/general";
import axios from "axios";

//METHODS
//LISTAR TODOS LOS CURSOS
function ListCurso() {
  let self = this;
  self.Loading = true;
  let listado = [];
  self.itemsC = [];
  axios
    .get(
      this.$apiAdress +
        "/api/courses?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      listado = response.data;
      self.itemsC = listado.map((listado) =>
        Object.assign({}, self.itemsC, {
          value: listado.id,
          label: listado.CourseName,
        })
      );
      console.log(response);
      self.Loading = false;
    })
    .catch(function(error) {
      console.log(error);
      self.$router.push({ path: "/login" });
    });
}

function data() {
  return {
    //MODELOS
    // VARIABLES
    AddModal: false,
    Loading: false,
    actualizar: false,
    tituloModal: "",
    statuses: [],
    itemsC: [],
    Curso_id: "",
  };
}
//COMPUTED

export default {
  name: "add-modal",
  data,
  mixins: [General],
  props: {
    modal: null,
    type: String,
    default: "User id",
  },
  methods: {
    ListCurso,
  },
  watch: {
    modal: function() {
      if (this.modal) {
        this.AddModal = true;
        if (this.modal == true) {
          this.tituloModal = "NUEVO CURSO VIDEO";
          this.ListCurso();
          this.actualizar = false;
        } else {
          this.actualizar = true;
          this.tituloModal = "EDITAR CURSO VIDEO";
        }
        this.$emit("cerrarModal");
      }
    },
    Curso_id: function() {
      if (this.Curso_id) {
        console.log(this.Curso_id);
      }
    },
  },
};
</script>

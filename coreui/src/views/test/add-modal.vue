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
          <CTextarea
            addLabelClasses="required"
            rows="5"
            label="INGRESE LAS PREGUNTAS PARA EL TEST"
            maxlength="256"
            placeholder="Ingrese sus preguntas aqui.."
          />
        </CCol>
      </CRow>

      <template #footer>
        <CButton color="success">
          <CIcon name="cil-check-circle" />&nbsp; ACEPTAR
        </CButton>
        <CButton color="dark" @click="AddModal = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import axios from "axios";
import General from "@/_mixins/general";
//DATA
function data() {
  return {
    //MODELOS

    // VARIABLES
    tituloModal: "",
    AddModal: false,
    Loading: false,
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
        if (this.modal == true) {
          this.tituloModal = "NUEVO TEST";
        } else {
          console.log(this.modal);
        }
        this.$emit("cerrarModal");
      }
    },
  },
};
</script>

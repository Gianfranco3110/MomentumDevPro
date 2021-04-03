<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <AgreModal :modal="AddModal" @cerrarModal="AddModal = false" />
    <CCard>
      <CCardHeader class="text-center bg-dark text-white">
        <b>LISTADO DE VIDEOS</b>
      </CCardHeader>
      <CCardBody>
        <CCol sm="12" class="text-right">
          <CButton
            square
            class="botonesP"
            color="dark"
            @click="AddModal = true"
          >
            <CIcon name="cil-playlist-add" />&nbsp; NUEVO VIDEO
          </CButton>
          <CCol sm="12"> </CCol>
        </CCol>
      </CCardBody>
    </CCard>
  </div>
</template>
<script>
import General from "@/_mixins/general";
import AgreModal from "./add-modal";
import axios from "axios";
//DATA
function data() {
  return {
    Loading: false,
    AddModal: false,
  };
}

export default {
  name: "index",
  mixins: [General],
  data,
  components: {
    AgreModal,
  },
};
</script>

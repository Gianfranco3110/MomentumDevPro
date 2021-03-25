<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <AgreModal :modal="AddModal" @cerrarModal="AddModal = false" />
    <CCard>
      <CCardHeader class="text-center bg-dark text-white">
        <b>LISTADO DE CURSOS</b>
      </CCardHeader>
      <CCardBody>
        <CCol sm="12" class="text-right">
          <CButton square color="dark" @click="AddModal = true">
            <CIcon name="cil-playlist-add" />&nbsp; NUEVO CURSO
          </CButton>
        </CCol>
      </CCardBody>
    </CCard>
  </div>
</template>

<script>
import { DateFormater } from "@/_helpers/funciones";
import General from "@/_mixins/general";
import AgreModal from "./add-modal";

const tableTextHelpers = {
  tableFilterText: {
    label: "FILTRAR:",
    placeholder: "EMBALAJE",
  },
  itemsPerPageText: {
    label: "EMBALAJES POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO HAY REGISTROS DISPONIBLES",
  },
};

//DATA
function data() {
  return {
    Loading: false,
    LoadingEmba: false,
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
  props: {},
  methods: {},
  watch: {},
  mounted() {},
};
</script>
<style scoped></style>

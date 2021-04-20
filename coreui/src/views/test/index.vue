<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <AgreModal :modal="AddModal" @cerrarModal="AddModal = false" />
    <CCard>
      <CCardHeader class="text-center botonesP text-white">
        <b>LISTADO DE TEST</b>
      </CCardHeader>
      <CCardBody>
        <CCol sm="12" class="text-right">
          <CButton
            square
            class="botonesP"
            color="dark"
            @click="AddModal = true"
          >
            <CIcon name="cil-playlist-add" />&nbsp; NUEVO TEST
          </CButton>
          <CCol sm="12">
            <CDataTable
              :items="[]"
              :fields="[]"
              column-filter
              :items-per-page="5"
              :noItemsView="tableText.noItemsViewText"
              :table-filter="tableText.tableFilterText"
              :items-per-page-select="tableText.itemsPerPageText"
              hover
              small
              sorter
              pagination
            >
            </CDataTable>
          </CCol>
        </CCol>
      </CCardBody>
    </CCard>
  </div>
</template>

<script>
import General from "@/_mixins/general";
import AgreModal from "./add-modal";
import axios from "axios";

const tableTextHelpers = {
  tableFilterText: {
    label: "FILTRAR:",
    placeholder: "TEST",
  },
  itemsPerPageText: {
    label: "TEST POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO HAY TEST DISPONIBLES",
  },
};
//DATA
function data() {
  return {
    items: [],
    Loading: false,
    AddModal: false,
    tableText: Object.assign({}, tableTextHelpers),
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

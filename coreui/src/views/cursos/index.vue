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
          <CCol sm="12">
            <CDataTable
              :items="['2', '2', '2']"
              :fields="fieldsCourse"
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
              <template #Status="{}">
                <td>
                  <CBadge :color="getBadge()"> </CBadge>
                </td>
              </template>
              <template #Detalle="{ item }">
                <td class="py-2">
                  <CButton
                    color="primary"
                    class="mr-1"
                    square
                    size="sm"
                    v-c-tooltip="'Editar'"
                    @click="AddModal = item"
                  >
                    <CIcon name="cil-pencil" />
                  </CButton>
                  <CButton
                    color="primary"
                    square
                    size="sm"
                    class="btn-info"
                    v-c-tooltip="'Ver'"
                    @click="ListModal = item"
                  >
                    <CIcon name="cil-note" />
                  </CButton>
                </td>
              </template>
            </CDataTable>
          </CCol>
        </CCol>
      </CCardBody>
    </CCard>
  </div>
</template>

<script>
import { DateFormater } from "@/_helpers/funciones";
import General from "@/_mixins/general";
import AgreModal from "./add-modal";

const fieldsCourse = [
  {
    key: "Nro",
    label: "#",
    _style: "width:1%;",
  },
  { key: "Name", label: "NOMBRE" },
  { key: "Usuario", label: "FOTO" },
  { key: "Fecha", label: "DIAS DE VIGENCIA" },
  { key: "Status", label: "STATUS" },
  {
    key: "Detalle",
    label: "",
    sorter: false,
    filter: false,
  },
];

const tableTextHelpers = {
  tableFilterText: {
    label: "FILTRAR:",
    placeholder: "CURSO",
  },
  itemsPerPageText: {
    label: "CURSO POR PAGINA:",
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
  props: {
    fieldsCourse: {
      type: Array,
      default() {
        return fieldsCourse;
      },
    },
  },
  methods: {},
  watch: {},
  mounted() {},
};
</script>
<style scoped></style>

<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <AgreModal
      :modal="AddModal"
      @cerrarModal="AddModal = false"
      @child-refresh="refrescarCurso = true"
    />
    <CCard>
      <CCardHeader class="text-center bg-dark text-white">
        <b>LISTADO DE CURSOS</b>
      </CCardHeader>
      <CCardBody>
        <CCol sm="12" class="text-right">
          <CButton
            square
            class="botonesP"
            color="dark"
            @click="AddModal = true"
          >
            <CIcon name="cil-playlist-add" />&nbsp; NUEVO CURSO
          </CButton>
          <CCol sm="12">
            <CDataTable
              :items="items"
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
              <template #status="{item}">
                <td>
                  <CBadge :color="getBadge(item.status)">{{
                    item.status
                  }}</CBadge>
                </td>
              </template>
              <template #Detalle="{ item }">
                <td class="py-2">
                  <CButton
                    color="dark"
                    class="mr-1 bg-dark"
                    square
                    size="sm"
                    v-c-tooltip="'Editar'"
                    @click="AddModal = item"
                  >
                    <CIcon name="cil-pencil" />
                  </CButton>
                  <CButton
                    color="dark"
                    square
                    size="sm"
                    class="mr-1"
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
import axios from "axios";

const fieldsCourse = [
  {
    key: "id",
    label: "#",
    _style: "width:1%;",
  },
  { key: "CourseName", label: "TITULO" },
  { key: "daysofvalidity", label: "DIAS DE VIGENCIA" },
  { key: "price", label: "PRECIO" },
  { key: "image", label: "FOTO" },
  { key: "status", label: "STATUS" },
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
    noItems: "NO HAY CURSOS DISPONIBLES",
  },
};

//LISTAR TODOS LOS CURSOS
function ListCurso() {
  let self = this;
  self.Loading = true;
  let listado = [];
  self.items = [];
  axios
    .get(
      this.$apiAdress +
        "/api/courses?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      listado = response.data;
      self.items = listado.map((listado) =>
        Object.assign({}, self.items, {
          id: listado.id,
          image: listado.image,
          price: listado.price,
          daysofvalidity: listado.daysofvalidity,
          status: listado.status,
          CourseName: listado.CourseName,
          description: listado.description,
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

//DATA
function data() {
  return {
    items: [],
    Loading: false,
    LoadingEmba: false,
    AddModal: false,
    refrescarCurso: false,

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
  methods: {
    ListCurso,
    getBadge(status) {
      return status === "Activo"
        ? "success"
        : status === "Inactivo"
        ? "danger"
        : status === "Pending"
        ? "warning"
        : status === "Banned"
        ? "danger"
        : "primary";
    },
  },
  watch: {
    refrescarCurso: function() {
      if (this.refrescarCurso) {
        this.ListCurso();
        this.refrescarCurso = false;
      }
    },
  },
  mounted() {
    this.ListCurso();
  },
};
</script>
<style scoped></style>

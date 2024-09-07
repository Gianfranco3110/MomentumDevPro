<template>
    <div>
      <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
      <AgreModal
        :modal="AddModal"
        @cerrarModal="AddModal = false"
        @child-refresh="refrescarCurso = true"
      />

  
      <CCard>
        <CCardHeader class="text-center botonesP text-white">
          <b>LISTADO DE SECCIONES</b>
        </CCardHeader>
        <CCardBody>
          <CCol sm="12">
            <div class="w-100 text-right">
                <CButton
                square
                class="botonesP"
                color="dark"
                @click="AddModal = true"
                >
                <CIcon name="cil-playlist-add" />&nbsp; Nuevo sección
                </CButton>
            </div>
            <CCol sm="12">
              <CDataTable
                :items="items"
                :fields="fieldsCourse"
                :items-per-page="10"
                :noItemsView="tableText.noItemsViewText"
                :table-filter="tableText.tableFilterText"
                :items-per-page-select="tableText.itemsPerPageText"
                hover
                small
                sorter
                pagination
              >
                <template #orden="{item}">
                  <td>
                    <h2 class="mb-0 "><CBadge class="text-white" :color="getBadge('Activo')">
                      {{item.orden}}
                      </CBadge></h2>
                  </td>
                </template>
                <template #Detalle="{ item }">
                  <td class="py-2">
                    <CButton
                      color="dark"
                      class="mr-1"
                      square
                      size="sm"
                      v-c-tooltip="'Editar'"
                      @click="AddModal = item"
                    >
                      <CIcon name="cil-pencil" />
                    </CButton>
  
                    <CButton
                      shape="square"
                      color="danger"
                      size="sm"
                      v-c-tooltip="'Eliminar'"
                      class="mr-1"
                      @click="deleteSection(item)"
                    >
                      <CIcon  name="cil-trash" />
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
    { key: "name", label: "NOMBRE" , _style: "width:30%;"},
    { key: "orden", label: "ORDEN",_style: "width:30%;" },
    {
      key: "Detalle",
      label: "ACCIONES",
      sorter: false,
      filter: false,
      _style: "width:6%;"
    },
  ];
  
  const tableTextHelpers = {
    tableFilterText: {
      label: "FILTRAR:",
      placeholder: "SECCIÓN",
    },
    itemsPerPageText: {
      label: "SECCIÓN POR PAGINA:",
    },
    noItemsViewText: {
      noResults: "NO SE ENCONTRARON RESULTADOS",
      noItems: "NO HAY SECCIONES DISPONIBLES",
    },
  };
  
  //LISTAR TODOS LOS CURSOS
  function ListSection() {
    let self = this;
    self.Loading = true;
    let listado = [];
    self.items = [];
    axios
      .get(
        this.$apiAdress +
          "/api/course-sections?token=" +
          localStorage.getItem("api_token")
      )
      .then(function(response) {
        listado = response.data;
        self.items = listado.map((listado) =>
          Object.assign({}, self.items, {
            id: listado.id,
            name: listado.name,
            orden: listado.orden,
          })
        );
        console.log(listado);
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
      id:"",
      Loading: false,
      AddModal: false,
      refrescarCurso: false,
  
      tableText: Object.assign({}, tableTextHelpers),
    };
  }
  
  export default {
    name: "index",
    mixins: [General],
    data:data,
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
      ListSection,
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
     
      deleteSection(item) {
      console.log(item.id);
        let self = this;
        this.$swal
        .fire({
            title: "ELIMINAR SECCIÓN",
            text: "¿ ESTAS SEGURO QUE DECEAS ELIMINAR ESTA SECCIÓN ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
        })
        .then((result) => {
            if (result.isConfirmed) {
            axios
            .delete(
                this.$apiAdress +
                "/api/course-sections/"+item.id+"?token=" +
                localStorage.getItem("api_token")
            )
            .then(function(response) {
                console.log(response.data);
                self.$swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "!Sección eliminado con extio!",
                  showConfirmButton: false,
                  timer: 1400,
              });
                self.ListSection();
            })
            .catch(function(error) {
                console.log(error);
            });
            }
        });
    },
    },
    watch: {
      refrescarCurso: function() {
        if (this.refrescarCurso) {
          this.ListSection();
          this.refrescarCurso = false;
        }
      },
    },
    mounted() {
      this.ListSection();
    },
  };
  </script>
<style scoped>
svg{
  color: white !important;
}
</style>
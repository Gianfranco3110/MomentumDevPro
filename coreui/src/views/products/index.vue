<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <AgreModal :modal="AddModal" @cerrarModal="AddModal = false"  @child-refresh="refrescarProduc = true"/>
    <VeModal :modal="VerModal" @cerrarModal="VerModal = false" />
    <CCard>
      <CCardHeader class="text-center botonesP text-white">
        <b>LISTADO DE PRODUCTOS</b>
      </CCardHeader>
      <CCardBody>
        <CCol sm="12" class="text-right">
          <CButton
            square
            class="botonesP"
            color="dark"
            @click="AddModal = true"
          >
            <CIcon name="cil-playlist-add" />&nbsp; NUEVO PRODUCTO
          </CButton>
          <CCol sm="12">
            <CDataTable
              :items="items"
              :fields="fieldsProducts"
              column-filter
              :items-per-page="10"
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
                    color="success"
                    class="mr-1"
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
                    @click="VerModal = item"
                  >
                    <CIcon name="cil-zoom" />
                  </CButton>
                  <CButton
                    color="danger"
                    square
                    size="sm"
                    class="mr-1"
                    v-c-tooltip="'Eliminar'"
                    @click="deleteProduct( item.id )"
                  >
                    <CIcon name="cil-X" />
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
import axios from "axios";
import General from "@/_mixins/general";
import AgreModal from "./add-modal";
import VeModal from "./ver-modal";

const fieldsProducts = [
  {
    key: "id",
    label: "#",
    _style: "width:1%;",
  },
  { key: "title", label: "TITULO" },
  { key: "product_type", label: "TIPO DE PRODUCTO" },
  { key: "price", label: "PRECIO" },
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
    placeholder: "Productos",
  },
  itemsPerPageText: {
    label: "PRODUCTOS POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO HAY PRODUCTOS DISPONIBLES",
  },
};

function ListProducts() {
  let self = this;
  self.Loading = true;
  let listado = [];
  self.items = [];

  axios
    .get(
      this.$apiAdress +
        "/api/products/all?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      listado = response.data;
      self.items = listado.map((listado) =>
        Object.assign({}, self.items, {
          id: listado.id,
          title: listado.title,
          price: listado.price,
          product_type: listado.product_type,
          status: listado.status,
          description: listado.description,
          image: listado.image,
        })
      );
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
    AddModal: false,
    VerModal: false,
    refrescarProduc: false,

    tableText: Object.assign({}, tableTextHelpers),
  };
}

export default {
  name: "index",
  mixins: [General],
  data,
  components: {
    AgreModal,
    VeModal,
  },
  props: {
    fieldsProducts: {
      type: Array,
      default() {
        return fieldsProducts;
      },
    },
  },
  methods: {
    ListProducts,
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
    deleteProduct ( id ) {
      let self = this;      
      /////
      this.$swal
      .fire({
        text: `¿Esta seguro de realizar esta acción?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "CONFIRMAR",
        cancelButtonText: "CANCELAR",
      })
      .then((result) => {
        if (result.isConfirmed) {
          self.Loading = true;
          axios.post(  this.$apiAdress + '/api/products/eliminate/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'PUT'
      })
      .then(function (response) {
          self.$toastr.success("¡Producto eliminado con exito!");
          self.ListProducts();
          self.Loading = false;
      }).catch(function (error) {
        console.log(error);
        self.Loading = false;
        self.$toastr.warning("¡Error al eliminar producto!");
        //self.$router.push({ path: '/login' });
      });
        }
      });
      ////

    },  
  },
  watch: {
    refrescarProduc: function() {
      if (this.refrescarProduc) {
        this.ListProducts();
        this.refrescarProduc = false;
      }
    },
  },
  mounted: function() {
    this.ListProducts();
  },
};
</script>

<style scoped></style>

<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <AgreModal
      :modal="AddModal"
      @cerrarModal="AddModal = false"
      @child-refresh="refrescarProduc = true"
    />
    <CCard>
      <CCardHeader class="text-center bg-dark text-white">
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
import axios from "axios";
import General from "@/_mixins/general";
import AgreModal from "./add-modal";

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
        "/api/products?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      console.log(response);
      listado = response.data;
      self.items = listado.map((listado) =>
        Object.assign({}, self.items, {
          id: listado.id,
          title: listado.title,
          price: listado.price,
          product_type: listado.product_type,
          status: listado.status,
          description: listado.description,
        })
      );
      console.log(response);
      self.Loading = false;
    })
    .catch(function(error) {
      console.log(error);
      //self.$router.push({ path: "/login" });
    });
}

//DATA
function data() {
  return {
    items: [],
    Loading: false,
    AddModal: false,
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

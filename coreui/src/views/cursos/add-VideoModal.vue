<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      :title="tituloModal"
      :closeOnBackdrop="false"
      color="dark"
      size="xl"
      :show.sync="AddVideo"
    >
      <CRow>
        <CCol sm="6">
          <CRow>
            <CCol sm="4">
              <CInput
                addLabelClasses="required"
                placeholder="Nombre del curso"
                invalid-feedback="Campo requerido"
                label="NOMBRE DEL CURSO"
                v-model="CourseName"
                disabled
              />
            </CCol>
            <CCol sm="4">
              <CInput
                addLabelClasses="required"
                type="number"
                placeholder="Dias de vigencia"
                invalid-feedback="Campo requerido solo enteros"
                label="DIAS DE VIGENCIA"
                v-model="daysofvalidity"
                disabled
              />
            </CCol>
            <CCol sm="4">
              <CInput
                addLabelClasses="required"
                type="number"
                placeholder="0"
                invalid-feedback="Campo requerido {0,00}"
                label="PRECIO DEL CURSO"
                v-model="price"
                disabled
              />
            </CCol>
          </CRow>

          <CInput
            addLabelClasses="required"
            placeholder="Url del video"
            invalid-feedback="Campo requerido"
            label="URL DEL VIDEO"
            v-model="$v.video.url_video.$model"
            :is-valid="hasError($v.video.url_video)"
          />

          <CTextarea
            addLabelClasses="required"
            rows="4"
            invalid-feedback="Campo requerido. {A..Z ,-.*-/#}"
            label="DESCRIPCION DEL VIDEO"
            maxlength="256"
            placeholder="Ingrese su descripción aqui.."
            v-model="$v.video.description.$model"
            :is-valid="hasError($v.video.description)"
          />
        </CCol>
        <!-- BOTON DE AGREGAR + -->

        <div class="card-header" align="right">
          <template>
            <td class="center-cell">
              <div>
                <CButton
                  shape="square"
                  color="success"
                  size="sm"
                  v-c-tooltip="'Añadir video'"
                  class="align-items-right"
                  @click="guardar"
                  :disabled="isDisabled"
                >
                  <CIcon name="cil-plus" />
                </CButton>
              </div>
            </td>
          </template>
        </div>
        <CCol sm="5">
          <CDataTable
            :items="items"
            :fields="fields"
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
            <template #DocsRoute="{item}">
              <td class="py-2">
                <CButton
                  color="dark"
                  class="mr-1"
                  square
                  size="sm"
                  v-c-tooltip="'Ver'"
                >
                  <CIcon name="cil-search" />
                </CButton>
                <CButton
                  color="danger"
                  square
                  size="sm"
                  class="mr-1"
                  v-c-tooltip="'Quitar'"
                  @click="eliminar(item)"
                >
                  <CIcon name="cil-minus" />
                </CButton>
              </td>
            </template>
          </CDataTable>
        </CCol>
      </CRow>
      <template #footer>
        <CButton color="success" @click="CerrarLimpiar">
          <CIcon name="cil-check-circle" />&nbsp; ACEPTAR
        </CButton>
        <CButton class="botonesP" color="dark" @click="CerrarLimpiar">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>
<script>
import General from "@/_mixins/general";
import UpperCase from "@/_validations/uppercase-directive";
import VideoVal from "@/_validations/videos/VideoVal";

import axios from "axios";

function CerrarLimpiar() {
  this.video = {
    description: "",
    url_video: "",
  };
  this.AddVideo = false;
}

//LIMPIA LOS CAMPOS
function limpiarDatos() {
  this.video.description = "";
  this.video.url_video = "";
}

const fields = [
  {
    key: "Nro",
    label: "#",
    _style: "width:1%;",
  },
  { key: "url_video", label: "URL DEL VIDEO" },
  { key: "description", label: "DESCRIPCION" },
  {
    key: "DocsRoute",
    label: "",
    sorter: false,
    filter: false,
  },
];

const tableTextHelpers = {
  tableFilterText: {
    label: "FILTRAR:",
    placeholder: "VIDEO",
  },
  itemsPerPageText: {
    label: "VIDEO POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO HAY VIDEOS DISPONIBLES",
  },
};

//METHODS
//GUARDA Y ACTUALIZA
function guardar() {
  let self = this;
  self.Loading = true;
  let formData = new FormData();
  formData.append("url_video", self.video.url_video);
  formData.append("description", self.video.description);
  formData.append("status_id", self.video.status_id);
  formData.append("courses_id", self.video.courses_id);

  console.log(FormData);
  axios
    .post(
      this.$apiAdress +
        "/api/coursesvideos/store?token=" +
        localStorage.getItem("api_token"),
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    )
    .then(function(response) {
      self.$toastr.success("Video agregado con extio!");
      self.limpiarDatos();
      self.ListVideo(self.video.courses_id);
      console.log(response);
    })
    .catch(function(error) {
      if (error.response.data.message == "SIN SALIR DE VUE ERROR") {
        for (let key in error.response.data.errors) {
          if (error.response.data.errors.hasOwnProperty(key)) {
            self.message += error.response.data.errors[key][0] + "  ";
          }
        }
      }
    });
}

//LISTAR VIDEOS
function ListVideo(id) {
  let self = this;
  self.Loading = true;
  let listado = [];
  self.items = [];
  axios
    .get(
      this.$apiAdress +
        "/api/coursesvideos/list/" +
        id +
        "?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      listado = response.data;
      let Nro = 1;
      self.items = listado.map((listado) =>
        Object.assign({}, self.items, {
          Nro: Nro++,
          id: listado.id,
          url_video: listado.url_video,
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

function data() {
  return {
    //MODELOS
    video: {
      description: "",
      url_video: "",
      status_id: 1,
      courses_id: "",
    },
    // VARIABLES
    AddVideo: false,
    Loading: false,
    tituloModal: "",
    CourseName: "",
    daysofvalidity: "",
    price: "",
    tableText: Object.assign({}, tableTextHelpers),
    items: [],
  };
}
//COMPUTED
function isDisabled() {
  return this.$v.$invalid;
}

export default {
  name: "add-VideoModal",
  data,
  mixins: [General],
  computed: {
    isDisabled,
  },
  props: {
    modal: null,
    fields: {
      type: Array,
      default() {
        return fields;
      },
    },
  },
  directives: UpperCase,
  validations: VideoVal,
  methods: {
    guardar,
    limpiarDatos,
    CerrarLimpiar,
    ListVideo,
  },
  watch: {
    modal: function() {
      if (this.modal) {
        this.AddVideo = true;
        this.ListVideo(this.modal.id);
        this.video.courses_id = this.modal.id;
        this.tituloModal = this.modal.CourseName;
        this.CourseName = this.modal.CourseName;
        this.daysofvalidity = this.modal.daysofvalidity;
        this.price = this.modal.price;
        this.$emit("cerrarModal");
        console.log(this.modal);
        console.log(this.video.courses_id);
      }
    },
  },
};
</script>

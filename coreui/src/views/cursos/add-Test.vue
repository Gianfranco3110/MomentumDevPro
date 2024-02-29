<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      title="NUEVO TEST"
      :closeOnBackdrop="false"
      color="dark"
      size="xl"
      :show.sync="AddTest"
    >
      <CRow>
        <CCol sm="6">
          <!--
          <CCol sm="12">
            <div class="form-group form-row">
              <label class="text-right col-form-label required" for="origen"
                >Cursos</label
              >
              <div class="col-sm-6 input-group-sm">
                <CSelect
                  :value.sync="courseData.course_id"
                  :plain="true"
                  :options="courses"
                >
                </CSelect>
              </div>
            </div>
          </CCol> -->
          <CCol sm="12">
            <CTextarea
              addLabelClasses="required"
              rows="5"
              label="INGRESE LA PREGUNTA PARA EL TEST"
              maxlength="256"
              placeholder="Ingrese sus preguntas aqui.."
              v-model="test.question"
            />
          </CCol>
        </CCol>
        <!-- BOTON DE AGREGAR + -->
        <div>
          <template>
            <td class="center-cell">
              <CButton
                shape="square"
                color="success"
                size="sm"
                v-c-tooltip="'Añadir test'"
                class="align-items-right"
                @click="guardar"
              >
                <CIcon name="cil-plus" />
              </CButton>
            </td>
          </template>
        </div>
        <CCol>
          <CDataTable
            :items="items"
            :fields="fields"
            column-filter
            :items-per-page="3"
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
                  @click="deleteTestCourse(item)"
                >
                  <CIcon name="cil-minus" />
                </CButton>
              </td>
            </template>
          </CDataTable>
        </CCol>
      </CRow>
      <template #footer>
        <CButton color="success">
          <CIcon name="cil-check-circle" />&nbsp; ACEPTAR
        </CButton>
        <CButton color="dark" @click="AddTest = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import axios from "axios";
import General from "@/_mixins/general";
import UpperCase from "@/_validations/uppercase-directive";

const fields = [
  {
    key: "Nro",
    label: "#",
    _style: "width:1%;",
  },
  { key: "question", label: "Pregunta" },
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
    placeholder: "PREGUNTA",
  },
  itemsPerPageText: {
    label: "PREGUNTA POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO HAY PREGUNTAS DISPONIBLES",
  },
};

//LIMPIA LOS CAMPOS
function limpiarDatos() {
  this.test.question = "";
}
//GUARDA Y ACTUALIZA
function guardar() {
  let self = this;
  self.Loading = true;
  let formData = new FormData();
  formData.append("question", self.test.question);
  formData.append("status_id", self.test.status_id);
  formData.append("courses_id", self.test.courses_id);

  console.log(FormData);
  axios
    .post(
      this.$apiAdress +
        "/api/coursestest/store?token=" +
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
      self.ListQuestion(self.test.courses_id);
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
function ListQuestion(id) {
  let self = this;
  self.Loading = true;
  let listado = [];
  self.items = [];
  axios
    .get(
      this.$apiAdress +
        "/api/coursestest/list/" +
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
          question: listado.question,
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
    //MODELOS
    //MODELOS
    test: {
      question: "",
      status_id: 1,
      courses_id: "",
    },
    // VARIABLES
    AddTest: false,
    Loading: false,
    courses: [],
    tableText: Object.assign({}, tableTextHelpers),
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
    fields: {
      type: Array,
      default() {
        return fields;
      },
    },
  },
  methods: {
    guardar,
    ListQuestion,
    limpiarDatos,
    deleteTestCourse(iten){
      console.log(iten.id);
      let self = this;
      axios
      .post(
        this.$apiAdress +
          "/api/coursestest/updatestatus?token=" +
          localStorage.getItem("api_token"),{id:iten.id}
        ,
        
      )
      .then(function(response) {
        console.log(response);
        self.$toastr.success("Video quitado con extio!");
        self.ListQuestion(self.test.courses_id);
      })
      .catch(function(error) {
        console.log(error);
      });
    }
  },
  directives: UpperCase,
  watch: {
    modal: function() {
      if (this.modal) {
        this.AddTest = true;
        this.ListQuestion(this.modal.id);
        this.test.courses_id = this.modal.id;
        console.log(this.modal);
        console.log(this.test.courses_id);
        this.$emit("cerrarModal");
      }
    },
  },
};
</script>

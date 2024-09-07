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
        <CCol sm="5">
          <CCol class="mt-3">
            <input type="hidden" v-model="test.id" />
            <CTextarea
              addLabelClasses="required"
              rows="5"
              label="Ingrese la pregunta para el test"
              maxlength="256"
              placeholder="Ingrese sus preguntas aqui.."
              v-model="test.question"
            />
          </CCol>
          <CCol>
            <CSelect
              addLabelClasses="required"
              label="Tipo de test"
              :value.sync="test.type_questions_id"
              invalid-feedback="Campo requerido"
              :plain="true"
              :options="type_questions_options"
              @change="handler_type_question(test.type_questions_id)"
            >
            </CSelect>
          </CCol>
          <CCol v-if="show_section_options">
            <label class="required" for="add-option">Agregar opciones</label>
            <vue-tags-input
              v-model="tag"
              placeholder="Agregar opciones"
              :tags="tags_options"
              @tags-changed="(newTags) => (tags_options = newTags)"
            />
            <CInput
              addLabelClasses="required"
              placeholder="Opción valida"
              invalid-feedback="Campo requerido"
              label="Respuesta"
              class="mt-3"
              v-model="test.valid_option"
            />
          </CCol>
          <CCol class="mt-3">
            <CSelect
              addLabelClasses="required"
              label="Sección"
              :value.sync="test.section_id"
              invalid-feedback="Campo requerido"
              :plain="true"
              :options="sections"
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
            :items-per-page="10"
            :noItemsView="tableText.noItemsViewText"
            :table-filter="tableText.tableFilterText"
            :items-per-page-select="tableText.itemsPerPageText"
            hover
            small
            sorter
            pagination
          >
            <template #DocsRoute="{ item }">
              <td class="py-2">
                <CButton
                  color="dark"
                  class="mr-1"
                  square
                  size="sm"
                  v-c-tooltip="'Editar'"
                  @click="editTestCourse(item)"
                >
                  <CIcon name="cil-pencil" />
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
import VueTagsInput from "@johmun/vue-tags-input";

const fields = [
  {
    key: "Nro",
    label: "#",
    _style: "width:1%;",
  },
  { key: "question", label: "PREGUNTA" },
  { key: "seccion", label: "SECCIÓN" },
  { key: "type_question", label: "TIPO" },
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
  this.test.id = "";
  this.test.section_id = 1;
  this.test.type_questions_id = 1;
  this.tags_options = [];
  this.show_section_options = false;
  this.tag = "";
}
//FUNCION PARA OBTENER LAS SECTIONES
function getSections() {
  let self = this;
  self.Loading = true;
  axios
    .get(
      this.$apiAdress +
        "/api/coursesvideos/listsections?token=" +
        localStorage.getItem("api_token")
    )
    .then(function (response) {
      console.log("Listas de sections");
      console.log(response.data);
      self.sections = response.data;
      self.$emit("child-refresh", true);
      self.Loading = false;
    })
    .catch(function (error) {
      console.log(error);
      self.Loading = false;
      //self.$router.push({ path: 'login' });
    });
}
//GUARDA Y ACTUALIZA
function guardar() {
  let self = this;
  self.Loading = true;
  let formData = new FormData();
  formData.append("question", self.test.question);
  formData.append("status_id", self.test.status_id);
  formData.append("courses_id", self.test.courses_id);
  formData.append("section_id", self.test.section_id);
  formData.append("type_question", self.test.type_questions_id);
  formData.append("valid_option", self.test.valid_option);
  formData.append("id", self.test.id);
  self.tags_options.map((item) => formData.append("options[]", item.text));

  //return;
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
    .then(function (response) {
      self.$toastr.success("Cuestionario agregado con extio!");
      self.$swal.fire({
        position: "top-end",
        icon: "success",
        title: "Cuestionario agregado con exito!",
        showConfirmButton: false,
        timer: 1400,
      });
      self.limpiarDatos();
      self.ListQuestion(self.test.courses_id);
      console.log(response);
    })
    .catch(function (error) {
      self.Loading = false;
      console.log(error.response.data);
      if (error.response.data.message) {
        for (let key in error.response.data.errors) {
          if (error.response.data.errors.hasOwnProperty(key)) {
            console.log(error.response.data.errors[key][0]);
            //self.$toastr.error(error.response.data.errors[key][0]);
            self.$swal.fire({
              position: "top-end",
              icon: "error",
              title: error.response.data.errors[key][0],
              showConfirmButton: false,
              timer: 1400,
            });
            self.message += error.response.data.errors[key][0] + "  ";
          }
        }
      }
    });
}

//Controla el select de tipo de question
function handler_type_question(id) {
  console.log("valor", id);
  if (id == 3) {
    this.show_section_options = true;
  } else {
    this.show_section_options = false;
    this.tags_options = [];
  }
}

function list_Fields(id) {
  let self = this;
  self.Loading = true;
  axios
    .get(
      this.$apiAdress +
        "/api/coursestest/listfieldsquestion/" +
        id +
        "?token=" +
        localStorage.getItem("api_token")
    )
    .then(function (response) {
      self.tags_options = response.data;
      self.Loading = false;
    })
    .catch(function (error) {
      console.log(error);
      self.Loading = false;
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
    .then(function (response) {
      listado = response.data;
      console.log("listado", listado);
      let Nro = 1;
      self.items = listado.map((listado) =>
        Object.assign({}, self.items, {
          Nro: Nro++,
          id: listado.id,
          question: listado.question,
          seccion: listado.course_section.name,
          seccion_id: listado.course_section.id,
          type_question:
            listado.type_question === "1"
              ? "Subir img"
              : listado.type_question === "2"
              ? "Escribir respuesta"
              : "Selección simple",
          id_type: Number(listado.type_question),
        })
      );
      console.log(response);
      self.Loading = false;
    })
    .catch(function (error) {
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
      id: "",
      question: "",
      status_id: 1,
      courses_id: "",
      section_id: "",
      type_questions_id: "",
      valid_option: "",
    },
    // VARIABLES
    tag: "",
    tags_options: [],
    AddTest: false,
    Loading: false,
    courses: [],
    sections: [],
    type_questions_options: [
      {
        label: "Subir img",
        value: 1,
      },
      {
        label: "Escribir respuesta",
        value: 2,
      },
      {
        label: "Selección simple",
        value: 3,
      },
    ],
    items: [],
    tableText: Object.assign({}, tableTextHelpers),
    show_section_options: false,
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  components: {
    VueTagsInput,
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
  methods: {
    list_Fields,
    handler_type_question,
    guardar,
    ListQuestion,
    limpiarDatos,
    getSections,
    deleteTestCourse(item) {
      console.log(item.id);
      let self = this;
      this.$swal
        .fire({
          title: "ELIMINAR TEST",
          text: "¿ ESTAS SEGURO QUE DECEAS ELIMINAR ESTE TEST ?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, Eliminar!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .post(
                this.$apiAdress +
                  "/api/coursestest/updatestatus?token=" +
                  localStorage.getItem("api_token"),
                { id: item.id }
              )
              .then(function (response) {
                console.log(response);
                self.$swal.fire({
                  position: "top-end",
                  icon: "fire",
                  title: "Video eliminado con extio!",
                  showConfirmButton: false,
                  timer: 1400,
                });
                self.ListQuestion(self.test.courses_id);
              })
              .catch(function (error) {
                console.log(error);
              });
          }
        });
    },
    editTestCourse(item) {
      console.log("item", item);
      console.log("Editar" + item.seccion);
      this.test.id = item.id;
      this.test.question = item.question;
      this.test.section_id = item.seccion_id;
      this.test.type_questions_id = item.id_type;
      if (item.id_type == 3) {
        this.show_section_options = true;
        this.list_Fields(item.id);
      } else {
        this.show_section_options = false;
      }
    },
  },
  directives: UpperCase,
  watch: {
    modal: function () {
      if (this.modal) {
        this.AddTest = true;
        this.ListQuestion(this.modal.id);
        this.getSections();
        this.test.courses_id = this.modal.id;
        console.log(this.modal);
        console.log(this.test.courses_id);
        this.$emit("cerrarModal");
        this.limpiarDatos();
      }
    },
  },
};
</script>
<style scoped>
.vue-tags-input {
  max-width: 100% !important;
}
</style>

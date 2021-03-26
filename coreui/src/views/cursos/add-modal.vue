<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      :title="tituloModal"
      :closeOnBackdrop="false"
      color="dark"
      size="lg"
      :show.sync="AddModal"
    >
      <CRow class="mt-2">
        <CCol sm="12">
          <CTextarea
            addLabelClasses="required"
            v-uppercase
            rows="5"
            invalid-feedback="Campo requerido. {A..Z ,-.*-/#}"
            label="DESCRIPCION DEL CURSO"
            maxlength="256"
            placeholder="Ingrese su descripción aqui.."
            v-model="$v.curso.description.$model"
            :is-valid="hasError($v.curso.description)"
          />
        </CCol>
        <CCol sm="3">
          <CInput
            addLabelClasses="required"
            type="number"
            placeholder="0"
            invalid-feedback="Campo requerido {0,00}"
            label="PRECIO DEL CURSO"
            v-model="$v.curso.price.$model"
            :is-valid="hasError($v.curso.price)"
          />
        </CCol>
        <CCol sm="3">
          <CInput
            addLabelClasses="required"
            type="number"
            placeholder="Dias de vigencia"
            invalid-feedback="Campo requerido solo enteros"
            label="DIAS DE VIGENCIA"
            v-model="$v.curso.daysofvalidity.$model"
            :is-valid="hasError($v.curso.daysofvalidity)"
          />
        </CCol>
        <CCol sm="6">
          <div
            class="flex items-center justify-center w-full h-screen text-center"
          >
            <div
              class="p-12 bg-gray-100 border border-gray-300"
              @dragover="dragover"
              @dragleave="dragleave"
              @drop="drop"
            >
              <div class="ocultar">
                <input
                  type="file"
                  multiple
                  name="fields[assetsFieldHandle][]"
                  id="assetsFieldHandle"
                  @change="onChange"
                  ref="file"
                  accept="image/*"
                />
              </div>
              <label for="assetsFieldHandle" class="block">
                <img src="../../../public/img/download1.png" alt="donwload" />
                <h5>Elige un archivo o arrástralo aquí</h5>
              </label>
              <ul class="mt-4" v-if="this.filelist.length" v-cloak>
                <li
                  class="text-sm p-1"
                  v-for="file in filelist"
                  :key="file.item"
                >
                  {{ file.name
                  }}<button
                    class="ml-2"
                    type="button"
                    @click="remove(filelist.indexOf(file))"
                    title="Remove file"
                  >
                    Eliminar
                  </button>
                </li>
              </ul>
            </div>
          </div>
          <!-- FINAL DEL INPUT FILE -->
        </CCol>
        <CCol sm="12" v-if="actualizar">
          <CSelect
            addLabelClasses="required"
            label="Status"
            :value.sync="status_id"
            :plain="true"
            :options="statuses"
          >
          </CSelect>
        </CCol>
      </CRow>

      <template #footer>
        <CButton color="success" :disabled="isDisabled" @click="evaluaStatus">
          <CIcon name="cil-check-circle" />&nbsp; ACEPTAR
        </CButton>
        <CButton color="dark" @click="AddModal = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import UpperCase from "@/_validations/uppercase-directive";
import General from "@/_mixins/general";
import CursosVal from "@/_validations/cursos/CursosVal";
import axios from "axios";

//METODOS

function uploadImage() {
  let self = this;
  self.Loading = true;
  let formData = new FormData();
  formData.append("image", self.image);
  axios
    .post(
      this.$apiAdress +
        "/api/courses/image/store?token=" +
        localStorage.getItem("api_token"),
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    )
    .then(function(response) {
      self.imagePath = response.data.path;
    })
    .catch(function(error) {
      console.log(error);
      //self.$router.push({ path: '/login' });
    });
  self.Loading = false;
}

function guardar() {
  let self = this;
  self.Loading = true;
  let formData = new FormData();
  formData.append("image", self.image);
  formData.append("daysofvalidity", self.curso.daysofvalidity);
  formData.append("description", self.curso.description);
  formData.append("status_id", self.curso.status_id);
  formData.append("price", self.curso.price);
  console.log(formData);
  let url = "/api/courses?token=";
  axios
    .post(
      this.$apiAdress +
        "/api/courses?token=" +
        localStorage.getItem("api_token"),
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    )
    .then(function(response) {
      self.limpiarDatos();
      self.message = "CURSO CREADO SATISFACTORIAMENTE";
      self.showAlert();
      console.log(response);
      self.Loading = false;
      self.AddModal = false;
    })
    .catch(function(error) {
      console.log(error);
      console.log(error.response.data);
      if (error.response.data.message == "SIN SALIR DE VUE ERROR") {
        self.message = "";
        for (let key in error.response.data.errors) {
          if (error.response.data.errors.hasOwnProperty(key)) {
            self.message += error.response.data.errors[key][0] + "  ";
          }
        }
        self.showAlert();
      } else {
        console.log(error);
        //self.$router.push({ path: 'login' });
      }
    });
}

/*
function guardar() {
  this.Loading = true;
  let self = this;
  let course = [];
  course = {
    description: self.description,
    price: self.price,
    daysofvalidity: self.daysofvalidity,
    status_id: 1,
    image: self.imagePath,
  };
  console.log(course);
  let url = "/api/courses?token=";
  axios
    .post(
      this.$apiAdress +
        "/api/courses?token=" +
        localStorage.getItem("api_token"),
      course
    )
    .then(function(response) {
      self.limpiarDatos();
      self.message = "Successfully created course.";
      self.showAlert();
      console.log(response);
    })
    .catch(function(error) {
      console.log(error);
      console.log(error.response.data);
      if (error.response.data.message == "SIN SALIR DE VUE ERROR") {
        self.message = "";
        for (let key in error.response.data.errors) {
          if (error.response.data.errors.hasOwnProperty(key)) {
            self.message += error.response.data.errors[key][0] + "  ";
          }
        }
        self.showAlert();
      } else {
        console.log(error);
        //self.$router.push({ path: 'login' });
      }
    });
}
*/

function limpiarDatos() {
  this.curso = {
    description: "",
    price: "",
    daysofvalidity: "",
    imagePath: "",
    status_id: "",
  };
  this.image = "";
}

function evaluaStatus() {
  if (this.Status === 2) {
    this.$swal
      .fire({
        text: `¿Esta seguro de realizar el cambio de status para el registro?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "CONFIRMAR",
        cancelButtonText: "CANCELAR",
      })
      .then((result) => {
        if (result.isConfirmed) {
          this.guardar();
        }
      });
  } else this.guardar();
}

//COMPUTED
function isDisabled() {
  return this.$v.$invalid;
}

//DATA
function data() {
  return {
    //MODELOS
    curso: {
      description: "",
      price: "",
      daysofvalidity: "",
      imagePath: "",
      status_id: 1,
    },
    // VARIABLES
    AddModal: false,
    Loading: false,
    actualizar: false,
    tituloModal: "",
    message: "",
    dismissSecs: 7,
    dismissCountDown: 0,
    showDismissibleAlert: false,
    statuses: [],
    image: null,
    files: [],
    filelist: [],
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
    type: String,
    default: "User id",
  },
  directives: UpperCase,
  validations: CursosVal,
  watch: {
    modal: function() {
      if (this.modal) {
        this.limpiarDatos();
        this.AddModal = true;
        if (this.modal == true) {
          this.tituloModal = "NUEVO CURSO";
          this.actualizar = false;
        } else {
          this.actualizar = true;
          this.tituloModal = "EDITAR CURSO";
          this.curso.description = this.modal.curso.description;
          this.curso.price = this.modal.curso.price;
          this.curso.imagePath = this.modal.curso.imagePath;
          this.curso.daysofvalidity = this.modal.curso.daysofvalidity;
          this.curso.status_id = this.modal.curso.status_id;
        }
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    evaluaStatus,
    limpiarDatos,
    guardar,
    uploadImage,
    //TRATAR DE MEJORAR ESTOS METODOS DEL INPUT FILE
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    onChange() {
      this.filelist = [...this.$refs.file.files];
      this.image = this.filelist[0];
      this.uploadImage();
      console.log(this.image);
    },
    remove(i) {
      this.filelist.splice(i, 1);
    },
    dragover(event) {
      event.preventDefault();
      // Add some visual fluff to show the user can drop its files
      if (!event.currentTarget.classList.contains("bg-green-300")) {
        event.currentTarget.classList.remove("bg-gray-100");
        event.currentTarget.classList.add("bg-green-300");
      }
    },
    dragleave(event) {
      // Clean up
      event.currentTarget.classList.add("bg-gray-100");
      event.currentTarget.classList.remove("bg-green-300");
    },
    drop(event) {
      event.preventDefault();
      this.$refs.file.files = event.dataTransfer.files;
      this.onChange(); // Trigger the onChange event manually
      // Clean up
      event.currentTarget.classList.add("bg-gray-100");
      event.currentTarget.classList.remove("bg-green-300");
    },
  },
  computed: {
    isDisabled,
  },
  mounted: function() {
    let self = this;
    axios
      .get(
        this.$apiAdress +
          "/api/products/create?token=" +
          localStorage.getItem("api_token")
      )
      .then(function(response) {
        self.statuses = response.data;
      })
      .catch(function(error) {
        console.log(error);
        //self.$router.push({ path: 'login' });
      });
  },
};
</script>
<style scoped>
.ocultar {
  display: none;
}
.block {
  cursor: pointer;
}
</style>

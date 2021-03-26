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
            v-model="$v.description.$model"
            :is-valid="hasError($v.description)"
          />
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            type="number"
            placeholder="0"
            invalid-feedback="Campo requerido {0,00}"
            label="PRECIO DEL CURSO"
            v-model="$v.price.$model"
            :is-valid="hasError($v.price)"
          />
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            type="number"
            placeholder="DIAS DE VIGENCIA"
            invalid-feedback="Campo requerido {0,00}"
            label="DIAS DE VIGENCIA"
            v-model="$v.daysofvalidity.$model"
            :is-valid="hasError($v.daysofvalidity)"
          />
        </CCol>
        <CCol sm="12">
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

function getImage(event) {
  //Asignamos la imagen a  nuestra data
  this.image = event.target.files[0];
}

function uploadImage() {
  this.Loading = true;
  let self = this;
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
  this.Loading = false;
}

function guardar() {
  this.Loading = true;
  let course = [];
  course = {
    description: this.description,
    price: this.price,
    daysofvalidity: this.daysofvalidity,
    status_id: 1,
    image: this.imagePath,
  };
  console.log(course);
  let url = "/api/courses?token=";
  axios
    .post(
      this.$apiAdress +
        "/api/courses?token=" +
        localStorage.getItem("api_token"),
      course,
      {
        root: "course",
      }
    )
    .then(function(response) {
      this.limpiarDatos();
      console.log(response);
      console.log(course);
      this.message = "Successfully created course.";
      this.showAlert();
    })
    .catch(function(error) {
      if (error.response.data.message == "The given data was invalid.") {
        this.message = "";
        for (let key in error.response.data.errors) {
          if (error.response.data.errors.hasOwnProperty(key)) {
            this.message += error.response.data.errors[key][0] + "  ";
          }
        }
        this.showAlert();
      } else {
        console.log(error);
        //self.$router.push({ path: 'login' });
      }
      this.Loading = false;
    });
}

function limpiarDatos() {
  this.description = "";
  this.price = "";
  this.daysofvalidity = "";
  this.image = "";
  status_id: null;
  this.imagePath = "";
  this.$nextTick(() => {
    this.$v.$reset();
  });
}

function evaluaStatus() {
  if (this.Status === 0) {
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
    description: "",
    price: "",
    daysofvalidity: "",
    imagePath: "",
    status_id: 1,

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
    getImage,
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

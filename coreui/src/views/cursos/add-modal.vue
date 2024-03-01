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
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            placeholder="Nombre del curso"
            invalid-feedback="Campo requerido"
            label="NOMBRE DEL CURSO"
            v-model="$v.curso.CourseName.$model"
            :is-valid="hasError($v.curso.CourseName)"
          />
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            type="number"
            placeholder="Dias de vigencia"
            invalid-feedback="Campo requerido solo enteros"
            label="DIAS DE VIGENCIA"
            v-model="$v.curso.daysofvalidity.$model"
            :is-valid="hasError($v.curso.daysofvalidity)"
            maxlength="10"
          />
        </CCol>
        <CCol sm="4">
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
        <CCol sm="4">
          <div class="custom-input-file mt-3">
            <input
              class="input-file"
              label="Imagen del curso"
              type="file"
              name="imagen"
              id="image"
              accept="image/*"
              @change="getImage"
              placeholder="Imagen del curso"
            />
            Imagen del curso...
          </div>
        </CCol>
        <!-- MOSTRAR IMAGEN EN MINIATURA -->
        <CCol sm="4">
          <figure v-if="imagenMiniatura != ''">
            <img
              id="imagenMiniatura"
              :src="imagenM"
              width="150"
              height="150"
              alt="Course Picture"
            />
          </figure>
        </CCol>
        <CCol sm="3" v-if="actualizar">
          <img
            :src="this.$apiAdress+'/storage/courses/' + this.curso.image"
            class="bd-placeholder-img card-img-top"
            width="150px"
            height="200px"
            aria-label="Placeholder: Image cap"
            role="img"
          />
        </CCol>
        <CCol sm="12" v-if="actualizar">
          <br />
          <CSelect
            label="Status"
            :value.sync="curso.status_id"
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
        <CButton color="dark" @click="CerrarLimpiar">
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
function CerrarLimpiar() {
  this.curso.description = "";
  this.curso.price = "";
  this.curso.daysofvalidity = "";
  this.curso.status_id = "";
  this.curso.CourseName = "";
  this.curso.image = "";
  this.AddModal = false;
  this.files = "";
  this.filelist = "";
}
//VISTA MINIATURA IMG
function CargarMiniatura(filelist) {
  let reader = new FileReader();
  reader.onload = (event) => {
    this.imageMiniature = event.target.result;
  };
  reader.readAsDataUrl(filelist);
}

//SUBE LA IMG AL STORAGE
/*function uploadImage() {
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
      self.$toastr.success("¡imagen agregada con exito!");
      self.imagePath = response.data.path;
      self.Loading = false;
    })
    .catch(function(error) {
      console.log(error);
      //self.$router.push({ path: '/login' });
    });
}*/

//GUARDA Y ACTUALIZA
function guardar() {
  let self = this;
  self.Loading = true;
  if (self.actualizar) {
    let formData = new FormData();
    formData.append("image", self.imageNueva);
    formData.append("CourseName", self.curso.CourseName);
    formData.append("description", self.curso.description);
    formData.append("status_id", self.curso.status_id);
    formData.append("price", self.curso.price);
    formData.append("daysofvalidity", self.curso.daysofvalidity);
    formData.append("_method", "PUT");

    axios
      .post(
        this.$apiAdress +
          "/api/courses/" +
          self.curso.id +
          "?token=" +
          localStorage.getItem("api_token"),
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      )
      .then(function(response) {
        self.$toastr.success("¡Curso actualizado con exito!");
        self.Loading = false;
        self.AddModal = false;
        self.limpiarDatos();
        self.$emit("child-refresh", true);
      })
      .catch(function(error) {
        self.Loading = false;
        self.$toastr.warning("¡Error, please try later!");
        if (error.response.data.message == "The given data was invalid.") {
          self.message = "";
          for (let key in error.response.data.errors) {
            if (error.response.data.errors.hasOwnProperty(key)) {
              self.message += error.response.data.errors[key][0] + "  ";
            }
          }
        } else {
          console.log(error);
          //self.$router.push({ path: '/login' });
        }
      });
  } else {
    let formData = new FormData();
    formData.append("image", self.imageNueva);
    formData.append("daysofvalidity", self.curso.daysofvalidity);
    formData.append("description", self.curso.description);
    formData.append("CourseName", self.curso.CourseName);
    formData.append("status_id", self.curso.status_id);
    formData.append("price", self.curso.price);
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
        self.$toastr.success("¡Curso creado con exito!");
        self.limpiarDatos();
        console.log(response);
        self.Loading = false;
        self.AddModal = false;
        self.$emit("child-refresh", true);
      })
      .catch(function(error) {
        console.log(error);
        if (error.response.data.message == "SIN SALIR DE VUE ERROR") {
          for (let key in error.response.data.errors) {
            if (error.response.data.errors.hasOwnProperty(key)) {
              self.message += error.response.data.errors[key][0] + "  ";
            }
          }
        }
      });
  }
}
//LIMPIA LOS CAMPOS
function limpiarDatos() {
  this.curso.description = "";
  this.curso.price = "";
  this.curso.daysofvalidity = "";
  this.curso.status_id = 1;
  this.curso.CourseName = "";
  this.curso.image = "";
  this.AddModal = false;
  this.files = "";
  this.filelist = "";
  this.imageNueva = null;
  this.imagenMiniatura = "";
}

//PERMITE INACTIVAR UN CURSO
function evaluaStatus() {
  if (this.curso.status_id === 2) {
    this.$swal
      .fire({
        text: `¿Esta seguro de inactivar este curso?`,
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

//CARGA LOS STATUS AL ACTUALIZAR
function Cstatus() {
  let self = this;
  self.Loading = true;
  axios
    .get(
      this.$apiAdress +
        "/api/courses/create?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      self.statuses = response.data;
      self.Loading = false;
    })
    .catch(function(error) {
      console.log(error);
      //self.$router.push({ path: 'login' });
    });
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
      price: 0,
      daysofvalidity: "",
      status_id: 1,
      CourseName: "",
    },
    // VARIABLES
    AddModal: false,
    Loading: false,
    actualizar: false,
    tituloModal: "",
    statuses: [],
    image: null,
    files: [],
    filelist: [],
    imageNueva: null,
    imagenMiniatura: "",
    imgdefaul: "img_default.webp"
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
    caption: {
      type: String,
      default: "curso id",
    },
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
          this.curso.id = this.modal.id;
          this.curso.CourseName = this.modal.CourseName;
          this.curso.description = this.modal.description;
          this.curso.daysofvalidity = this.modal.daysofvalidity;
          this.curso.price = this.modal.price;
          this.curso.image = this.modal.image == null?this.imgdefaul:this.modal.image;
          
          this.curso.status = this.modal.status == "Activo" ? 1 : 2;

          console.log(this.modal);
        }
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    evaluaStatus,
    limpiarDatos,
    guardar,
    CargarMiniatura,
    Cstatus,
    CerrarLimpiar,
    getImage(event) {
      //Asignamos la imagen a  nuestra data
      let filelist = event.target.files[0];
      this.imageNueva = filelist;
      this.cargarImagen(filelist);
      this.image = this.filelist;
    },
    cargarImagen(file) {
      let reader = new FileReader();
      reader.onload = (e) => {
        this.imagenMiniatura = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    /*
    onChange(event) {
      //Asignamos la imagen a  nuestra data
      let file = event.target.files[0];
      this.imageNueva = file;
      this.cargarImagen(file);
    },
    cargarImagen(file) {
      let reader = new FileReader();
      reader.onload = (e) => {
        this.imagenMiniatura = e.target.result;
      };
      reader.readAsDataURL(file);
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
    },*/
  },
  computed: {
    isDisabled,
    imagenM() {
      return this.imagenMiniatura;
    },
  },
  mounted: function() {
    this.Cstatus();
  },
};
</script>
<style scoped>
.custom-input-file {
  background-color: #aa8caf;
  color: #fff;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
  margin: 0;
  min-height: 15px;
  overflow: hidden;
  padding: 10px;
  position: relative;
  text-align: center;
  width: 200px;
}

.custom-input-file .input-file {
  border: 10000px solid transparent;
  cursor: pointer;
  font-size: 10000px;
  margin: 0;
  opacity: 0;
  outline: 0 none;
  padding: 0;
  position: absolute;
  right: -1000px;
  top: -1000px;
}
.block {
  cursor: pointer;
}
</style>

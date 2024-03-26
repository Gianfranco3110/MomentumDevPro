<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Carga tu imagen de fondo aquí</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <div class="custom-input-file mt-3">
              <input
                class="input-file mb-4"
                label="Imagen del curso"
                type="file"
                name="imagen"
                id="image"
                accept="image/*"
                @change="getImage"
                placeholder="Cargar Imagen de fondo"
              />
              Imagen de fondo...
            </div>
          </div>
          <div class="card-footer">
            <CButton @click="guardar" class="btn botonesCan text-white mr-4">
              <CIcon name="cil-check-circle" />&nbsp; GUARDAR CAMBIOS
            </CButton>
            <CButton
              @click="limpiarDatos"
              color="dark"
              v-if="imagenMiniatura != ''"
            >
              <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
            </CButton>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">

            <CRow class="mt-2">
      
              <!-- MOSTRAR IMAGEN EN MINIATURA -->
              <CCol v-if="imagenMiniatura != ''" sm="12" class="container">
                <figure >
                  <img
                    id="imagenMiniatura"
                    :src="imagenM"
                    class="w-100"
                    alt="Course Picture"
                  />
                </figure>
              </CCol>
              <CCol sm="12" v-if="imagenMiniatura == ''">
                <img
                  :src="this.$apiAdress + '/certificado-templete/cetificado.png'"
                  class="bd-placeholder-img card-img-top w-100"
                  aria-label="Placeholder: Image cap"
                  role="img"
                />
              </CCol>
            </CRow>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import UpperCase from "@/_validations/uppercase-directive";
import General from "@/_mixins/general";
import CursosVal from "@/_validations/cursos/CursosVal";
import axios from "axios";

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
  let formData = new FormData();
  formData.append("image", self.imageNueva);

  axios
    .post(
      this.$apiAdress +
        "/api/usercertificado/img/upload?token=" +
        localStorage.getItem("api_token"),
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    )
    .then(function (response) {
      console.log(response.data);
      self.$toastr.success("¡Imagen cargado correctamente!");
      self.Loading = false;
      self.imagenMiniatura = "";
      this.$forceUpdate();
    })
    .catch(function (error) {
      console.log(error);
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
}
//LIMPIA LOS CAMPOS
function limpiarDatos() {
  this.imageNueva = null;
  this.imagenMiniatura = "";
}

//COMPUTED
function isDisabled() {
  return this.$v.$invalid;
}

//DATA
function data() {
  return {
    Loading: false,
    image: null,
    files: [],
    filelist: [],
    imageNueva: null,
    imagenMiniatura: "",
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  directives: UpperCase,
  validations: CursosVal,

  methods: {
    limpiarDatos,
    guardar,
    CargarMiniatura,
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
  mounted: function () {},
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

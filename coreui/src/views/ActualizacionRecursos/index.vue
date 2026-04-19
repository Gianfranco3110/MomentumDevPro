<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />

    <CCard>
      <CCardHeader class="text-white" style="background-color: #202020">
        <strong>ACTUALIZACIÓN DE RECURSOS</strong>
      </CCardHeader>
      <CCardBody>
        <CRow>
          <CCol md="6">

            <!-- Selector de sección -->
            <div class="form-group">
              <label class="font-weight-bold">Sección</label>
              <select class="form-control" v-model="selectedSection" @change="onSectionChange">
                <option value="home_video">Video Inicial</option>
                <option value="login_image">Inicio Sesión</option>
                <option value="dashboard_banner">Banner Dashboard</option>
                <option value="register_image">Imagen Registro</option>
              </select>
            </div>

            <!-- Input de archivo -->
            <div class="form-group mt-3">
              <label class="font-weight-bold">
                {{ selectedSection === 'home_video' ? 'Archivo de video' : 'Imagen' }}
              </label>
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  readonly
                  :placeholder="selectedSection === 'home_video'
                    ? 'Selecciona un video (.mp4, .mov)'
                    : 'Selecciona una imagen (.jpg, .png, .webp)'"
                  :value="selectedFile ? selectedFile.name : ''"
                />
                <div class="input-group-append">
                  <button
                    class="btn botonesP text-white"
                    type="button"
                    @click="$refs.fileInput.click()"
                  >
                    <CIcon name="cil-folder-open" class="mr-1" /> Examinar
                  </button>
                </div>
              </div>
              <input
                ref="fileInput"
                type="file"
                :accept="fileAccept"
                @change="onFileChange"
                style="display: none;"
              />
              <small class="text-muted">
                {{ selectedSection === 'home_video'
                    ? 'Formatos aceptados: .mp4, .mov, .webm'
                    : 'Formatos aceptados: .jpg, .jpeg, .png, .webp' }}
              </small>
            </div>

            <!-- Botón de subida -->
            <button
              class="btn botonesP text-white mt-2"
              :disabled="!selectedFile"
              @click="uploadResource"
            >
              <CIcon name="cil-cloud-upload" class="mr-2" style="color: white !important;" />
              Subir y Actualizar
            </button>

          </CCol>

          <!-- Preview -->
          <CCol md="6" class="d-flex flex-column align-items-center justify-content-center">
            <div v-if="previewUrl" class="w-100 text-center">
              <p class="font-weight-bold mb-2">Vista previa</p>
              <video
                v-if="selectedSection === 'home_video'"
                :src="previewUrl"
                controls
                class="w-100"
                style="max-height: 280px; border-radius: 8px;"
              ></video>
              <img
                v-else
                :src="previewUrl"
                class="img-fluid"
                style="max-height: 280px; border-radius: 8px; object-fit: cover;"
                alt="Vista previa"
              />
            </div>
            <div v-else class="text-muted text-center">
              <CIcon name="cil-image" size="3xl" /><br />
              <span>La vista previa aparecerá aquí</span>
            </div>
          </CCol>
        </CRow>
      </CCardBody>
    </CCard>

    <!-- Tabla del recurso actual -->
    <CCard class="mt-4">
      <CCardHeader class="text-white" style="background-color: #202020">
        <strong>RECURSO ACTUAL</strong>
      </CCardHeader>
      <CCardBody>
        <div v-if="currentUrl" class="text-center">
          <video
            v-if="selectedSection === 'home_video'"
            :src="currentUrl"
            controls
            class="w-100"
            style="max-height: 300px; border-radius: 8px;"
          ></video>
          <img
            v-else
            :src="currentUrl"
            class="img-fluid"
            style="max-height: 300px; border-radius: 8px; object-fit: cover;"
            alt="Recurso actual"
          />
          <p class="mt-2 text-muted" style="font-size: 0.85rem; word-break: break-all;">
            {{ currentUrl }}
          </p>
          <button
            class="btn btn-danger mt-2"
            @click="resetResource"
          >
            <CIcon name="cil-action-undo" class="mr-2" />
            Restablecer por defecto
          </button>
        </div>
        <div v-else class="text-center py-2">
          <p class="text-muted mb-2" style="font-size: 0.9rem;">
            No hay recurso personalizado. Actualmente se muestra el archivo por defecto del sistema:
          </p>
          <video
            v-if="selectedSection === 'home_video'"
            :src="defaultUrl"
            controls
            class="w-100"
            style="max-height: 300px; border-radius: 8px; opacity: 0.7;"
          ></video>
          <img
            v-else
            :src="defaultUrl"
            class="img-fluid"
            style="max-height: 300px; border-radius: 8px; object-fit: cover; opacity: 0.7;"
            alt="Recurso por defecto"
          />
          <p class="mt-1 text-muted" style="font-size: 0.8rem;">
            Archivo por defecto: <em>{{ defaultResources[selectedSection] }}</em>
          </p>
        </div>
      </CCardBody>
    </CCard>

  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ActualizacionRecursos",
  data() {
    return {
      Loading: false,
      selectedSection: "home_video",
      selectedFile: null,
      previewUrl: null,
      currentUrl: null,
      sectionOptions: [
        { label: "Video Inicial", value: "home_video" },
        { label: "Inicio Sesión", value: "login_image" },
        { label: "Banner Dashboard", value: "dashboard_banner" },
        { label: "Imagen Registro", value: "register_image" },
      ],
      defaultResources: {
        home_video: '/home.mov',
        login_image: '/login1.jpg',
        dashboard_banner: '/logo_alterno/logo alterno color oro.png',
        register_image: '/login1.jpg',
      },
    };
  },
  computed: {
    fileAccept() {
      return this.selectedSection === "home_video"
        ? "video/mp4,video/quicktime,video/webm"
        : "image/jpeg,image/png,image/webp";
    },
    defaultUrl() {
      return this.defaultResources[this.selectedSection] || null;
    },
  },
  methods: {
    onSectionChange() {
      this.selectedFile = null;
      this.previewUrl = null;
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = "";
      }
      this.loadCurrentResource();
    },
    onFileChange(e) {
      const file = e.target.files[0];
      if (!file) return;
      this.selectedFile = file;
      this.previewUrl = URL.createObjectURL(file);
    },
    loadCurrentResource() {
      let self = this;
      axios
        .get(
          this.$apiAdress +
            "/api/site-resources/" +
            this.selectedSection +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function (response) {
          self.currentUrl = response.data.url || null;
        })
        .catch(function (error) {
          console.log(error);
          self.currentUrl = null;
        });
    },
    resetResource() {
      let self = this;
      this.$swal
        .fire({
          title: '¿Restablecer recurso?',
          text: 'Se eliminará el archivo personalizado se volverá al recurso por defecto del sistema.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#202020',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Sí, restablecer',
          cancelButtonText: 'Cancelar',
        })
        .then((result) => {
          if (!result.isConfirmed) return;
          self.Loading = true;
          axios
            .delete(
              self.$apiAdress +
                '/api/site-resources/' +
                self.selectedSection +
                '?token=' +
                localStorage.getItem('api_token')
            )
            .then(function () {
              self.Loading = false;
              self.currentUrl = null;
              self.$toastr.success('¡Recurso restablecido al valor por defecto!');
            })
            .catch(function (error) {
              self.Loading = false;
              const msg =
                error.response && error.response.data.message
                  ? error.response.data.message
                  : 'Error al restablecer el recurso.';
              self.$toastr.error('¡Error! ' + msg);
            });
        });
    },
    uploadResource() {
      if (!this.selectedFile) return;

      let self = this;
      self.Loading = true;

      const formData = new FormData();
      formData.append("section", this.selectedSection);
      formData.append("file", this.selectedFile);

      axios
        .post(
          this.$apiAdress +
            "/api/site-resources/upload?token=" +
            localStorage.getItem("api_token"),
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        )
        .then(function (response) {
          self.Loading = false;
          self.currentUrl = response.data.url;
          self.selectedFile = null;
          self.previewUrl = null;
          if (self.$refs.fileInput) {
            self.$refs.fileInput.value = "";
          }
          self.$toastr.success("¡Recurso actualizado correctamente!");
        })
        .catch(function (error) {
          self.Loading = false;
          if (error.response) {
            const msg =
              error.response.data.message ||
              "Error al subir el archivo.";
            self.$toastr.error("¡Error! " + msg);
          } else {
            self.$toastr.error("¡Error de conexión!");
          }
        });
    },
  },
  mounted() {
    this.loadCurrentResource();
  },
};
</script>

<style scoped>
.card-header {
  border-radius: 0 !important;
}
</style>

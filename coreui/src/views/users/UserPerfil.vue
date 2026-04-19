<template>
  <div class="d-flex align-items-start min-vh-50 py-4">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CContainer fluid>
      <transition name="slide">
        <CRow class="justify-content-center">
          <CCol md="8">

            <!-- Foto de Perfil -->
            <CCard class="mx-4 mb-4">
              <CCardHeader class="text-center botonesP text-white">
                <b>FOTO DE PERFIL</b>
              </CCardHeader>
              <CCardBody class="p-4 text-center">
                <div class="mb-3">
                  <img
                    :src="photoPreview || defaultAvatar"
                    class="profile-avatar rounded-circle mb-3"
                    alt="Foto de perfil"
                  />
                </div>
                <div class="d-flex justify-content-center align-items-center flex-wrap" style="gap:12px;">
                  <label class="btn botonesCan text-white mb-0" style="cursor:pointer;">
                    SELECCIONAR FOTO
                    <input
                      type="file"
                      accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                      style="display:none;"
                      @change="onPhotoSelected"
                    />
                  </label>
                  <CButton
                    class="btn botonesCan text-white"
                    :disabled="!selectedPhoto || uploadingPhoto"
                    @click="uploadPhoto"
                  >
                    {{ uploadingPhoto ? 'SUBIENDO...' : 'SUBIR FOTO' }}
                  </CButton>
                </div>
                <p v-if="selectedPhoto" class="mt-2 mb-0" style="color:#DCBA0F; font-size:0.85rem;">
                  Archivo seleccionado: {{ selectedPhoto.name }}
                </p>
              </CCardBody>
            </CCard>

            <!-- Datos del Perfil -->
            <CCard class="mx-4 mb-0">
              <CCardHeader class="text-center botonesP text-white">
                <b>MIS DATOS</b>
              </CCardHeader>
              <CCardBody class="p-4">
                <CForm>

                  <!-- Correo — solo lectura -->
                  <div class="form-group">
                    <label class="field-label">Correo electrónico</label>
                    <div class="readonly-field">
                      <CIcon name="cil-envelope-closed" class="field-icon" />
                      <span>{{ form.email }}</span>
                      <span class="readonly-badge">No editable</span>
                    </div>
                  </div>

                  <CInput
                    label="Nombre completo"
                    placeholder="Tu nombre completo"
                    v-model="form.name"
                  >
                    <template #prepend-content><CIcon name="cil-user" /></template>
                  </CInput>

                  <CInput
                    label="Dirección completa"
                    placeholder="Dirección de referencia completa"
                    v-model="form.adress_all"
                  >
                    <template #prepend-content><CIcon name="cil-home" /></template>
                  </CInput>

                  <CRow>
                    <CCol md="4">
                      <div class="form-group">
                        <label class="field-label">Tipo de documento</label>
                        <select class="form-control" v-model="form.type_document">
                          <option value="">-- Seleccionar --</option>
                          <option value="V">V</option>
                          <option value="E">E</option>
                        </select>
                      </div>
                    </CCol>
                    <CCol md="8">
                      <CInput
                        label="Número de documento"
                        placeholder="Número de documento"
                        v-model="form.number_document"
                        type="number"
                      >
                        <template #prepend-content><CIcon name="cil-description" /></template>
                      </CInput>
                    </CCol>
                  </CRow>

                  <CButton
                    class="btn botonesCan text-white mt-2"
                    block
                    @click="saveProfile"
                  >
                    GUARDAR CAMBIOS
                  </CButton>
                </CForm>
              </CCardBody>
            </CCard>

          </CCol>
        </CRow>
      </transition>
    </CContainer>
  </div>
</template>

<script>
import axios from 'axios';
import General from '@/_mixins/general';

export default {
  name: 'UserPerfil',
  mixins: [General],
  data() {
    return {
      Loading: false,
      uploadingPhoto: false,
      selectedPhoto: null,
      photoPreview: null,
      defaultAvatar: 'img/avatars/icon_user.webp',
      form: {
        email: '',
        name: '',
        country: '',
        stated: '',
        municipality: '',
        street: '',
        adress_all: '',
        type_document: '',
        number_document: '',
      },
    };
  },
  methods: {
    loadProfile() {
      let self = this;
      self.Loading = true;
      axios
        .get(
          this.$apiAdress + '/api/user/profile?token=' + localStorage.getItem('api_token')
        )
        .then(function (response) {
          const data = response.data;
          self.form.email           = data.email          || '';
          self.form.name            = data.name           || '';
          self.form.country         = data.country        || '';
          self.form.stated          = data.stated         || '';
          self.form.municipality    = data.municipality   || '';
          self.form.street          = data.street         || '';
          self.form.adress_all      = data.adress_all     || '';
          self.form.type_document   = data.type_document  || '';
          self.form.number_document = data.number_document || '';

          if (data.photo) {
            self.photoPreview = self.$apiAdress + data.photo + '?t=' + Date.now();
            localStorage.setItem('photo_url', self.photoPreview);
          } else {
            self.photoPreview = null;
          }
          self.Loading = false;
        })
        .catch(function (e) {
          self.Loading = false;
          console.error(e);
          self.$toastr.error('Error al cargar el perfil.');
        });
    },

    saveProfile() {
      let self = this;
      self.Loading = true;
      axios
        .post(
          this.$apiAdress + '/api/user/profile/update?token=' + localStorage.getItem('api_token'),
          {
            name:            self.form.name,
            country:         self.form.country,
            stated:          self.form.stated,
            municipality:    self.form.municipality,
            street:          self.form.street,
            adress_all:      self.form.adress_all,
            type_document:   self.form.type_document,
            number_document: self.form.number_document,
          }
        )
        .then(function () {
          self.Loading = false;
          localStorage.setItem('name', self.form.name);
          self.$bus.$emit('name-updated', self.form.name);
          self.$swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '¡Perfil actualizado con éxito!',
            showConfirmButton: false,
            timer: 1400,
          });
        })
        .catch(function (e) {
          self.Loading = false;
          console.error(e);
          self.$toastr.error('Error al actualizar el perfil.');
        });
    },

    onPhotoSelected(event) {
      const file = event.target.files[0];
      if (!file) return;
      this.selectedPhoto = file;
      this.photoPreview = URL.createObjectURL(file);
    },

    uploadPhoto() {
      if (!this.selectedPhoto) return;
      let self = this;
      self.uploadingPhoto = true;
      const formData = new FormData();
      formData.append('photo', self.selectedPhoto);
      axios
        .post(
          this.$apiAdress + '/api/user/photo/upload?token=' + localStorage.getItem('api_token'),
          formData,
          { headers: { 'Content-Type': 'multipart/form-data' } }
        )
        .then(function (response) {
          self.uploadingPhoto = false;
          self.selectedPhoto = null;
          const fullUrl = self.$apiAdress + response.data.photo_url + '?t=' + Date.now();
          self.photoPreview = fullUrl;
          localStorage.setItem('photo_url', fullUrl);
          self.$bus.$emit('photo-updated', fullUrl);
          self.$swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '¡Foto de perfil actualizada!',
            showConfirmButton: false,
            timer: 1400,
          });
        })
        .catch(function (e) {
          self.uploadingPhoto = false;
          console.error(e);
          self.$toastr.error('Error al subir la foto.');
        });
    },
  },
  mounted() {
    this.loadProfile();
  },
};
</script>

<style scoped>
.profile-avatar {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border: 3px solid #DCBA0F;
}

.field-label {
  font-size: 0.875rem;
  margin-bottom: 4px;
  display: block;
  color: inherit;
}

.readonly-field {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f4f4f4;
  border: 1px solid #d8dbe0;
  border-radius: 4px;
  padding: 8px 12px;
  margin-bottom: 1rem;
  color: #888;
  font-size: 0.9rem;
}

.field-icon {
  color: #aaa;
  flex-shrink: 0;
}

.readonly-badge {
  margin-left: auto;
  font-size: 0.75rem;
  background: #e0e0e0;
  color: #666;
  border-radius: 4px;
  padding: 2px 8px;
  white-space: nowrap;
}
</style>

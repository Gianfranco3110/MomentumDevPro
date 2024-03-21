<template>
  <div class="d-flex align-items-center min-vh-50">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CContainer fluid>
      <transition name="slide">
        <CRow class="justify-content-center">
          <CCol md="6">
            <CCard class="mx-4 mb-0">
              <CCardHeader class="text-center botonesP text-white">
                <b>CAMBIAR CONTRASEÑA</b>
              </CCardHeader>
              <CCardBody class="p-4">
                <CForm>
                  <CInput
                    placeholder="Nueva contraseña"
                    type="password"
                    prependHtml="<i class='cui-lock-locked'></i>"
                    autocomplete="new-password"
                    v-model="password"
                  >
                    <template #prepend-content
                      ><CIcon name="cil-lock-locked"
                    /></template>
                  </CInput>
                  <CInput
                    placeholder="Repita la contraseña"
                    type="password"
                    prependHtml="<i class='cui-lock-locked'></i>"
                    autocomplete="confirm-password"
                    class="mb-4"
                    v-model="password_confirmation"
                  >
                    <template #prepend-content
                      ><CIcon name="cil-lock-locked"
                    /></template>
                  </CInput>
                  <CButton class="btn botonesCan text-white" block @click="changePassword()"
                    >CAMBIAR CONTRASEÑA</CButton
                  >
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
import axios from "axios";
import General from "@/_mixins/general";

export default {
  name: "UserAjustes",
  mixins: [General],
  components: {
    General,
  },
  data() {
    return {
      password: "",
      password_confirmation: "",
      Loading: false,
    };
  },
  methods: {
    changePassword() {
      let self = this;
      self.Loading = true;
      axios
        .post(
          this.$apiAdress +
            "/api/user/password/change?token=" +
            localStorage.getItem("api_token"),
          {
            _method: "PUT",
            password: self.password,
            password_confirmation: self.password_confirmation,
          }
        )
        .then(function(response) {
          self.password = "";
          (self.password_confirmation = ""), (self.Loading = false);
          self.$toastr.success("¡Contraseña actualizada con exito!");
        })
        .catch(function(e) {
          self.password = "";
          (self.password_confirmation = ""), (self.Loading = false);
          console.log(e);
          self.$toastr.error("¡Error al actualizar contraseña!");
        });
    },
  },
  mounted: function() {},
};
</script>
<style scoped></style>

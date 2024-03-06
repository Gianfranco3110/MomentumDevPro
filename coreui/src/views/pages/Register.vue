<template>
  <div class="d-flex align-items-center min-vh-100">
    <CContainer fluid>
      <CRow class="justify-content-center">
        <CCol md="4">
          <CCard class="mx-4 mb-0">
            <CCardBody class="p-4">
              <CForm @submit.prevent="register" method="POST">
                <h1>Registrarse</h1>
                <p class="text-muted">Crea tu cuenta</p>
                <CInput
                  placeholder="Username"
                  prependHtml="<i class='cui-user'></i>"
                  autocomplete="username"
                  v-model="$v.dataUser.name.$model"
                :is-valid="hasError($v.dataUser.name)"
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CInput
                  placeholder="Email"
                  prepend="@"
                  autocomplete="email"
                  v-model="$v.dataUser.email.$model"
                :is-valid="hasError($v.dataUser.email)"
                />
                <CInput
                  placeholder="Contraseña"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  v-model="$v.dataUser.password.$model"
                :is-valid="hasError($v.dataUser.password)"
                >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CInput
                  placeholder="Repetir contraseña"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  class="mb-4"
                  v-model="dataUser.confirmPassword"
                >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CButton  :disabled="isDisabled" class="botonesP text-white w-auto text-center px-5 pt-2 pb-2  " type="submit"  block
                  >Crear Cuenta</CButton
                >
              </CForm>
            </CCardBody>
           <!-- <CCardFooter class="p-4">
              <CRow>
                <CCol col="6">
                  <CButton @click="Sweet" block color="facebook">
                    Facebook
                  </CButton>
                </CCol>
                <CCol col="6">
                  <CButton block color="twitter">
                    Twitter
                  </CButton>
                </CCol>
              </CRow>
            </CCardFooter>-->
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      dataUser: {
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
    },

    };
  },
  mixins: [General],
  computed: {
    isDisabled,
  },
  directives: UpperCase,
  validations: Registerval,
  methods: {
    register() {
      var self = this;
      axios
        .post(this.$apiAdress + "/api/register", {
          name: self.dataUser.name,
          email: self.dataUser.email,
          password: self.dataUser.password,
          password_confirmation: self.dataUser.password_confirmation,
        })
        .then(function(response) {
          self.name = "";
          self.email = "";
          self.password = "";
          self.password_confirmation = "";
          console.log(response);
          self.$router.push({ path: "/login" });
        })
        .catch(function(error) {
          console.log(error);
        });
    },
  },
};
</script>

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
                <CTextarea
                  addLabelClasses="required"
                  rows="5"
                  placeholder="Ingrese la dirección exacta"
                  v-model="$v.dataUser.adress.$model"
                  :is-valid="hasError($v.dataUser.adress)"
                />
                <CRow >
                  <CCol md="2">
                    <!--<CSelect
                      :options="[{'V':'V'},{'E':'E'},]"
                      v-model="$v.dataUser.type_document.$model"
                      :is-valid="hasError($v.dataUser.type_document)"
                    />-->
                    <select v-model="dataUser.type_document" class="form-select form-control" aria-label="Default select example">
                      <option value="V" selected>V</option>
                      <option value="E">E</option>
                    </select>
                  </CCol>
                  <CCol md="10">
                    <CInput
                      placeholder="Numero de documento"
                      prependHtml="<i class='cui-user'></i>"
                      autocomplete="Numero de documento"
                      v-model="$v.dataUser.number_document.$model"
                    :is-valid="hasError($v.dataUser.number_document)"
                    >
                      <template #prepend-content><CIcon name="cil-user"/></template>
                    </CInput>
                  </CCol>
                </CRow>
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
                  v-model="$v.dataUser.confirmPassword.$model"
                  :is-valid="hasError($v.dataUser.confirmPassword)"
                   invalid-feedback="Debe coincidir con el password"
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
import General from "@/_mixins/general";
import UpperCase from "@/_validations/uppercase-directive";
import Registerval from "@/_validations/register/RegisterVal";


//COMPUTED
function isDisabled() {
  return this.$v.$invalid;
}


export default {
  data() {
    return {
      dataUser: {
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
      adress: "",
      type_document: "V",
      number_document: ""
    },

    };
  },
  mixins: [General],
  computed: {
    isDisabled,
  },
  directives: UpperCase,
  validations() {
    return Registerval()
  },
  methods: {
    register() {
      var self = this;
      axios
        .post(this.$apiAdress + "/api/register", {
          name: self.dataUser.name,
          email: self.dataUser.email,
          password: self.dataUser.password,
          password_confirmation: self.dataUser.confirmPassword,
          type_document: self.dataUser.type_document,
          number_document: self.dataUser.number_document,
          adress_all: self.dataUser.adress,
        })
        .then(function(response) {
          self.dataUser.name = "";
          self.dataUser.email = "";
          self.dataUser.password = "";
          self.dataUser.password_confirmation = "";
          self.dataUser.type_document = "V";
          self.dataUser.number_document = "";
          self.dataUser.adress = "";
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

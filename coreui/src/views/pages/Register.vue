<template>
  <section class="vh-100" style="background-color: #C38154;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-12">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="../../../public/register.jpg"
                  alt="login form" class="img-fluid h-100 img-adapte" style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                
                <div class="card-body p-4 p-lg-5 text-black">
                 
                  <h4 class="fw-normal mb-3" style="letter-spacing: 1px;">Crea tu cuenta</h4>
                  <form  @submit.prevent="register" method="POST">
                    <div class="form-outline mb13">
                      <label class="form-label" >Nombres</label>
                      <CInput
                          placeholder="Ingrese su nombre"
                          autocomplete="username" size="lg"
                          v-model="$v.dataUser.name.$model"
                        :is-valid="hasError($v.dataUser.name)"
                        >
                      </CInput>
                    </div>

                    <div class="form-outline mb-1">
                      <label class="form-label" >Correo</label>
                      <CInput
                          placeholder="Ingrese el correo"
                          size="lg"
                          v-model="$v.dataUser.email.$model"
                        :is-valid="hasError($v.dataUser.email)"
                        :invalid-feedback="msgErrorEmail"
                        />
                    </div>

                    <div class="form-outline mb-1">
                      <label class="form-label" >Documento de identidad</label>
                      <CRow >
                        <CCol md="3">
                          <select v-model="dataUser.type_document" class="form-select form-control form-control-lg" aria-label="Default select example">
                            <option value="V" selected>V</option>
                            <option value="E">E</option>
                          </select>
                        </CCol>
                        <CCol md="9">
                          <CInput
                            placeholder="Numero de documento"
                            size="lg"
                            v-model="$v.dataUser.number_document.$model"
                          :is-valid="hasError($v.dataUser.number_document)"
                          >
                          </CInput>
                        </CCol>
                      </CRow>
                    </div>
  
                    <div class="form-outline mb-1">
                      <label class="form-label">Contraseña</label>
                        <CInput
                        placeholder="Ingrese la contraseña"
                        size="lg"
                        type="password"
                        v-model="$v.dataUser.password.$model"
                        :is-valid="hasError($v.dataUser.password)"
                      >
                      </CInput>
                    </div>

                    <div class="form-outline mb-1">
                      <label class="form-label">Confirmacón de Contraseña</label>
                        <CInput
                        placeholder="Confirmar contraseña"
                        type="password"
                        size="lg"
                        class="mb-4"
                        v-model="$v.dataUser.confirmPassword.$model"
                        :is-valid="hasError($v.dataUser.confirmPassword)"
                        invalid-feedback="Debe coincidir con la contraseña"
                      >
                      </CInput>
                    </div>

                    <div class="form-outline mb-2">
                      <label class="form-label">Dirección</label>
                        <CTextarea
                          size="lg"
                          addLabelClasses="required"
                          rows="3"
                          placeholder="Ingrese la dirección exacta"
                          v-model="$v.dataUser.adress.$model"
                          :is-valid="hasError($v.dataUser.adress)"
                        />
                    </div>

                    <div class="pt-1 mb-4">
                      <button  type="submit" :disabled="isDisabled" class="btn botonesP btn-lg btn-block text-white">Iniciar</button>
                    </div>
  
                    <!--<a class="small text-muted" href="#!">Has olvidado tu contraseña?</a>-->
                    <p class=" pb-lg-2" style="color: #393f81;">Ya tienes cuenta? <a href="#"
                        style="color: #393f81;" @click="goLogin()">Ingresa aquí</a></p>
             
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<!--<div class="d-flex align-items-center min-vh-100">
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
                
                <CRow >
                  <CCol md="2">
             
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
                <CTextarea
                  addLabelClasses="required"
                  rows="5"
                  placeholder="Ingrese la dirección exacta"
                  v-model="$v.dataUser.adress.$model"
                  :is-valid="hasError($v.dataUser.adress)"
                />
                <div class="d-flex justify-content-between mt-3">
                  <CButton  :disabled="isDisabled" class="botonesP text-white w-auto text-center px-5 pt-2 pb-2  " type="submit"  block
                    >Crear Cuenta</CButton>
  
                    <CButton @click="linkHome()"  class="btn btn-dark text-white w-auto text-center px-5 pt-2 pb-2  mt-0" type="submit"  block
                    >Cancelar</CButton>
                </div>
              </CForm>
            </CCardBody>
        
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>-->
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
    msgErrorEmail:""

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
          if (error.response) {
            if (error.response.status === 422) {
              console.error('Error:', error.response.data);
              if ('email' in error.response.data.errors) {
                // self.classInvaEmail = "is-invalid";
                self.msgErrorEmail = error.response.data.errors.email[0];
                self.$toastr.defaultPosition = "toast-bottom-left";
                self.$toastr.error(`${error.response.data.errors.email[0]}`,"!Upss, Tienes un problema¡");
              }else{
                // self.classInvaEmail = "is-valid";
                self.msgErrorEmail = "";
              }

              if (error.response.data.errors.number_document) {
                self.msgError = error.response.data.errors.number_document[0];
                self.$toastr.error(`${error.response.data.errors.number_document[0]}`,"!Upss, Tienes un problema¡");
                
              }
            }
          }
        });
    },
    linkHome() {
      this.$router.push({ path: "/" });
    },
    goLogin() {
      this.$router.push({ path: "/login" });
    },
  },
};
</script>

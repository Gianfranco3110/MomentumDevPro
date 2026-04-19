<template>
  <section  style="background-color: #202020;">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-12">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block" style="position: relative; overflow: hidden; min-height: 500px; border-radius: 1rem 0 0 1rem;">
                <img :src="registerImageSrc"
                  alt="login form" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                
                <div class="card-body p-4 p-lg-5 text-black">
                  <div class="d-flex align-items-center mb-3 pb-1" @click="linkHome">
                      
                      <img  src="../../../public/logo_alterno/logo alterno color negro.png"
                  alt="login form" class="img-fluid w-75" style="border-radius: 1rem 0 0 1rem;" />
                      
                    </div>
                  <h4 class="fw-normal mb-3" style="letter-spacing: 1px; color:black !important">Crea tu cuenta</h4>
                  <form  @submit.prevent="register" method="POST">
                    <div class="form-outline mb13">
                      <label class="form-label mb-1 required" >Nombres</label>
                      <CInput
                          placeholder="Ingrese su nombre"
                          autocomplete="username" 
                          v-model="$v.dataUser.name.$model"
                        :is-valid="hasError($v.dataUser.name)"
                        >
                      </CInput>
                    </div>

                    <div class="form-outline mb-1">
                      <label class="form-label mb-1 required" >Correo</label>
                      <CInput
                          placeholder="Ingrese el correo"
                          v-model="$v.dataUser.email.$model"
                        :is-valid="hasError($v.dataUser.email)"
                        :invalid-feedback="msgErrorEmail"
                        />
                    </div>

                    <div class="form-outline mb-1">
                      <label class="form-label mb-1 required" >Documento de identidad</label>
                      <CRow >
                        <CCol md="3">
                          <select v-model="dataUser.type_document" class="form-select form-control " aria-label="Default select example">
                            <option value="V" selected>V</option>
                            <option value="E">E</option>
                          </select>
                        </CCol>
                        <CCol md="9">
                          <CInput
                            placeholder="Numero de documento"
                            v-model="$v.dataUser.number_document.$model"
                          :is-valid="hasError($v.dataUser.number_document)"
                          >
                          </CInput>
                        </CCol>
                      </CRow>
                    </div>
  
                    <div class="form-outline mb-1">
                      <label class="form-label mb-1 required">Contraseña</label>
                        <CInput
                        placeholder="Ingrese la contraseña"
                        type="password"
                        v-model="$v.dataUser.password.$model"
                        :is-valid="hasError($v.dataUser.password)"
                      >
                      </CInput>
                    </div>

                    <div class="form-outline mb-1 ">
                      <label class="form-label mb-1 required">Confirmacón de Contraseña</label>
                        <CInput
                        placeholder="Confirmar contraseña"
                        type="password"
                        class="mb-4"
                        v-model="$v.dataUser.confirmPassword.$model"
                        :is-valid="hasError($v.dataUser.confirmPassword)"
                        invalid-feedback="Debe coincidir con la contraseña"
                      >
                      </CInput>
                    </div>
                    <CRow >
                    <CCol md="4">
                    <CSelect
                      addLabelClasses="required"
                      label="Pais"
                      :value.sync="dataUser.value_pais"
                      invalid-feedback="Campo requerido"
                      :plain="true"
                      :options="arr_pais"
                      @change="changeGetPais()"
                  >
                  </CSelect>
                  </CCol>
                    <CCol md="4">
                      <label class="form-label mb-1 required">Estado</label>
                      <CSelect
                      addLabelClasses="required"
                      :value.sync="dataUser.value_stated"
                      invalid-feedback="Campo requerido"
                      :plain="true"
                      :options="stated"
                      @change="changeGetMunici()"
                    >
                    </CSelect>
                    </CCol>
                    <CCol md="4">
                      <label class="form-label mb-1 required">Ciudad</label>
                      <CSelect
                      addLabelClasses="required"
                      :value.sync="dataUser.value_municipality"
                      invalid-feedback="Campo requerido"
                      :plain="true"
                      :options="municipality"
                    >
                    </CSelect>
                    </CCol>

                    </CRow>
                    <div class="form-outline mb-1">
                      <label class="form-label mb-1 required">Calle</label>
                      <CInput
                      addLabelClasses="required"
                      placeholder="calle"
                      type="text"
                      v-model="$v.dataUser.street.$model"
                    :is-valid="hasError($v.dataUser.street)"
                    >
                
                    </CInput>
                    </div>

                    <div class="form-outline mb-2">
                      <label class="form-label mb-1 required">Dirección</label>
                        <CTextarea
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
                    <p class=" pb-lg-2" style="color:black !important;">Ya tienes cuenta? <a href="#"
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
      number_document: "",
      value_stated: "",
      value_pais: "",
      value_municipality: "",
    },
    Loading: false,
    msgErrorEmail:"",
    stated: [],
    municipality: [],
    arr_pais:[],
    registerImageSrc: require("../../../public/login1.jpg"),
    };
  },
  name:"Register",
  mixins: [General],
  computed: {
    isDisabled,
  },
  directives: UpperCase,
  validations() {
    return Registerval()
  },
  mounted: async function() {
    this.arr_pais = await this.getpais();
    this.loadRegisterImage();
  },
  methods: {
    loadRegisterImage() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/site-resources/register_image")
        .then(function (response) {
          if (response.data.url) {
            self.registerImageSrc = response.data.url;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    register() {
      var self = this;
      self.Loading = true;
      axios
        .post(this.$apiAdress + "/api/register", {
          name: self.dataUser.name,
          email: self.dataUser.email,
          password: self.dataUser.password,
          password_confirmation: self.dataUser.confirmPassword,
          type_document: self.dataUser.type_document,
          number_document: self.dataUser.number_document,
          adress_all: self.dataUser.adress,
          country: self.dataUser.value_pais,
          stated: self.dataUser.value_stated,
          municipality: self.dataUser.value_municipality,
          street: self.dataUser.street,
        })
        .then(function(response) {
          self.dataUser.name = "";
          self.dataUser.email = "";
          self.dataUser.password = "";
          self.dataUser.password_confirmation = "";
          self.dataUser.type_document = "V";
          self.dataUser.number_document = "";
          self.dataUser.adress = "";
          self.dataUser.street = "";
          self.$swal.fire({
            position: "top-end",
            icon: "success",
            title: "Usuario creado con exito",
            showConfirmButton: false,
            timer: 1400,
          });
          self.$router.push({ path: "/login" });
          self.Loading = false;
        })
        .catch(function(error) {
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
          self.Loading = false;
        });
    },
    linkHome() {
      this.$router.push({ path: "/curso-online" });
    },
    goLogin() {
      this.$router.push({ path: "login" });
    },
    async getStateds(val) {
      this.stated = await this.getStated(val);
    },
    async changeGetPais(){
      this.getStateds(this.dataUser.value_pais);
    },
    async changeGetMunici(){
      //console.log(this.dataUser.value_stated);
      this.municipality = await this.getMunicipality(this.dataUser.value_stated);
    }
  },
};
</script>


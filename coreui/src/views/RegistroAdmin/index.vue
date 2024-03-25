<template>
  <div>
    <loading-overlay :active="dataUser.Loading" :is-full-page="true" loader="bars" />
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="7">
          <CCard>
            <CCardHeader class="text-center botonesP text-white">
              <b>REGISTRO DE USUARIOS</b>
            </CCardHeader>
            <CCardBody class="p-4">
              <CAlert color="danger" :show="showAlerError"  closeButton>
                {{ msgError }}
              </CAlert>
              <CForm @submit.prevent="register" method="POST">
                <CInput
                  addLabelClasses="required"
                  label="NOMBRE"
                  placeholder="Nombre"
                  prependHtml="<i class='cui-user'></i>"
                  autocomplete="Usuario"
                  v-model="$v.dataUser.name.$model"
                :is-valid="hasError($v.dataUser.name)"
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CInput
                  addLabelClasses="required"
                  label="CORREO"
                  placeholder="Correo"
                  prepend="@"
                  autocomplete="email"
                  v-model="$v.dataUser.email.$model"
                :is-valid="hasError($v.dataUser.email)"
                />
              
                <CRow >
                  <CCol md="12">
                    <label  class="required"> IDENTIFICACIÓN </label>
                  </CCol>
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
                  <CCol md="10" class="pl-0">
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
                  addLabelClasses="required"
                  label="CONTRASEÑA"
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
                  addLabelClasses="required"
                  label="CONFIRMAR CONTRASEÑA"
                  placeholder="Confirmar contraseña"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  class="mb-4"
                  v-model="dataUser.confirmPassword"
                  :is-valid="hasError($v.dataUser.confirmPassword)"
                >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CRow >

                  <CCol md="6">
                    <CSelect
                    addLabelClasses="required"
                    label="ESTADO"
                    :value.sync="dataUser.value_stated"
                    invalid-feedback="Campo requerido"
                    :plain="true"
                    :options="stated"
                    @change="changeGetMunici()"
                  >
                  </CSelect>
                  </CCol>
                  <CCol md="6">
                    <CSelect
                    addLabelClasses="required"
                    label="MUNICIPIO"
                    :value.sync="dataUser.value_municipality"
                    invalid-feedback="Campo requerido"
                    :plain="true"
                    :options="municipality"
                  >
                  </CSelect>
                  </CCol>
                 
                </CRow>
                <CInput
                  addLabelClasses="required"
                  label="CALLE"
                  placeholder="calle"
                  type="text"
                  prependHtml="<i class='cui-lock-location'></i>"
                  v-model="$v.dataUser.street.$model"
                :is-valid="hasError($v.dataUser.street)"
                >
                  <template #prepend-content
                    ><CIcon name="cil-location-pin-check" /></template>
                </CInput>

                <CTextarea
                label="DIRECCIÓN"
                  addLabelClasses="required"
                  rows="5"
                  placeholder="Ingrese la dirección exacta"
                  v-model="$v.dataUser.adress.$model"
                  :is-valid="hasError($v.dataUser.adress)"
                />
             
                <CButton :disabled="isDisabled" type="submit" class="btn botonesCan text-white" block
                  >CREAR USUARIO</CButton
                >
              </CForm>
            </CCardBody>
            <!--
            <CCardFooter class="p-4">
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
            </CCardFooter> -->
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import General from "@/_mixins/general";
import UpperCase from "@/_validations/uppercase-directive";
import Registerval from "@/_validations/register/RegisterVal";
import axios from "axios";

function Sweet(title="",text="") {
  this.$swal
    .fire({
      title: "TRABAJAAAA",
      text: "ERES UN BICHITO PONTE A TRABAJAR MMG",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    })
    .then((result) => {
      if (result.isConfirmed) {
        Swal.fire("Deleted!", "Your file has been deleted.", "success");
      }
    });
}



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
      Loading: false,
      adress: "",
      type_document: "V",
      number_document: "",
      value_stated: "",
      value_municipality: "",
      number_document: "",
      street:""
    },
    stated: [],
    municipality: [],
    showAlerError:0,
    msgError: "",

      /*name: "",
      email: "",
      password: "",
      password_confirmation: "",
      Loading: false,*/
    };
  },
  mixins: [General],
  computed: {
    isDisabled,
  },
  directives: UpperCase,
  validations: Registerval,
  mounted: function() {
     this.getStateds()
  },
  methods: {
    Sweet,
    register() {
      var self = this;
      self.dataUser.Loading = true;
      axios
        .post(this.$apiAdress + "/api/register", {
          name: self.dataUser.name,
          email: self.dataUser.email,
          password: self.dataUser.password,
          password_confirmation: self.dataUser.confirmPassword,
          type_document: self.dataUser.type_document,
          number_document: self.dataUser.number_document,
          adress_all: self.dataUser.adress,
          stated: self.dataUser.value_stated,
          municipality: self.dataUser.value_municipality,
          street: self.dataUser.street,
          
        })
        .then(function(response) {
          self.dataUser.Loading = false;

          self.dataUser.name = "";
          self.dataUser.email = "";
          self.dataUser.password = "";
          self.dataUser.confirmPassword = "";
          self.dataUser.type_document = "V";
          self.dataUser.number_document = "";
          self.dataUser.adress = "";
          self.dataUser.street = "";
          console.log(response);
          self.$toastr.success("¡Usuario registrado con exito!");
          this.$v.$reset();
        })
        .catch(function(error) {
          if (error.response.status === 422) {
            console.log("Error 422 - Unprocessable Entity");
            console.log(error.response.data); // Aquí se muestra el error en formato JSON
            if (error.response.data.errors.name) {
              console.log("error name",error.response.data.errors.name);
            }
            if (error.response.data.errors.email) {
              console.log("error email",error.response.data.errors.email[0]);
              self.msgError = error.response.data.errors.email[0];
              self.showAlerError = 10;
              self.$toastr.error("¡Error! "+error.response.data.errors.email[0]);
            }

            if (error.response.data.errors.number_document) {
              console.log("error number_document",error.response.data.errors.number_document[0]);
              self.msgError = error.response.data.errors.number_document[0];
              self.showAlerError = 10;
              self.$toastr.error("¡Error! "+error.response.data.errors.number_document[0]);
            }
          } else {
            console.log("Error");
            console.log(error);
            // self.$toastr.danger("¡Error al agregar producto!");
          }
          self.dataUser.Loading = false;
        });
        this.$v.$reset();
    },
    async getStateds() {
      this.stated = await this.getStated();
    },
    async changeGetMunici(){
      console.log(this.dataUser.value_stated);
      this.municipality = await this.getMunicipality(this.dataUser.value_stated);
    }
   
  },
 
};
</script>

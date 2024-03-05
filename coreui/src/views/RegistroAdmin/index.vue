<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCard>
            <CCardHeader class="text-center botonesP text-white">
              <b>REGISTRO DE USUARIOS</b>
            </CCardHeader>
            <CCardBody class="p-4">
              <CForm @submit.prevent="register" method="POST">
                <CInput
                  placeholder="Usuario"
                  prependHtml="<i class='cui-user'></i>"
                  autocomplete="Usuario"
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
                  placeholder="Password"
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
                  placeholder="Repeat password"
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
                <CButton :disabled="isDisabled" type="submit" color="success" block
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
    },
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
  methods: {
    Sweet,
    register() {
      var self = this;
      self.Loading = true;
      axios
        .post(this.$apiAdress + "/api/register", {
          name: self.dataUser.name,
          email: self.dataUser.email,
          password: self.dataUser.password,
          password_confirmation: self.dataUser.confirmPassword,
        })
        .then(function(response) {
          self.dataUser.name = "";
          self.dataUser.email = "";
          self.dataUser.password = "";
          self.dataUser.confirmPassword = "";
          console.log(response);
          self.$toastr.success("¡Usuario registrado con exito!");
          self.dataUser.Loading = false;
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
              this.Sweet("Error",error.response.data.errors.email[0])
            }
            self.$toastr.danger("¡Error al agregar producto!");
          } else {
            console.log("Error");
            console.log(error);
            self.$toastr.danger("¡Error al agregar producto!");
          }
          self.dataUser.Loading = false;
        });
    },
  },
};
</script>

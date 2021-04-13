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
                  placeholder="Username"
                  prependHtml="<i class='cui-user'></i>"
                  autocomplete="username"
                  v-model="name"
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CInput
                  placeholder="Email"
                  prepend="@"
                  autocomplete="email"
                  v-model="email"
                />
                <CInput
                  placeholder="Password"
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
                  placeholder="Repeat password"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  class="mb-4"
                  v-model="password_confirmation"
                >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CButton type="submit" color="success" block
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
function Sweet() {
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

import axios from "axios";
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      Loading: false,
    };
  },
  methods: {
    Sweet,
    register() {
      var self = this;
      self.Loading = true;
      axios
        .post(this.$apiAdress + "/api/register", {
          name: self.name,
          email: self.email,
          password: self.password,
          password_confirmation: self.password_confirmation,
        })
        .then(function(response) {
          self.name = "";
          self.email = "";
          self.password = "";
          self.password_confirmation = "";
          console.log(response);
          self.$toastr.success("¡Usuario registrado con exito!");
          self.Loading = false;
        })
        .catch(function(error) {
          self.$toastr.danger("¡Error al agregar producto!");
          console.log(error);
          self.Loading = false;
        });
    },
  },
};
</script>

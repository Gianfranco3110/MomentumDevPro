<template>
  <section class="vh-100" style="background-color: #C38154;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-12">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="../../../public/login1.jpg"
                  alt="login form" class="img-fluid h-100 img-adapte" style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
  
                  <form @submit.prevent="login" method="POST">
  
                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3 cursor-pointer" style="color: #ff6219;"></i>
                      <span class="h1 fw-bold mb-0">Logo</span>
                    </div>
  
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Iniciar sesión en su cuenta</h5>
  
                    <div class="form-outline mb-3">
                      <label class="form-label" >Correo</label>
                      <input type="email" placeholder="Ingrese el correo electrónico"  v-model="email" :class="classInvaEmail" class="form-control form-control-lg"   />
                      <div class="invalid-feedback">
                        {{ msgErrorEmail }}
                      </div>
                    </div>
  
                    <div class="form-outline mb-4">
                      <label class="form-label">Contraseña</label>
                      <input type="password" placeholder="Ingrese su contraseña" v-model="password" :class="classInvaPass" class="form-control form-control-lg" />
                      <div class="invalid-feedback">
                        {{ msgErrorPassword }}
                      </div>
                    </div>
  
                    <div class="pt-1 mb-4">
                      <button  type="submit" @click.prevent="login" class="btn botonesP btn-lg btn-block text-white">Iniciar</button>
                    </div>
  
                    <!--<a class="small text-muted" href="#!">Has olvidado tu contraseña?</a>-->
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">No tienes una cuenta? <a href="#"
                        style="color: #393f81;" @click="goRegister()">Registrar aquí</a></p>
             
                  </form>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--<div class="img">
    <div class="overlay"></div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CContainer class="d-flex content-center min-vh-100">
      <CRow class="col-md-6">
        <CCol>
          <CCardGroup>
            <CCard class="p-4 rounded-1">
              <CCardBody>
                <CForm @submit.prevent="login" method="POST">
                  <h1>Iniciar sesión</h1>
                  <p class="text-muted">Entra en tu cuenta</p>
                  <CInput
                    v-model="email"
                    prependHtml="<i class='cui-user'></i>"
                    placeholder="Usuario"
                    autocomplete="Usuario email"
                  >
                    <template #prepend-content
                      ><CIcon name="cil-user"
                    /></template>
                  </CInput>
                  <CInput
                    v-model="password"
                    prependHtml="<i class='cui-lock-locked'></i>"
                    placeholder="Password"
                    type="password"
                    autocomplete="curent-password"
                  >
                    <template #prepend-content
                      ><CIcon name="cil-lock-locked"
                    /></template>
                  </CInput>
                  <CRow>
                    <CCol class="text-start" col="6">
                      <CButton
                        type="submit"
                        @click.prevent="login"
                        class="px-5 pt-2 pb-2 btn botonesP text-white ms-0"
                        >Entrar</CButton
                      >
                    </CCol>
                    <CCol col="6" class="text-right">
                      <CButton color="link" class="px-0"
                        >¡Olvidé mi contraseña!</CButton
                      >
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
    
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>-->
</template>

<script>
import axios from "axios";

export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
      Loading: false,
      classInvaEmail: "",
      classInvaPass: "",
      msgErrorEmail: "",
      msgErrorPassword:""
    };
  },
  methods: {
    goRegister() {
      this.$router.push({ path: "register" });
    },
    login() {
      let self = this;
      self.Loading = true;
      axios
        .post(this.$apiAdress + "/api/login", {
          email: self.email,
          password: self.password,
        })
        .then(function(response) {
          self.email = "";
          self.password = "";
          self.classInvaEmail = "";
          localStorage.setItem("api_token", response.data.access_token);
          localStorage.setItem("roles", response.data.roles);
          localStorage.setItem("email", response.data.email);
          localStorage.setItem("name", response.data.name);
          localStorage.setItem("id", response.data.id);
          console.log(response.data);
          self.Loading = false;
          self.$router.push({ path: "dashboard" });
        })
        .catch(function(error) {
          self.Loading = false;
          if (error.response) {
            if (error.response.status === 401) {
              console.error('Error 401: Unauthorized');
              console.error('Error:', error.response.data.messague);
              self.$toastr.error(`¡Error, ${error.response.data.messague}!`);
              self.classInvaEmail = "is-invalid";
              self.classInvaPass = "is-invalid";
              self.msgErrorEmail = "";
              self.msgErrorPassword = "";

            } else if (error.response.status === 422) {
              console.error('Error:', error.response.data);

              if ('email' in error.response.data.errors) {
                self.classInvaEmail = "is-invalid";
                self.msgErrorEmail = error.response.data.errors.email[0];
              }else{
                self.classInvaEmail = "is-valid";
              }


              if ('password' in error.response.data.errors) {
                self.classInvaPass = "is-invalid";
                self.msgErrorPassword = error.response.data.errors.password[0];
              }else{
                self.classInvaPass = "is-valid";
              }

              console.error('Error 419: Authentication Timeout');
            } else if (error.response.status === 500) {
              console.error('Error 500: Internal Server Error');
              self.$toastr.danger(`¡Error, ${error.response.data.messague}!`);
            } else {
              console.error('Error:', error.response.data);
            }
          } else {
            console.error('Error:', error.message);
          }
          
          
        });
    },
  },
};
</script>
<style scoped>
.img {
  background: url("../../../public/login2.jpg");
  margin: 0;
  padding: 0;
  height: 100vh;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  position: relative;
}
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Ajusta el valor 0.5 para la opacidad deseada */
}
</style>

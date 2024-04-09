<template>
    <div>
        <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
        <section class="vh-100" style="background-color: #202020;">
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
    
                      <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; color:black !important">Ingresa tu nueva contraseña</h5>
    
                      <div class="form-outline mb-3">
                        <label class="form-label" >Nueva Contraseña</label>
                        <input type="password" placeholder="Ingrese la contraseña"  v-model="password" :class="classInvaPass" class="form-control form-control-lg"   />
                        <div class="invalid-feedback">
                          {{  msgErrorPassword }}
                        </div>
                      </div>
    
                      <div class="form-outline mb-4">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" placeholder="Confirmar contraseña" v-model="confirpassword" :class="classInvaPasswConf" class="form-control form-control-lg" />
                        <div class="invalid-feedback">
                          {{ msgErrorPassConf  }}
                        </div>
                      </div>
    
                      <div class="pt-1 mb-4">
                        <button  type="submit" @click.prevent="login" class="btn botonesP btn-lg btn-block text-white">Cambiar Contraseña</button>
                      </div>
    

               
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

  </template>
  
  <script>
  import axios from "axios";
  import General from "@/_mixins/general";
  import UpperCase from "@/_validations/uppercase-directive";
  
  export default {
    name: "ResetPassword",
    mixins: [General],
    directives: UpperCase,
    data() {
      return {
        confirpassword: "",
        password: "",
        Loading: false,
        classInvaPasswConf: "",
        classInvaPass: "",
        msgErrorPassConf: "",
        msgErrorPassword:""
      };
    },
    methods: {
      goRegister() {
        this.$router.push({ path: "register" });
      },
      goHome() {
        this.$router.push({ path: "/" });
      },
      login() {
        let self = this;
        self.Loading = true;
        axios
          .post(this.$apiAdress + "/api/user/password/reset", {
            password_confirmation: self.confirpassword,
            password: self.password,
            user_id: this.$route.params.id,
            token: this.$route.params.token,
          })
          .then( async function(response) {

              if (response.data.return == true) {
                console.log(response.data);
                self.$toastr.success(`Éxelente, ${response.data.message}!`);

                self.msgErrorPassConf = "";
                self.msgErrorPassword = "";
                self.classInvaPasswConf = "";
                self.classInvaPass = "";
                self.$router.push({ path: "/login" });
                
            }else{
                self.$toastr.error(`¡Error, ${response.data.message}!`);
                setTimeout(self.goHome(), 6000);
            }
        
            self.Loading = false;
          })
          .catch(function(error) {
            self.Loading = false;
            if (error.response) {
              if (error.response.status === 401) {
                console.error('Error 401: Unauthorized');
                console.error('Error:', error.response.data.message);
                self.$toastr.error(`¡Error, ${error.response.data.message}!`);
                self.classInvaPasswConf = "is-invalid";
                self.classInvaPass = "is-invalid";
                self.msgErrorPassConf = "";
                self.msgErrorPassword = "";
              } else if (error.response.status === 404) {
                console.error('Error 404: Unauthorized');
                console.error('Error:', error.response.data.message);
                self.$toastr.error(`¡Error, ${error.response.data.message}!`);
                self.classInvaPasswConf = "";
                self.classInvaPass = "";
                self.msgErrorPassConf = "";
                self.msgErrorPassword = "";
             
              } else if (error.response.status === 422) {
                console.error('Error:', error.response.data);
  
                if ('password_confirmation' in error.response.data.errors) {
                  self.classInvaPasswConf = "is-invalid";
                  self.msgErrorPassConf = error.response.data.errors.password_confirmation[0];
                }else{
                  self.classInvaPasswConf = "is-valid";
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
                self.$toastr.danger(`¡Error, ${error.response.data.message}!`);
                setTimeout(self.goHome(), 6000);
              } else {
                console.error('Error:', error.response.data);
              }
            } else {
              console.error('Error:', error.message);
            }
            
            
          });
      },
      AssignCourse() {
        let self = this;
        self.Loading = true;
        const dataCourse = JSON.parse(localStorage.getItem("course"));
        axios
          .post(
            this.$apiAdress +
              "/api/usercourses/create?token=" +
              localStorage.getItem("api_token"),
            {
              course_id: dataCourse.id,
              user_id: localStorage.getItem("id"),
              status: 'No pagado',
            }
          )
          .then(function(response) {
            console.log(response.data);
            self.Loading = false;
            self.$router.push({ path: "mis-cursos" });
            // self.AddModal = false;
            self.$toastr.success("¡Curso asignado con exito!");
           
          })
          .catch(function(error) {
              // Capturar y manejar los errores
            if (error.response) {
              // Error de respuesta del servidor
              const errorDetails = {
                status: error.response.status,
                data: error.response.data,
              };
              console.log(errorDetails);
              
              // Manejar errores específicos
              if ([404, 422, 500].includes(error.response.status)) {
                // Manejar errores 404, 422, 500
                // console.log("Error " + error.response.status + ": " + error.response.data);
                self.$toastr.warning("¡"+error.response.data.message+"!");
              }
            } else if (error.request) {
              // Error de solicitud (sin respuesta del servidor)
              console.log("Error de solicitud:", error.request);
            } else {
              // Otros errores
              console.log("Error:", error.message);
            }
            self.Loading = false;
            
          });
      }
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
  
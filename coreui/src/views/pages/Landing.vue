<template>
  <CContainer>
    <CRow class="justify-content-center text-center mt-3">
      <div class="col-md-12">
        <div class="mb-3 text-end">
          <a
            target="_blank"
            href="https://api.whatsapp.com/send?text=*Hola*%0A*Visita mi página:* https://yariestilospmu.com/"
            class="text-end text-white flex-grow-1 m-0 d-flex align-items-center text-decoration-none"
          >
            <img
              src="../../../public/img/share.png"
              alt="share"
              class="img-share"
              width="30"
              height="30"
            />
          </a>
        </div>

        <div class="imagen-redondeada">
          <img src="perfil.jpg" alt="perfil-image" />
        </div>

        <div class="align-items-center justify-content-center">
          <h4 class="mt-3">Master Yaretzi Ocanto</h4>
          <div class="row align-items-center justify-content-center">
            <div class="col-md-6 mt-1">
              <img
                src="../../../public/img/location2.png"
                alt="ubicación"
                class="img-location"
                width="30"
                height="30"
              />
              <h4 class="d-inline mx-1 text-center">
                Barquisimeto | Venezuela
              </h4>
            </div>
            <router-link
              to="/curso-online"
              class="enlaces-div col-md-6 d-flex align-items-center text-decoration-none"
            >
              <img
                src="../../../public/img/online.png"
                alt="ubicación"
                class="img-online me-2"
                width="30"
                height="30"
              />
              <h2 class="text-center flex-grow-1">Cursos online</h2>
            </router-link>
            <div class="enlaces-div col-md-6 d-flex align-items-center">
              <a
                target="_blank"
                href="https://yariestilospmu.com/Archivo/MASTER-CLASS-PRESENCIAL.pdf"
                class="text-center text-white flex-grow-1 m-0 d-flex align-items-center text-decoration-none"
              >
                <img
                  src="../../../public/img/library.png"
                  alt="ubicación"
                  class="img-library me-2"
                  width="30"
                  height="30"
                />
                <h2 class="text-center flex-grow-1">Cursos Presenciales</h2>
              </a>
            </div>
            <div class="enlaces-div col-md-6 d-flex align-items-center">
              <a
                target="_blank"
                href="https://api.whatsapp.com/send?phone=584245124623&text=*Hola Yaritzy*%0A*Información:* Estoy interesada en solicitar una cita"
                class="text-center text-white flex-grow-1 m-0 d-flex align-items-center text-decoration-none"
              >
                <img
                  src="../../../public/img/whatsapp-50.png"
                  alt="whatsapp"
                  class="img-library me-2"
                  width="30"
                  height="30"
                />
                <h2 class="text-center flex-grow-1 m-0">Solicitud de cita</h2>
              </a>
            </div>
            <div class="enlaces-div col-md-6 d-flex align-items-center">
              <a
                target="_blank"
                href="https://www.tiktok.com/@yariestilospmu?_t=8ocluQkTDRF&_r=1"
                class="text-center text-white flex-grow-1 m-0 d-flex align-items-center text-decoration-none"
              >
                <img
                  src="../../../public/img/tik-tok.png"
                  alt="tiktok"
                  class="img-library me-2"
                  width="30"
                  height="30"
                />
                <h2 class="text-center flex-grow-1">Tik Tok</h2>
              </a>
            </div>
            <div class="col-md-6 mt-3">
              <img
                src="../../../public/logo_padre/logo padre color oro.png"
                alt="ubicación"
                class="img-logo"
                width="150"
                height="150"
              />
            </div>
          </div>
        </div>
      </div>
    </CRow>
  </CContainer>
</template>

<script>
export default {
  name: "Landing",
};
</script>
<style>
body {
  background-color: black;
}

.imagen-redondeada {
  width: 200px; /* Ajusta el tamaño según tus necesidades */
  height: 200px; /* Ajusta el tamaño según tus necesidades */
  overflow: hidden;
  border-radius: 50%; /* Esto hace que la imagen sea redondeada */
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto; /* Centra el div en su contenedor */
}

.imagen-redondeada img {
  width: 100%;
  height: auto;
}

.enlaces-div {
  background-color: #212529; /* Color de fondo */
  border-radius: 15px; /* Bordes redondeados */
  color: white !important; /* Color del texto */
  padding: 15px; /* Espaciado interno */
  text-align: center; /* Centrar el texto */
  margin: 10px; /* Margen alrededor del div */
}
h2 {
  font-size: 18px;
}
.img-location{
    margin-top: -5px;
}
</style>

<template>
  <CContainer>
    <CRow class="justify-content-center">
      <div class="landing-wrapper">

        <!-- Compartir -->
        <div class="mb-2 text-end">
          <a
            target="_blank"
            href="https://api.whatsapp.com/send?text=*Hola*%0A*Visita mi p%C3%A1gina:* https://yariestilospmu.com/"
            class="text-white d-inline-flex align-items-center text-decoration-none"
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

        <!-- Título -->
        <div class="text-center">
          <h1 class="mt-3">¡Llegaste al lugar correcto!</h1>
        </div>

        <!-- Foto de perfil -->
        <div class="imagen-redondeada">
          <img src="perfil-landing.png" alt="perfil-image" />
        </div>

        <!-- Cinta -->
        <div class="text-center cinta-customs">
          <img
            src="cinta.png"
            alt="cinta-title"
            class="cinta-title"
            width="380"
            height="100"
          />
        </div>

        <!-- Descripción -->
        <div class="customs-div-title mt-1 mb-3">
          <h4 class="d-inline mx-1 text-center letter-color-customs">
            Master especializada en microblading, micropigmentación y operador
            láser removal tatto
          </h4>
        </div>

        <!-- Video -->
        <div class="mb-3">
          <video
            autoplay="true"
            loop="true"
            muted="muted"
            playsinline="true"
            class="desing-video"
          >
            <source
              type="video/mp4"
              src="../../../public/Video-presentacion.mov"
            />
          </video>
        </div>

        <!-- Botones de acción -->
        <div class="img-background-button">
          <div @click="biografia()" class="enlaces-div d-flex align-items-center justify-content-center mb-3">
            <h2 class="text-center">CONOCE MAS DE MI</h2>
          </div>
          <div @click="toWhatsaap()" class="enlaces-div d-flex align-items-center justify-content-center mb-3">
            <h2 class="text-center">QUIERO UNA CITA</h2>
          </div>
          <div @click="infoCourse()" class="enlaces-div d-flex align-items-center justify-content-center mb-3">
            <h2 class="text-center">INFORMACIÓN DEL CURSO</h2>
          </div>
          <router-link
            to="/curso-online"
            class="mb-3 enlaces-div d-flex align-items-center justify-content-center text-decoration-none"
          >
            <h2 class="text-center">CURSO ONLINE</h2>
          </router-link>
          <div @click="productAviable()" class="mb-3 enlaces-div d-flex align-items-center justify-content-center">
            <h2 class="text-center">PRODUCTOS DISPONIBLES</h2>
          </div>
        </div>

        <!-- Logo inferior -->
        <div class="text-center mt-3 mb-3">
          <img
            src="../../../public/logo_padre/logo padre color negro.png"
            alt="ubicación"
            class="img-logo"
            width="150"
            height="150"
          />
        </div>

      </div>
    </CRow>
  </CContainer>
</template>
  </CContainer>
</template>

<script>
export default {
  name: "Landing",
  methods: {
    productAviable,
    infoCourse,
    biografia,
    toWhatsaap,
  },
};
function productAviable() {
  window.open(
    "https://yariestilospmu.com/Archivo/CATALOGOPREVENTA.pdf",
    "_blank"
  );
}

function infoCourse() {
  window.open("https://yariestilospmu.com/Archivo/Infocurso.pdf", "_blank");
}

function biografia() {
  window.open("https://yariestilospmu.com/Archivo/Biografia.pdf", "_blank");
}
function toWhatsaap() {
  window.open(
    "https://api.whatsapp.com/send?phone=584245124623&text=*Hola Yaritzy*%0A*Información:* Estoy interesada en solicitar una cita",
    "_blank"
  );
}
</script>
<style>
body {
  background-color: white;
}
h2 {
  font-weight: bold !important;
}
.imagen-redondeada {
  width: 300px;
  height: 300px;
  overflow: hidden;
  border-radius: 50%;
  border-width: 5px;
  border-color: #dcba0f !important;
  border-style: solid;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
}

.imagen-redondeada img {
  width: 100%;
  height: auto;
}

.enlaces-div {
  background-color: transparent; /* Color de fondo */
  border-radius: 15px; /* Bordes redondeados */
  color: #dcba0f !important; /* Color del texto */
  padding: 15px; /* Espaciado interno */
  text-align: center; /* Centrar el texto */
  margin: 10px; /* Margen alrededor del div */
  /* Borde */
  border: 2px solid #000000; /* Un borde gris claro, puedes ajustar el color */

  /* Sombra */
  box-shadow: 4px 2px 4px 4px black; /* Sombra negra a la derecha */

  /* Otros estilos que ya tienes */
  transition: box-shadow 0.3s ease, transform 0.2s ease; /* Opcional: transición suave para la sombra y transformación */
  padding: 10px; /* Opcional: añade un poco de espacio interior */
  /* Asegura que los elementos dentro del contenedor no salgan */
  overflow: hidden;

  /* Flexbox para apilar verticalmente */
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;

  height: 12vh !important;

  cursor: pointer; /* Cambia el cursor a una mano */
  user-select: none; /* Evita que se seleccione el texto */
  position: relative; /* Para las capas */
}

.enlaces-div:hover {
  box-shadow: 8px 8px 0px 1px #777777ad; /* Sombra mas pronunciada al hacer hover */
  transform: translateY(-2px); /* Ligeramente hacia arriba al hacer hover */
}
.enlaces-div:active {
  transform: translateY(2px); /* Ligeramente hacia abajo al hacer click */
  box-shadow: 4px 4px 0px 1px #ffd501ad; /* Sombra mas pequeña al hacer click */
}
.enlaces-div::before {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-color: rgba(
    255,
    255,
    255,
    0.1
  ); /* Color blanco con transparencia */
  border-radius: inherit; /* Usar el mismo radio que el padre*/
  opacity: 0;
  transition: opacity 0.3s ease;
}

.enlaces-div:hover::before {
  opacity: 1;
}
.enlaces-div h2 {
  text-align: center !important;
  margin: 0 !important;
  color: rgba(0, 0, 0, 0.74) !important;
}
.img-online {
  width: 30px; /* o el tamaño que necesites */
  height: 30px; /* o el tamaño que necesites */
}
h2 {
  font-size: 18px;
}
.img-location {
  margin-top: -8px;
}
.letter-color-customs {
  color: #dcba0f !important;
}
h3 {
  font-weight: bold;
}

span {
  color: black !important;
}
.mcb-section-video-maim .mcb-background-overlay {
  background-color: #00000080;
}
.section.has-video {
  position: relative;
  overflow: hidden;
}
.section.has-video .section_video {
  position: absolute;
  top: 0;
  left: 0;
  min-height: 100%;
  min-width: 100%;
  overflow: hidden;
  width: 100%;
  height: 60vh;
}
.section.has-video .section_video video {
  height: auto;
  width: 100%;
}

.section.has-video .section_wrapper {
  position: relative;
}
.desing-video {
  width: 100%;
  height: auto !important;
  max-height: 40vh;
  display: block;
}

.img-background-button {
  background-image: url("https://yariestilospmu.com/imgenes/IMG_5155.jpg");
  background-size: cover; /* Cover the entire div */
  background-position: center; /* Center the image in the div */
  background-repeat: no-repeat; /* Prevent the image from repeating */
  position: relative; /* Create a stacking context for the overlay */
}

.img-background-button::before {
  content: ""; /* Required for the pseudo-element */
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-color: rgba(
    255,
    255,
    255,
    0.5
  ); /* White color with 50% opacity, you can change the color and opacity as you want*/
}

.img-background-button > * {
  position: relative;
  z-index: 1; /* Ensure child elements are displayed above the overlay */
}
.customs-div-title {
  background-color: black; /* Gris claro */
  display: flex; /* Para centrar verticalmente */
  align-items: center; /* Centrar verticalmente */
  justify-content: center; /* Centrar horizontalmente */
  padding: 15px 0; /* Espaciado arriba y abajo */
  text-align: center; /* Centrar el texto horizontalmente (en caso de que el h4 no ocupe todo el ancho)*/
  box-sizing: border-box; /*Para que el padding no afecte el ancho*/
}
.customs-div-title > * {
  margin: 0 !important; /* Eliminar márgenes en el h4, por si acaso */
}
.customs-div-title h4 {
  padding: 8px;
}
.cinta-customs{
  text-align: center;
  margin-left: 0;
}
.landing-wrapper {
  width: 100%;
  max-width: 520px;
  margin: 0 auto;
  padding: 0 16px;
}
</style>

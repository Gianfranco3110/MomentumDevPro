<template>
  <!--Footer off the website-->
  <footer id="footer" class="text-white">
    <div class="container container-footer">
      <div class="row pt-5 pb-5">
        <div class="col-md-3">
          <div class="footer-seccion">
            <div class="footer-msj-div">
              <ul class="p-0 mb-0">
                <li>Expertos en</li>
                <li>Belleza Natural</li>
              </ul>

              <div class="social-links-footer">
                <ul class="pl-0">
                  <li>
                    <a
                      href="https://www.instagram.com/teboribrows/"
                      target="_blank"
                      ><img decoding="async" src="../../public/img/instagram.webp" alt="instagram"
                    /></a>
                  </li>
                  <li>
                    <a
                      href="https://www.facebook.com/TeboriBrows/"
                      target="_blank"
                      ><img decoding="async" src="../../public/img/facebook-2.webp" alt="facebook"
                    /></a>
                  </li>
                  <li>
                    <a
                      href="https://www.youtube.com/channel/UCgFGTGnisVwTTl98JTFH7-w"
                      target="_blank"
                      ><img decoding="async" src="../../public/img/youtube-1.webp" alt="youtube"
                    /></a>
                  </li>
                  <li>
                    <a
                      href="https://api.whatsapp.com/send?phone=+34622341648&amp;text=%C2%A1Hola!"
                      target="_blank"
                      ><img decoding="async" src="../../public/img/whatsapp-1.webp" alt="whatsapp"
                    /></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="footer-seccion">
            <div class="div-footer-h">
              <h4>Link</h4>
              <ul class="pl-0">
                <li class="list-group-item link-hover-footer pt-0">
                  <a href="#" class="text-white">INICIO</a>
                </li>
                <li class="list-group-item link-hover-footer pt-0">
                  <a href="#" class="text-white">INICIAR SESIÓN</a>
                </li>
                <li class="list-group-item link-hover-footer pt-0">
                  <a href="#" class="text-white">REGISTRATE</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="footer-seccion">
            <div class="div-footer-h">
              <h4>Horarios</h4>
              <ul class="pl-0">
                <li>LUN - VIE: 10AM - 20PM</li>
                <li>SÁBADOS: 11AM - 15PM</li>
                <li>DÓMINGOS: CERRADO</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="footer-seccion">
            <div class="div-footer-h">
              <h4>Información</h4>
              <ul class="info-iconos pl-0">
                <li>
                  <a
                    href="https://g.page/TeboriBrows?share"
                    class="text-white"
                    target="_blank"
                    >Calle del General Díaz Porlier, 57, 28006 Madrid</a
                  >
                </li>
                <li>
                  <a href="tel:+34622341648" target="_blank" class="text-white"
                    >(0412) 000 00 00</a
                  >
                </li>
                <li>
                  <a
                    href="mailto:clientes@teboribrows.com"
                    class="text-white"
                    target="_blank"
                    >clientes@teboribrows.com</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row footer-copyright-seccion">
      <div class="pt-4 m-auto mt-1 p-2">
        <div class="container">
          <p class="text-footer-botom">
            © 2021 YareStylo, Todos los derechos reservados.
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!--End Footer off the website-->
</template>

<script>
import image from "../../public/img/whatsapp-1.webp"
export default {
  name: "TheFooter",
};
</script>

<style scoped>
/* --------------------------footer--------------------------*/
.container-footer {
  max-width: 1338px !important;
}
.social-links-footer {
  margin-top: 33px;
}
.social-links-footer ul {
  margin-left: 0px;
  list-style: none;
}
.social-links-footer ul li {
  display: inline-block;
  margin-right: 7px;
}
.social-links-footer ul li a img {
  height: 38px;
}
.footer-msj-div {
  font-family: "Playfair Display", -apple-system, BlinkMacSystemFont, "Segoe UI",
    Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
  color: #f2e7df !important;
  font-size: 41px;
  line-height: 54px;
}
.link-hover-footer:hover {
  cursor: pointer;
}
ul {
  list-style: none outside;
}
.div-footer-h ul li {
  padding: 0px 5px !important;
  margin-bottom: 3px !important;
  border: 1px solid rgba(0, 0, 0, 0.04);
  font-weight: 500 !important;
  text-transform: uppercase !important;
  font-size: 15px !important;
  color: #f2e7df !important;
  letter-spacing: 1px !important;
}

ul.info-iconos li {
  padding-left: 45px !important;
  background-image: url("");
  background-position: top 0px left;
  background-repeat: no-repeat;
  background-size: 30px;
  margin-bottom: 11px !important;
  height: 51px;
}
ul.info-iconos li:first-child {
  background-image: url("") !important;
}
ul.info-iconos li:last-child {
  background-image: url("") !important;
}
.text-footer-botom {
  font-size: 20px;
  font-family: "Playfair Display", -apple-system, BlinkMacSystemFont, "Segoe UI",
    Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif !important;
}
.footer-copyright-seccion {
  background-color: #864a39;
  border-top: 1px solid #f9e0bb5e;
  padding-bottom: 15px;
}

#footer {
  background-color: #864a39;
}
/*--------------------------------------------------------------End Footer--------------------------------------------------------------*/
</style>

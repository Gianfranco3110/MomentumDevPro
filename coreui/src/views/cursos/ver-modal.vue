<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      :title="tituloModal"
      :closeOnBackdrop="false"
      color="dark"
      size="lg"
      :show.sync="VerModal"
    >
      <CCard class="text-left">
        <CCardHeader>
          <img
            :src="this.$apiAdress+'/api/courses/img/' + image"
            class="bd-placeholder-img card-img-top"
            width="150px"
            height="200px"
            aria-label="Placeholder: Image cap"
            role="img"
            style="object-fit: cover;"
          />
        </CCardHeader>
        <CCardBody class="botonesP">
          <div class="row">
            <CCol sm="3">
              <H4 class="text-white"> NOMBRE</H4>
              <p>{{ CourseName }}</p>
            </CCol>
            <CCol sm="3">
              <H4 class="text-white"> DESCRIPCION</H4>
              <p>{{ description }}</p>
            </CCol>
            <CCol sm="3">
              <H4 class="text-white"> DIAS VALIDO</H4>
              <p>{{ daysofvalidity }}</p>
            </CCol>
            <CCol sm="3">
              <H4 class="text-white"> PRECIO</H4>
              <p>{{ price }}</p>
            </CCol>
          </div>
        </CCardBody>
      </CCard>
      <template #footer>
        <CButton color="dark" @click="VerModal = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>
<script>
import axios from "axios";

//DATA
function data() {
  return {
    // VARIABLES
    VerModal: false,
    Loading: false,
    tituloModal: "",
    CourseName: "",
    daysofvalidity: "",
    price: "",
    description: "",
    image: "",
    imgdefaul: "img_default.webp"
  };
}

export default {
  name: "ver-modal",
  data,
  props: {
    modal: null,
  },
  watch: {
    modal: function() {
      if (this.modal) {
        this.VerModal = true;
        this.tituloModal = this.modal.CourseName;
        this.CourseName = this.modal.CourseName;
        this.daysofvalidity = this.modal.daysofvalidity;
        this.price = this.modal.price;
        this.description = this.modal.description;
        this.image = this.modal.image == null?this.imgdefaul:this.modal.image;
        this.$emit("cerrarModal");
        console.log(this.modal);
      }
    },
  },
};
</script>

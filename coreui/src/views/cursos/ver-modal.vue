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
            :src="'public/curso/' + image"
            class="bd-placeholder-img card-img-top"
            width="150px"
            height="200px"
            aria-label="Placeholder: Image cap"
            role="img"
          />
        </CCardHeader>
        <CCardBody>
          <h5>{{ CourseName }}</h5>
          <p>{{ description }}</p>
          <p>{{ daysofvalidity }}</p>
          <p>{{ price }}</p>
        </CCardBody>
      </CCard>
      <template #footer>
        <CButton color="dark" @click="VerModal = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; SALIR
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
        this.image = this.modal.image;
        this.$emit("cerrarModal");
        console.log(this.modal);
      }
    },
  },
};
</script>

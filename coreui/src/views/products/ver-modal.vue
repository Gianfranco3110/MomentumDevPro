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
            :src="this.$apiAdress+'/storage/products/'+image"
            class="bd-placeholder-img card-img-top"
            width="150px"
            height="200px"
            aria-label="Placeholder: Image cap"
            role="img"
          />
        </CCardHeader>
        <CCardBody>
          <CRow>
          <CCol sm="3" style="text-align:center">
            <h5>Nombre</h5>
            <p>{{ title }}</p>
          </CCol>
          <CCol sm="3" style="text-align:center">
            <h5>Descripción</h5>
            <p>{{ description }}</p>
          </CCol>
          <CCol sm="3" style="text-align:center">
            <h5>Tipo</h5>
            <p>{{ product_type }}</p>
          </CCol>
          <CCol sm="3" style="text-align:center">
            <h5>Precio</h5>
            <p>{{ price }}</p>
          </CCol>
          </CRow>
          
          
          
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

//DATA
function data() {
  return {
    // VARIABLES
    VerModal: false,
    Loading: false,
    tituloModal: "",
    title: "",
    description: "",
    product_type: "",
    price: 0,
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
        this.tituloModal= this.modal.title;
        this.title = this.modal.title;
        this.price = this.modal.price;
        this.product_type = this.modal.product_type;
        this.description = this.modal.description;
        this.image = this.modal.image;
        this.$emit("cerrarModal");
        console.log(this.modal);
      }
    },
  },
};
</script>

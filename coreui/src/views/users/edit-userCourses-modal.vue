<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      title="Cambiar Status"
      :closeOnBackdrop="false"
      color="dark"
      size="lg"
      :show.sync="AddModal"
    >
      <CCard no-header>
        <CCardBody>          
          <CSelect
            label="STATUS"
            :value.sync="VinculoData.status"
            :plain="true"
            :options="statuses"
          >
          </CSelect>     
        </CCardBody>
      </CCard>

      <template #footer>
        <CButton color="success" @click="changeStatus">
          <CIcon name="cil-check-circle" />&nbsp; Cambiar
        </CButton>
        <CButton color="dark" @click="AddModal = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>
<script>
import General from "@/_mixins/general";
import axios from "axios";

function data() {
  return {
    // VARIABLES
    AddModal: false,
    Loading: false,
    user_name: "",
    VinculoData: {
      id: 1,
      status: '',
    },
    courses: [],
    statuses: ['Pagado','No pagado'],
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
  },
  watch: {
    modal: function() {
      if (this.modal) {
        this.AddModal = true;
        if (this.modal != false) {
          this.VinculoData.id = this.modal.Vinculo;
          this.VinculoData.status = this.modal.status;    
        }
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    changeStatus() {
      let self = this;
      self.Loading = true;
      axios
        .post(
          this.$apiAdress +
            "/api/usercourses/"+self.VinculoData.id+"/changestatus?token=" +
            localStorage.getItem("api_token"),
          {
            _method: 'PUT',
            status : self.VinculoData.status
          }
        )
        .then(function(response) {
          self.Loading = false;
          self.AddModal = false;
          self.$emit("child-refresh", true);
          self.$toastr.success("¡Status cambiado con exito!");
        })
        .catch(function(error) {
          console.log(error);
          self.Loading = false;
          self.$toastr.warning("¡Error al cambiar status!");
        });
    },
  },
  computed: {},
  mounted: function() {    
           
  },
};
</script>
<style scoped></style>

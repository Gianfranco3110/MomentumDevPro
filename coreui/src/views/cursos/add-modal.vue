<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      :title="tituloModal"
      :closeOnBackdrop="false"
      color="dark"
      size="lg"
      :show.sync="AddModal"
    >
      <CRow class="mt-2">
        <CCol sm="12">
          <CTextarea
            addLabelClasses="required"
            v-uppercase
            rows="5"
            invalid-feedback="Campo requerido. {A..Z ,-.*-/#}"
            label="DESCRIPCION DEL CURSO"
            maxlength="256"
            v-model="$v.description.$model"
            :is-valid="hasError($v.description)"
          />
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            type="number"
            placeholder="0"
            invalid-feedback="Campo requerido {0,00}"
            label="PRECIO DEL CURSO"
            v-model="$v.price.$model"
            :is-valid="hasError($v.price)"
          />
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            type="number"
            placeholder="DIAS DE VIGENCIA"
            invalid-feedback="Campo requerido {0,00}"
            label="DIAS DE VIGENCIA"
            v-model="$v.daysofvalidity.$model"
            :is-valid="hasError($v.daysofvalidity)"
          />
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            type="file"
            accept="image/*"
            placeholder="DIAS DE VIGENCIA"
            invalid-feedback="Campo requerido"
            label="FOTO DE PORTADA DEL CURSO"
            v-model="$v.photo.$model"
            :is-valid="hasError($v.photo)"
          />
        </CCol>
        <CCol sm="12" v-if="actualizar">
          <CSelect
            addLabelClasses="required"
            label="Status"
            :value.sync="status_id"
            :plain="true"
            :options="statuses"
          >
          </CSelect>
        </CCol>
      </CRow>

      <template #footer>
        <CButton color="success" :disabled="isDisabled" @click="evaluaStatus">
          <CIcon name="cil-check-circle" />&nbsp; ACEPTAR
        </CButton>
        <CButton color="dark" @click="AddModal = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import UpperCase from "@/_validations/uppercase-directive";
import General from "@/_mixins/general";
import CursosVal from "@/_validations/cursos/CursosVal";
import axios from "axios";

//METODOS
function guardar() {
  let url = "/api/courses?token=";
  axios
    .post(
      this.$apiAdress +
        "/api/courses?token=" +
        localStorage.getItem("api_token"),
      {
        course: {
          description: this.description,
          price: this.price,
          daysofvalidity: this.daysofvalidity,
          photo: this.photo,
          status_id: 1,
        },
      }
    )
    .then(function(response) {
      this.limpiarDatos();
      console.log(response);
      console.log(course);
      this.message = "Successfully created course.";
      this.showAlert();
    })
    .catch(function(error) {
      if (error.response.data.message == "The given data was invalid.") {
        this.message = "";
        for (let key in error.response.data.errors) {
          if (error.response.data.errors.hasOwnProperty(key)) {
            this.message += error.response.data.errors[key][0] + "  ";
          }
        }
        this.showAlert();
      } else {
        console.log(error);
        //self.$router.push({ path: 'login' });
      }
    });
}

function limpiarDatos() {
  this.description = "";
  this.price = "";
  this.daysofvalidity = "";
  this.photo = "";
  status_id: null;
  this.$nextTick(() => {
    this.$v.$reset();
  });
}

function evaluaStatus() {
  if (this.Status === 0) {
    this.$swal
      .fire({
        text: `¿Esta seguro de realizar el cambio de status para el registro?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "CONFIRMAR",
        cancelButtonText: "CANCELAR",
      })
      .then((result) => {
        if (result.isConfirmed) {
          this.guardar();
        }
      });
  } else this.guardar();
}

//COMPUTED
function isDisabled() {
  return this.$v.$invalid;
}

//DATA
function data() {
  return {
    //MODELOS
    description: "",
    price: "",
    daysofvalidity: "",
    photo: "",
    status_id: 1,
    course: {},

    // VARIABLES
    AddModal: false,
    Loading: false,
    actualizar: false,
    tituloModal: "",
    message: "",
    dismissSecs: 7,
    dismissCountDown: 0,
    showDismissibleAlert: false,
    statuses: [],
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
  },
  directives: UpperCase,
  validations: CursosVal,
  watch: {
    modal: function() {
      if (this.modal) {
        this.limpiarDatos();
        this.AddModal = true;
        if (this.modal == true) {
          this.tituloModal = "NUEVO CURSO";
          this.actualizar = false;
        } else {
          this.actualizar = true;
        }
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    evaluaStatus,
    limpiarDatos,
    guardar,
  },
  computed: {
    isDisabled,
  },
  mounted: function() {
    let self = this;
    axios
      .get(
        this.$apiAdress +
          "/api/products/create?token=" +
          localStorage.getItem("api_token")
      )
      .then(function(response) {
        self.statuses = response.data;
      })
      .catch(function(error) {
        console.log(error);
        //self.$router.push({ path: 'login' });
      });
  },
};
</script>
<style scoped></style>

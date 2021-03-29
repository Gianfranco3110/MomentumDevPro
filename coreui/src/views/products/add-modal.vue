<template>
  <div>
    <!--<loading-overlay :active="Loading" :is-full-page="true" loader="bars" />-->
    <CModal
      :title="tituloModal"
      :closeOnBackdrop="false"
      color="dark"
      size="lg"
      :show.sync="AddModal"
    >
      <CCard no-header>
        <CCardBody>
          <h3>
            Create New Product
          </h3>
          <CAlert
            :show.sync="dismissCountDown"
            color="primary"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
          </CAlert>

            <CInput label="Title" type="text" placeholder="Title" v-model="product.title"></CInput>

            <CInput textarea="true" label="Description" :rows="9" placeholder="Description.." v-model="product.description"></CInput>

            <CSelect
              label="Status" 
              :value.sync="product.status_id"
              :plain="true"
              :options="statuses"
            >
            </CSelect>
            <CInput label="Product type" type="text" v-model="product.product_type"></CInput>            
            <input type="file" @change="getImage" name="image" id="image" accept="image/*" placeholder="Course picture"/>
            

         <!-- <CButton color="primary" @click.prevent="createProduct">Create</CButton>
          <CButton color="primary" @click="goBack">Back</CButton>-->
          
        </CCardBody>
      </CCard>

      <template #footer>
        <CButton color="success" @click="createUser">
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
import General from "@/_mixins/general";
import axios from "axios";

//METODOS
/*
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
*/
//DATA
function data() {
  return {      
    product: {
        title: "",
        description: "",
        status_id: 1,
        product_type: "",
        imagePath: "",
      },

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
    image: null,
  };
}
export default {
  name: 'add-modal',
  mixins: [General],
  data,
  props: {
    modal: null,
  },
  watch: {
    modal: function() {
      if (this.modal) {
        //this.limpiarDatos();
        this.AddModal = true;        
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    getImage(event) {
      //Asignamos la imagen a  nuestra data
      this.image = event.target.files[0];
      console.log(this.image);
    },
    uploadImage() {
      let self = this;
      let formData = new FormData();
      formData.append("image", self.image);
      axios
        .post(
          this.$apiAdress +
            "/api/products/image/store?token=" +
            localStorage.getItem("api_token"),
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        )
        .then(function(response) {
          self.product.imagePath = response.data.path;
          self.createUser();
        })
        .catch(function(error) {
          console.log(error);
          //self.$router.push({ path: '/login' });
        });
    },
    createUser() {
      let self = this;
      let formData = new FormData();
      formData.append("image", self.image);
      formData.append("title", self.product.title);
      formData.append("description", self.product.description);
      formData.append("status_id", self.product.status_id);
      formData.append("product_type", self.product.product_type);
      axios
        .post(
          this.$apiAdress +
            "/api/products?token=" +
            localStorage.getItem("api_token"),
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        )
        .then(function(response) {
          self.product = {
            title: "",
            description: "",
            status_id: null,
            product_type: "",
            imagePath: "",
          };
          self.message = "Successfully created product.";
          self.showAlert();
        })
        .catch(function(error) {
          if (error.response.data.message == "The given data was invalid.") {
            self.message = "";
            for (let key in error.response.data.errors) {
              if (error.response.data.errors.hasOwnProperty(key)) {
                self.message += error.response.data.errors[key][0] + "  ";
              }
            }
            self.showAlert();
          } else {
            console.log(error);
            //self.$router.push({ path: 'login' });
          }
        });
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
  },
  computed: {
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
  }
};
</script>
<style scoped></style>
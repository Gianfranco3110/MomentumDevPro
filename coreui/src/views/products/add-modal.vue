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
        <CCol sm="12" v-if="actualizar" style="text-align:center">            
            <img :src="'public/products/'+imageProducto" width="200" height="200" alt="product image">
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            label="TITULO DEL PRODUCTO"
            type="text"
            placeholder="Titulo"
            v-model="$v.product.title.$model"
            :is-valid="hasError($v.product.title)"
          />
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            textarea="true"
            label="DESCRIPCION DEL PRODUCTO"
            :rows="9"
            placeholder="Ingrese su descripción aqui.."
            v-model="product.description"
          />
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            label="PRECIO"
            type="number"
            min="1"
            step="any"
            placeholder="PRECIO"
            v-model="product.price"
          ></CInput>
        </CCol>
        <CCol sm="4">
          <CInput
            addLabelClasses="required"
            label="TIPO DE PRODUCTO"
            type="text"
            v-model="product.product_type"
            placeholder="Tipo de producto"
          />
        </CCol>
        <CCol sm="4">          
          <div class="custom-input-file mt-3">
            <input class="input-file" label="Imagen del producto" type="file" @change="getImage" name="imagen" id="image" accept="image/*" placeholder="product picture"/>
            Imagen del producto...
          </div>            
        </CCol>
        <CCol sm="4">
          <figure v-if="imagenMiniatura!=''">
                <img id="imagenMiniatura" :src="imagenM" width="200" height="200">
            </figure>
        </CCol>      
        
        
        <CCol sm="12" v-if="actualizar">
          <CSelect
            label="Status"
            :value.sync="product.status_id"
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
        <CButton color="dark" @click="modalClose">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import General from "@/_mixins/general";
import UpperCase from "@/_validations/uppercase-directive";
import axios from "axios";
import productosVal from "@/_validations/productos/productosVal";

//METODOS
//LIMPIA LOS CAMPOS
function limpiarDatos() {
  this.product = {
    title: "",
    description: "",
    status_id: 1,
    product_type: "",
    price: 0,
  };
  this.imagenMiniatura = "";
}
function guardar() {
  let self = this;
  self.Loading = true;
  if (self.actualizar) {
        let formData = new FormData();
        formData.append("image", self.imageNueva);
        formData.append("title", self.product.title);
        formData.append("description", self.product.description);
        formData.append("status_id", self.product.status_id);
        formData.append("product_type", self.product.product_type);
        formData.append("price", self.product.price);
        formData.append('_method', 'PUT');
        axios.post(  this.$apiAdress + '/api/products/' + self.product.id + '?token=' + localStorage.getItem("api_token")
        ,formData,{
                    headers: {
                              "Content-Type": "multipart/form-data",
                            },
          }
        ).then(function (response) {
            self.Loading = false;
            self.AddModal = false;
            self.$toastr.success("¡Producto actualizado!");
            self.$emit("child-refresh", true);
            self.limpiarDatos();
        }).catch(function (error) {
          self.Loading = false;
          self.$toastr.warning("¡Error! Por favor intente mas tarde");            
          console.log(error); 
          //self.$router.push({ path: '/login' });             
          });     
  }else{
    let formData = new FormData();
    formData.append("image", self.imageNueva);
    formData.append("title", self.product.title);
    formData.append("description", self.product.description);
    formData.append("product_type", self.product.product_type);
    formData.append("price", self.product.price);
    //ENVÍO DE DATOS
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
        self.limpiarDatos();
        self.Loading = false;
        self.AddModal = false;
        self.$toastr.success("¡Producto creado con exito!");
        self.$emit("child-refresh", true);
      })
      .catch(function(error) {
        console.log(error);
        self.Loading = false;
        self.$toastr.warning("Error al crear producto");
      });
  }
}

function evaluaStatus() {
  if (this.product.status_id === 2) {
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

function modalClose(){
  this.limpiarDatos();
  this.imagenMiniatura='';
  this.AddModal=false;  
}

//COMPUTED
function isDisabled() {
  return this.$v.$invalid;
}
//DATA
function data() {
  return {
    product: {
      title: "",
      description: "",
      status_id: 1,
      product_type: "",
      price: 0,
    },

    // VARIABLES
    AddModal: false,
    Loading: false,
    actualizar: false,
    tituloModal: "",
    statuses: [],
    imageNueva: null,
    imagenMiniatura: "",
    imageProducto: "",
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
    type: String,
    default: "User id",
    caption: {
      type: String,
      default: "product id",
    },
  },
  validations: productosVal,
  directives: UpperCase,
  watch: {
    modal: function() {
      if (this.modal) {
        this.limpiarDatos();
        this.AddModal = true;
        if (this.modal == true) {
          this.tituloModal = "NUEVO PRODUCTO";
          this.actualizar = false;
        } else {
          this.tituloModal = "EDITAR PRODUCTO";
          this.actualizar = true;
          this.product.id = this.modal.id;
          this.product.title = this.modal.title;
          this.product.price = this.modal.price;
          this.product.product_type = this.modal.product_type;
          this.product.description = this.modal.description;
          this.imageProducto = this.modal.image;
          console.log(this.modal);
        }
        this.$emit("cerrarModal");
      }
    },
  },
  methods: {
    evaluaStatus,
    guardar,
    limpiarDatos,
    modalClose,
    getImage(event) {
      //Asignamos la imagen a  nuestra data
      let file = event.target.files[0];
      this.imageNueva = file;
      this.cargarImagen(file);
    },
    cargarImagen(file) {
      let reader = new FileReader();
      reader.onload = (e) => {
        this.imagenMiniatura = e.target.result;
      };
      reader.readAsDataURL(file);
    },
  },
  computed: {
    isDisabled,
    imagenM() {
      return this.imagenMiniatura;
    },
  },
  mounted: function() {
    let self = this;
    self.Loading = true;
    axios
      .get(
        this.$apiAdress +
          "/api/products/create?token=" +
          localStorage.getItem("api_token")
      )
      .then(function(response) {
        self.statuses = response.data;
        self.Loading = false;
      })
      .catch(function(error) {
        console.log(error);
        //self.$router.push({ path: 'login' });
      });
  },
};
</script>
<style scoped>
.custom-input-file {
  background-color: #4B4BAF;
  color: #fff;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
  margin: 0 auto 0;
  min-height: 15px;
  overflow: hidden;
  padding: 10px;
  position: relative;
  text-align: center;
  width: 200px;
}

.custom-input-file .input-file {
 border: 10000px solid transparent;
 cursor: pointer;
 font-size: 10000px;
 margin: 0;
 opacity: 0;
 outline: 0 none;
 padding: 0;
 position: absolute;
 right: -1000px;
 top: -1000px;
}
</style>

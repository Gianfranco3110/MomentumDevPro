<template>
  <CRow>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CCol col="12" lg="6">
      <CCard>
        <CCardBody>
          <h3>
            Edit Product:  {{ product.title }}
          </h3>
          <img :src="'public/products/'+image" width="200" height="200" alt="product image">
            <CInput label="Title" type="text" placeholder="Title" v-model="product.title"/>
            <CInput
              label="Content"
              placeholder="Content.."
              
              textarea="true"
              rows="9"
              v-model="product.description"
            />
            <CInput label="Applies to date" type="date" v-model="product.applies_to_date"/>
            <CSelect 
              :value.sync="product.status_id"
              :options="statuses"
              label="Status"
            />
            <CInput label="Product type" type="text" v-model="product.product_type"/>
            <input type="file" @change="getImage" name="imagen" id="imagen" accept="image/*" placeholder="product picture"/>
            
            <figure class="mt-3">
                <img :src="imagenM" width="200" height="200" alt="Article Picture">
            </figure>
          <CButton color="primary" @click="update()">Save</CButton>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'EditProduct',
  props: {
    caption: {
      type: String,
      default: 'Product id'
    },
  },
  data: () => {
    return {
        product: {
          title: '',
          description: '',
          applies_to_date: '',
          status_id: null,
          product_type: '',        
        },
        statuses: [],
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
        image: '',
        imageNueva: null,
        imagenMiniatura: '',
        Loading: false,
    }
  },
  methods: {
    getImage(event) {
      //Asignamos la imagen a  nuestra data
      let file = event.target.files[0];
      this.imageNueva = file;
      this.cargarImagen(file);
    },
    cargarImagen(file){
      let reader = new FileReader();
      reader.onload = (e) =>{
        this.imagenMiniatura = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    update() {
        let self = this;
        self.Loading=true;
        let formData = new FormData();
        formData.append("image", self.imageNueva);
        formData.append("title", self.product.title);
        formData.append("description", self.product.description);
        formData.append("status_id", self.product.status_id);
        formData.append("product_type", self.product.product_type);
        formData.append('_method', 'PUT');
        axios.post(  this.$apiAdress + '/api/products/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token")
        ,formData,{
                    headers: {
                              "Content-Type": "multipart/form-data",
                            },
          }
        )
        .then(function (response) {
            self.Loading = false;
            self.$toastr.success("¡Product updated!");
        }).catch(function (error) {
          self.Loading = false;
          self.$toastr.warning("¡Error, please try later!");
            if(error.response.data.message == 'The given data was invalid.'){
              self.message = '';
              for (let key in error.response.data.errors) {
                if (error.response.data.errors.hasOwnProperty(key)) {
                  self.message += error.response.data.errors[key][0] + '  ';
                }
              }              
            }else{
              console.log(error); 
              //self.$router.push({ path: '/login' }); 
            }
        });
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
  },
  computed: {
    imagenM(){
      return this.imagenMiniatura;
    }
  },
  mounted: function(){
    let self = this;
    axios.get(  this.$apiAdress + '/api/products/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.product.title = response.data.product.title;
        self.product.description = response.data.product.description;
        self.product.applies_to_date = response.data.product.applies_to_date;
        self.product.status_id = response.data.product.status_id;
        self.image = response.data.product.image;
        self.product.product_type = response.data.product.product_type;
        self.statuses = response.data.statuses;
    }).catch(function (error) {
        console.log(error);
        //self.$router.push({ path: '/login' });
    });
  }
}

/*
      items: (id) => {
        const user = usersData.find( user => user.id.toString() === id)
        const userDetails = user ? Object.entries(user) : [['id', 'Not found']]
        return userDetails.map(([key, value]) => {return {key: key, value: value}})
      },
*/

</script>

<template>
  <CRow>
    <CCol col="12" lg="6">
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
            <figure class="mt-2">
              <img width="200" height="200" :src="imagen" alt="Foto del articulo">
            </figure>

          <CButton color="primary" @click.prevent="createProduct">Create</CButton>
          <CButton color="primary" @click="goBack">Back</CButton>
          
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'

export default {  
  name: 'CreateProduct',
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  data: () => {
    return {
        product: {
          title: '',
          description: '',
          status_id: 1,
          product_type: ''
        },
        statuses: [],
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
        showDismissibleAlert: false,
        image: null,
        imagenMiniatura : '',
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    getImage(event){
                //Asignamos la imagen a  nuestra data
                let file = event.target.files[0];
                this.image = file;                
                this.loadImage(file);
            },
    loadImage(file){
      let reader = new FileReader();
      reader.onload = (e) =>{
        this.imagenMiniatura = e.target.result;
      }
      reader.readAsDataURL(file);
    },
    createProduct(){
        let self = this;
        let formData = new FormData();
        formData.append('image', self.image);
        formData.append('title', self.product.title);
        formData.append('description', self.product.description);
        formData.append('status_id', self.product.status_id);
        formData.append('product_type', self.product.product_type);
        axios.post(   this.$apiAdress + '/api/products?token=' + localStorage.getItem("api_token"),
            formData,
            { headers: {
                'Content-Type': 'multipart/form-data'
            }}
        ).then(function(response){
             self.product = {
              title: '',
              description: '',
              status_id: 1,
              product_type: ''
            };
            self.message = 'Successfully created product.';
            self.showAlert();    
            self.$router.push({ path: '/dashboard' });
        })
        .catch(function(error){
          console.log(error.response.data);
            if(error.response.data.message == 'The given data was invalid.'){
              self.message = '';
              for (let key in error.response.data.errors) {
                if (error.response.data.errors.hasOwnProperty(key)) {
                  self.message += error.response.data.errors[key][0] + '  ';
                }
              }
              self.showAlert();
            }else{
              console.log(error);
              //self.$router.push({ path: 'login' }); 
            }
        });
    },
    /*original createProduct () {
        let self = this;               
        axios.post(  this.$apiAdress + '/api/products?token=' + localStorage.getItem("api_token"),
          self.product)
        .then(function (response) {
            self.product = {
              title: '',
              description: '',
              status_id: 1,
              product_type: '',
              imagePath:'',
            };
            self.message = 'Successfully created product.';
            self.showAlert();            
            //self.$router.push({ path: '/dashboard' }); 
        }).catch(function (error) {
            if(error.response.data.message == 'The given data was invalid.'){
              self.message = '';
              for (let key in error.response.data.errors) {
                if (error.response.data.errors.hasOwnProperty(key)) {
                  self.message += error.response.data.errors[key][0] + '  ';
                }
              }
              self.showAlert();
            }else{
              console.log(error);
              //self.$router.push({ path: 'login' }); 
            }
        });
    },*/
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs;
    },
  },
  computed:{
    imagen(){
      return this.imagenMiniatura;
    }
  },
  mounted: function(){
    let self = this;
    axios.get(  this.$apiAdress + '/api/products/create?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.statuses = response.data;
    }).catch(function (error) {
        console.log(error);
        //self.$router.push({ path: 'login' });
    });
  }
}

</script>

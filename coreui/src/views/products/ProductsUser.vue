<template>
  <CRow>
    <CCol col="12" xl="12">
      <transition name="slide">       
    
      <CCard>
        <AgreModal :modal="AddModal" @cerrarModal="AddModal = false" />
        <CCardHeader>
          My courses
          <CButton v-bind:style="{ background: '#142850',color: '#ebedef', float:'right'}" @click="AddModal = true" class="mb-3">
            <CIcon :content="$options.freeSet.cilPlus"/> Create Product</CButton>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
        </CCardHeader>
        <CCardBody>
          <CRow>
            <template>
            <CCol md="4" v-for="(item, index) in items" :key="index">
                <div class="card" style="width: 18rem;">
                  <img :src="'public/' + item.image" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: Image cap" role="img">

                  <div class="card-body">
                    <h5 class="card-title">{{item.title}} <CBadge :color="item.status_class">{{item.status}}</CBadge></h5>
                    <p class="card-text">{{item.description}}</p>
                     <CButton @click="collapse = !collapse" color="primary">
                      Nivel 2
                    </CButton>
                    <CCollapse :show="collapse" class="mt-2">
                      <CCard body-wrapper>
                        <CCardText>Description</CCardText>         
                        
                      </CCard>
                    </CCollapse>
                    <CRow class="mt-2">
                      <CCol>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                      </CCol>
                    </CRow>
                  </div>
                </div>
            </CCol>
            </template>                  
          </CRow>
            <CDataTable
              hover
              :items="items"
              :fields="fields"
              :items-per-page="5"
              pagination
            >              
              <template #title="{item}">
                <td>
                  <strong>{{item.title}}</strong>
                </td>
              </template>
              <template #description="{item}">
                <td>
                  {{item.description}}
                </td>  
              </template>
              <template #image="{item}">
                <td>
                  <strong>{{item.image}}</strong>
                </td>
              </template>
              <template #applies_to_date="{item}">
                <td>
                  {{item.applies_to_date}}
                </td>
              </template>
              <template #status="{item}">
                <td>
                  <CBadge :color="item.status_class">{{item.status}}</CBadge>
                </td>
              </template>
              <template #product_type="{item}">
                <td>
                  <strong>{{item.product_type}}</strong>
                </td>
              </template>
              <template #show="{item}">
                <td>
                  <CButton v-bind:style="{background:'#00909e',color:'#ebedef'}" @click="showProduct( item.id )">Show</CButton>
                </td>
              </template>
              <template #edit="{item}">
                <td>
                  <CButton v-bind:style="{background:'#dae1e7',color:'#000000'}" @click="editProduct( item.id )">Edit</CButton>
                </td>
              </template>
              <template #delete="{item}">
                <td>
                  <CButton v-if="you!=item.id" v-bind:style="{background:'#E01A1A',color:'#ebedef'}" @click="deleteProduct( item.id )">Delete</CButton>
                </td>
              </template>
            </CDataTable>
        </CCardBody>  
      </CCard>
      </transition>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
import { freeSet } from '@coreui/icons'
import General from '@/_mixins/general'
import AgreModal from './add-modal'

export default {
  name: 'ProductsUser',
  mixins: [General],
  freeSet,
  components: {    
    General,
    AgreModal
  },
  props:{},
  data: () => {
    return {
      collapse: false,
      cardCollapse: true,
      innerCollapse: false,
      items: [],      
      fields: ['title', 'description', 'image', 'applies_to_date', 'status', 'product_type', 'show', 'edit', 'delete'],
      currentPage: 1,
      perPage: 5,
      totalRows: 0,
      you: null,
      message: '',
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      AddModal: false

    }
  },
  computed: {    
  },
  methods: {
    getRowCount (items) {
      return items.length
    },
    productLink (id) {
      return `products/${id.toString()}`
    },
    editLink (id) {
      return `products/${id.toString()}/edit`
    },
    showProduct ( id ) {
      const productLink = this.productLink( id );
      this.$router.push({path: productLink});
    },
    editProduct ( id ) {
      const editLink = this.editLink( id );
      this.$router.push({path: editLink});
    },
    deleteProduct ( id ) {
      let self = this;
      axios.post(  this.$apiAdress + '/api/products/eliminate/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'PUT'
      })
      .then(function (response) {
          self.message = 'Successfully deleted product.';
          console.log('Producto eliminado');
          self.showAlert();
          self.getProducts();
      }).catch(function (error) {
        console.log(error);
        //self.$router.push({ path: '/login' });
      });
    },
    createProduct () {
      this.$router.push({path: 'products/create'});
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    getProducts (){
      let self = this;
      axios.get(  this.$apiAdress + '/api/products/myproducts?token=' + localStorage.getItem("api_token") )
      .then(function (response) {
        self.items = response.data;
        //this.getImage();
      }).catch(function (error) {
        console.log(error);
        //self.$router.push({ path: '/login' });
      });
    }
  },
  watch:{}, 
  mounted: function(){
    this.getProducts();
  }
}
</script>

<style scoped>
.card-body >>> table > tbody > tr > td {
  cursor: pointer;
}
</style>
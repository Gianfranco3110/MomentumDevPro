<template>
  <CRow>
    <CCol col="12" xl="12">
      <transition name="slide">
      <CCard>
        <CCardHeader>
          Products of 
          <CButton v-bind:style="{ background: '#142850',color: '#ebedef', float:'right'}" @click="createNote()" class="mb-3">
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
            <CDataTable
              hover
              :items="items"
              :fields="fields"
              :items-per-page="5"
              pagination
            >
              <template #author="{item}">
                <td>
                  <strong>{{item.author}}</strong>
                </td>
              </template>
              <template #title="{item}">
                <td>
                  <strong>{{item.title}}</strong>
                </td>
              </template>
              <template #content="{item}">
                <td>
                  {{item.content}}
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
              <template #note_type="{item}">
                <td>
                  <strong>{{item.note_type}}</strong>
                </td>
              </template>
              <template #show="{item}">
                <td>
                  <CButton v-bind:style="{background:'#00909e',color:'#ebedef'}" @click="showNote( item.id )">Show</CButton>
                </td>
              </template>
              <template #edit="{item}">
                <td>
                  <CButton v-bind:style="{background:'#dae1e7',color:'#000000'}" @click="editNote( item.id )">Edit</CButton>
                </td>
              </template>
              <template #delete="{item}">
                <td>
                  <CButton v-if="you!=item.id" v-bind:style="{background:'#E01A1A',color:'#ebedef'}" @click="deleteNote( item.id )">Delete</CButton>
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

export default {
  name: 'Products',
  freeSet,
  data: () => {
    return {
      items: [],      
      fields: ['author', 'title', 'content', 'applies_to_date', 'status', 'note_type', 'show', 'edit', 'delete'],
      currentPage: 1,
      perPage: 5,
      totalRows: 0,
      you: null,
      message: '',
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    }
  },
  computed: {
  },
  methods: {
    getRowCount (items) {
      return items.length
    },
    ProductLink (id) {
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
      let noteId = id;
      axios.post(  this.$apiAdress + '/api/notes/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'DELETE'
      })
      .then(function (response) {
          self.message = 'Successfully deleted note.';
          self.showAlert();
          self.getNotes();
      }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
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
      axios.get(  this.$apiAdress + '/api/products?token=' + localStorage.getItem("api_token") )
      .then(function (response) {
        self.items = response.data;
      }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
      });
    }
  },
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

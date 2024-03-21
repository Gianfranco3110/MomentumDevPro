<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <template slot="header">
              Edit User id:  {{ $route.params.id }}
            </template>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
            <CInput type="text" label="NOMBRE" placeholder="Name" disabled v-model="name"></CInput>
            <CInput type="text" label="CORREO" placeholder="Email" disabled v-model="email"></CInput>
            <CTextarea
            label="DIRECCIÓN"
                rows="5"
                placeholder="Ingrese la dirección exacta"
                v-model="adress"
                :is-valid="1"
              />
              <label for="uid-zfsk71rhl4d" class=""> DOCUMENTO DE IDENTIDAD </label>
              <CRow >
                  <CCol md="2">
                    <!--<CSelect
                      :options="[{'V':'V'},{'E':'E'},]"
                      v-model="$v.dataUser.type_document.$model"
                      :is-valid="hasError($v.dataUser.type_document)"
                    />-->
                    <select v-model="type_document" class="form-select form-control" aria-label="Default select example">
                      <option value="V" selected>V</option>
                      <option value="E">E</option>
                    </select>
                  </CCol>
                  <CCol md="10">
                    <CInput
                        placeholder="Numero de documento"
                        autocomplete="Numero de documento"
                        v-model="number_document"
                      :is-valid="1"
                      >
                    </CInput>
                  </CCol>
                </CRow>
            <CButton class="px-5 pt-2 pb-2 btn botonesP text-white mr-3" @click="update()">Guardar</CButton>
            <CButton class="px-5 pt-2 pb-2 btn botonesCan text-white " @click="goBack">Cancelar</CButton>
          </CForm>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'

export default {
  name: 'EditUser',
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  data: () => {
    return {
        name: '',
        email: '',
        adress: "",
        type_document: "V",
        number_document: "",
        showMessage: false,
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
        showDismissibleAlert: false
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    update() {
        let self = this;
        axios.post(  this.$apiAdress + '/api/users/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
        {
            _method: 'PUT',
            name: self.name,
            email: self.email,
            adress: self.adress,
            type_document: self.type_document,
            number_document: self.number_document,
        })
        .then(function (response) {
            self.message = response.data.messague;
            self.showAlert();
        }).catch(function (error) {
            console.log(error);
            self.$router.push({ path: '/login' });
        });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
  },
  mounted: function(){
    let self = this;
    axios.get(  this.$apiAdress + '/api/users/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.name = response.data.name;
        self.email = response.data.email;
        self.adress = response.data.adress_all;
        self.type_document = response.data.type_document;
        self.number_document = response.data.number_document;
    }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
    });
  }
}


</script>

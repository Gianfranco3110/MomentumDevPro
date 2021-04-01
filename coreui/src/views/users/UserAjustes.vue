<template>
    <div class="d-flex align-items-center min-vh-100">
        <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CContainer fluid>
        <transition name="slide">  
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCard class="mx-4 mb-0">
            <CCardBody class="p-4">
              <CForm>
                <h2 class="mb-4">Change Password</h2>               
                <CInput placeholder="Old Password" type="password" prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="old-password" v-model="oldpassword" >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CInput placeholder="New Password" type="password" prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password" v-model="newpassword" >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CInput placeholder="Repeat password" type="password" prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password" class="mb-4" v-model="password_confirmation"
                >
                  <template #prepend-content
                    ><CIcon name="cil-lock-locked"
                  /></template>
                </CInput>
                <CButton type="submit" color="success" block
                  >Change</CButton
                >
              </CForm>
            </CCardBody>            
          </CCard>
        </CCol>
      </CRow>
        </transition>
    </CContainer>
  </div>
</template>
<script>
import axios from 'axios'
import General from '@/_mixins/general'

export default {
  name: "UserAjustes",
  mixins: [General],
  components: {    
    General
  },
  data() {
    return {
      oldpassword: '',
      newpassword: '',
      password_confirmation: '',
      Loading: false,
    };
  },
  methods: {     
    
  },
  mounted: function(){
    
  }
};
</script>
<style scoped>

</style>
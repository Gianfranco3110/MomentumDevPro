<template>
  <div id="cursos-usuario">
      <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <h1>Cursos del usuario</h1>
    <hr>    
        <CRow> <!--
            <CCol md="4" v-for="(item, index) in items" :key="index">
                  <div class="card" style="width: 18rem;">
                    <img
                      :src="$apiAdress +'/storage/courses/'+ item.image"
                      class="bd-placeholder-img card-img-top"
                      width="100%"
                      height="180"
                      aria-label="Placeholder: Image cap"
                      role="img"
                    />

                    <div class="card-body">
                      <h5 class="card-title">{{ item.CourseName }}</h5>
                      <CRow class="mt-2">
                        <CCol style="text-align:Center">
                            <a href="#" class="btn btn-success">Ver curso</a>
                        </CCol>
                      </CRow>
                    </div>
                  </div>
                </CCol>  
                -->  
             <CCol md="12" v-for="(item, index) in items" :key="index">
                  <div class="card">
                    <div class="card-body">
                        <CRow>
                            <CCol md="2">
                                <img
                                    :src="$apiAdress +'/storage/courses/'+ item.image"
                                    class="bd-placeholder-img card-img-top"
                                    width="80"
                                    height="80"
                                    aria-label="Placeholder: Image cap"
                                    role="img"
                                    />
                            </CCol>
                            <CCol md="2">
                                {{ item.CourseName }}
                            </CCol>
                            <CCol md="2">
                                {{ item.Video }}
                            </CCol>
                            <CCol md="2">
                                <CButton  color="info">Cambiar status
                                </CButton>
                            </CCol>
                            <CCol md="2">
                                <CButton  color="success">Imprimir certificado
                                </CButton>
                            </CCol>
                            <CCol md="2">
                                <CButton  color="danger">Eliminar
                                </CButton>
                            </CCol>                           
                            
                        </CRow>
                    </div>
                  </div>
             </CCol>                 
        </CRow>
   </div>
</template>
<script>
import axios from "axios";
import General from "@/_mixins/general";
export default {
    name: 'UserCourses',
    mixins: [General],
    data: () =>{
        return{
            Loading: false,
            items: [],
        }
    }, 
    methods: {

    },
    mounted: function(){        
  let self = this;
  self.Loading = true;
  axios
    .get(
      this.$apiAdress +
        "/api/usercourses/"+self.$route.params.id+"?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      self.items = response.data;
      console.log(response.data);
      self.Loading = false;
    })
    .catch(function(error) {
      console.log(error);
      //self.$router.push({ path: "/login" });
    });
    }
};
</script>
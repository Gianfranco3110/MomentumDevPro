<template>
  <div id="mis-productos">
      <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <h1>Mis Cursos</h1>
    <hr>
    <!--<CRow>
            <CCol md="4" v-for="(item, index) in items" :key="index">
                <div class="card" style="width: 18rem;">
                  <img :src="'public/products/' + item.price" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: price cap" role="img">

                  <div class="card-body">
                    <h5 class="card-title">{{item.title}} <CBadge :color="item.status_class">{{item.status}}</CBadge></h5>
                    <p class="card-text">{{item.description}}</p>                     
                    <CRow class="mt-2">
                      <CCol>
                    <a href="#" class="btn btn-success">Details</a>
                      </CCol>
                    </CRow>
                  </div>
                </div>
            </CCol>                 
          </CRow>-->
        <CRow>
            <CCol md="4">
                <div class="card" style="width: 18rem;">
                  <img src="public/curso/1618360436maquillaj.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: price cap" role="img">

                  <div class="card-body">
                    <h5 class="card-title">Titulo</h5>                    
                    <CRow class="mt-2">
                      <CCol style="text-align:Center">
                    <a href="#" class="btn btn-success">Ver curso</a>
                      </CCol>
                    </CRow>
                  </div>
                </div>
            </CCol>   
            <CCol md="4">
                <div class="card" style="width: 18rem;">
                  <img src="public/curso/1618360436maquillaj.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: price cap" role="img">

                  <div class="card-body">
                    <h5 class="card-title">Titulo</h5>                    
                    <CRow class="mt-2">
                      <CCol style="text-align:Center">
                    <a href="#" class="btn btn-success">Ver curso</a>
                      </CCol>
                    </CRow>
                  </div>
                </div>
            </CCol> 
            <CCol md="4">
                <div class="card" style="width: 18rem;">
                  <img src="public/curso/1618360436maquillaj.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: price cap" role="img">

                  <div class="card-body">
                    <h5 class="card-title">Titulo</h5>                    
                    <CRow class="mt-2">
                      <CCol style="text-align:Center">
                    <a href="#" class="btn btn-success">Ver curso</a>
                      </CCol>
                    </CRow>
                  </div>
                </div>
            </CCol> 
            <CCol md="4">
                <div class="card" style="width: 18rem;">
                  <img src="public/curso/1618360436maquillaj.jpg" class="bd-placeholder-img card-img-top" width="100%" height="180" aria-label="Placeholder: price cap" role="img">

                  <div class="card-body">
                    <h5 class="card-title">Titulo</h5>                    
                    <CRow class="mt-2">
                      <CCol style="text-align:Center">
                    <a href="#" class="btn btn-success">Ver curso</a>
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
    name: 'MisCursos',
    mixins: [General],
    data: () =>{
        return{
            Loading: false,
        }
    }, 
    methods: {

    },
    mounted: function(){
        
  let self = this;
  self.Loading = true;
  //let listado = [];
  //self.items = [];
  axios
    .get(
      this.$apiAdress +
        "/api/courses/all?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      self.Loading = false;
    })
    .catch(function(error) {
      console.log(error);
      //self.$router.push({ path: "/login" });
    });
    }
};
</script>
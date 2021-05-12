<template>
  <div id="mis-cursos">
      <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <h1>Mis Cursos</h1>
    <hr>
    <!--<CRow>
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
          </CRow>-->
        <CRow> 
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
        "/api/courses/mycourses?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      self.items = response.data;
      self.Loading = false;
    })
    .catch(function(error) {
      console.log(error);
      self.$router.push({ path: "/login" });
    });
    }
};
</script>
<template>
  <div>
    <!--
    <CCardGroup class="mb-4">
      <CRow lg="12" style="width:100%">
        <CCol sm="6" lg="3">
          <CWidgetProgressIcon
            header="87.500"
            text="Visitors"
            color="info"
            inverse
          >
            <CIcon name="cil-people" height="36" />
          </CWidgetProgressIcon>
        </CCol>
        <CCol sm="6" lg="3">
          <CWidgetProgressIcon
            header="385"
            text="New Clients"
            color="success"
            inverse
          >
            <CIcon name="cil-userFollow" height="36" />
          </CWidgetProgressIcon>
        </CCol>
        <CCol sm="6" lg="3">
          <CWidgetProgressIcon
            header="1238"
            text="Products sold"
            color="warning"
            inverse
          >
            <CIcon name="cil-basket" height="36" />
          </CWidgetProgressIcon>
        </CCol>
        <CCol sm="6" lg="3">
          <CWidgetProgressIcon
            header="28%"
            text="Returning Visitors"
            color="primary"
            inverse
          >
            <CIcon name="cil-chartPie" height="36" />
          </CWidgetProgressIcon>
        </CCol>
      </CRow>
    </CCardGroup>
-->

    <div>
      <CRow class="w-100">
        <CCol sm="6">
            <iframe class="w-100"
          height="415"
          src="https://www.youtube.com/embed/xo9ZPZRPEB8"
          title="YouTube video player"
          frameborder="10"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        ></iframe>
        <br />
        <br />
          <Ccol sm="3">
            <CButton color="success">
              <CIcon name="cil-check-circle" />&nbsp; Leccion anterior
            </CButton>
          </Ccol>
          <Ccol sm="3">
            <CButton id="next" color="dark">
              <CIcon name="cil-chevron-circle-left-alt" />&nbsp; Leccion siguiente
            </CButton>
          </Ccol>
        </CCol>

        <CCol sm="6">
          <div class="card ">
            <div class="card-header h4 text-center mb-0">
              Curso de java de lo basico a profesional
            </div>
            <div class="card-body pt-0 pb-0">

              <ol class="list-group list-group-numbered">
                <li class="b-b-ligth px-0 list-group-item ">
                  <div   @click="collapse = !collapse"  class="w-100 d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                      <div class="fw-bold text-bold">1- Introducción a java</div>
                      <p class="text-w-300 ">Aqui podras aprender que es java y como lo utilizaremos</p> 
                    </div>
                    <span class="badge bg-primary rounded-pill text-white">3</span>
                  </div>
                  <CCollapse :show="collapse">
                      <CListGroup>
                        <CListGroupItem href="#">
                           Capitullo Nº1 de java
                        </CListGroupItem>
                        
                      </CListGroup>
                  </CCollapse>
                </li>
                <!--<li class="b-b-ligth list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold">Subheading</div>
                    Content for list item
                  </div>
                  <span class="badge bg-primary rounded-pill">14</span>
                </li>
                <li class="b-b-ligth list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold">Subheading</div>
                    Content for list item
                  </div>
                  <span class="badge bg-primary rounded-pill">14</span>
                </li>-->
              </ol>
            </div>
            <div class="card-footer text-body-secondary">
              2 days ago
            </div>
          </div>
        </CCol>
      </CRow>
    </div>
  </div>
  
</template>

<script>
import axios from "axios";
export default {
  name: "Dashboard",
  data() {
    return {
      isAdmin: false,
      collapse: false,
      innerCollapse: false
    };
  },
  methods: {
    color(value) {
      let $color;
      if (value <= 25) {
        $color = "info";
      } else if (value > 25 && value <= 50) {
        $color = "success";
      } else if (value > 50 && value <= 75) {
        $color = "warning";
      } else if (value > 75 && value <= 100) {
        $color = "danger";
      }
      return $color;
    },
  },

  mounted: function() {
    if (localStorage.getItem("roles") == "user,admin") {
      this.isAdmin = true;
    }
    /*
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
      */
  },
};
</script>
<style scoped>
#next {
  float: right;
}
</style>

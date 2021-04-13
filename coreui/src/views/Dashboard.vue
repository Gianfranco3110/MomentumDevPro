<template>
  <div>
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

    <!-- Productos -->
    
  </div>
</template>

<script>
import indexProducts from "./products/index";

export default {
  name: "Dashboard",
  components: {
    indexProducts,
  },
  data() {
    return {
      isAdmin: false,
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
  },
};
</script>

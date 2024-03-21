<template>
  <div>
    <Headers />
    <CContainer fluid> 
      <CCard>
        
      </CCard>

    </CContainer>
    <Footer />
  </div>
</template>
<script>
import Headers from "../../containers/Header.vue";
import Footer from "../../containers/TheFooter.vue";

function mounted() {
  console.log("id_course", this.$route.params.id);
}

export default {
  components: {
    Headers,
    Footer,
  },
  mounted,
  methods:{
    
  }
};
</script>

<template>
  <div id="cursos-usuario">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
     <CCardHeader class="text-center botonesP text-white row">
        <b class="col-md-9">Cursos del usuario</b>
        <div class="col-md-3">
                <div class="input-group ">
                    <input  class="form-control" @focus="handleFocus" @blur="handleBlur" type="text" v-model="searchQuery" placeholder="Buscar curso...">
                    <span class="input-group-text" id="basic-addon1"><CIcon name="cil-search" /></span>
                </div>
                </div>
      </CCardHeader>
    <AgreModal
      :modal="AddModal"
      @cerrarModal="AddModal = false"
      @child-refresh="refrescarComponente = true"
    />
    <CRow>
      <CCol md="12" v-for="(item, index) in paginatedItems"  :key="index">
        <div class="card">
          <div class="card-body">
            <CRow>
              <CCol md="6">
                <CRow>
                  <CCol md="3">
                    <img
                      :src="$apiAdress + '/api/courses/img/' + item.image"
                      class="bd-placeholder-img card-img-top"
                      width="80"
                      height="80"
                      aria-label="Placeholder: Image cap"
                      role="img"
                    />
                  </CCol>
                  <CCol md="3">
                    {{ item.CourseName }}
                  </CCol>
                  <CCol md="3">
                    {{ item.Video }}
                  </CCol>
                  <CCol md="3">
                    <CBadge class="text-white" :color="getBadge(item.status)">
                      {{item.status}}
                    </CBadge>
                  </CCol>
                </CRow>
              </CCol>
              <CCol md="6">
                <CRow>
                  <CCol md="3">
                    <CButton
                      v-c-tooltip="'Cambiar Estatus'"
                      color="info"
                      @click="AddModal = item"
                    >
                      <CIcon name="cil-color-border" />
                    </CButton>
                  </CCol>
                  <CCol md="3">
                    <CButton
                      v-c-tooltip="'Liberar certificado'"
                      color="success"
                      @click="GetPdf(item.course_id,item.usuario_id)"
                      ><CIcon name="cil-cloud-download" />
                    </CButton>
                  </CCol>
                  <CCol md="3">
                    <CButton
                      v-c-tooltip="'Eliminar'"
                      color="danger"
                      @click="borrarVinculo(item.Vinculo)"
                      ><CIcon name="cil-X" />
                    </CButton>
                  </CCol>
                  <CCol md="3">
                    <CButton
                      v-c-tooltip="'Validar Test'"
                      color="warning"
                      @click="courseUserTest(item.course_id)"
                      ><CIcon name="cil-check-circle" />
                    </CButton>
                  </CCol>
                  
                </CRow>
              </CCol>
            </CRow>
          </div>
        </div>
      </CCol>
    </CRow>
    <div v-if="totalPages>1">
        <h3>Pagina: {{currentPage}}</h3>
        <CPagination
            :activePage.sync="currentPage"
            :pages="totalPages"
            size="lg"
            align="center"
        />
    </div>
  </div>
</template>
<script>
import axios from "axios";
import General from "@/_mixins/general";
import AgreModal from "./edit-userCourses-modal";

function GetPdf(course_id,user_id) {
  console.log("Pedro " + course_id);
  let self = this;
  self.Loading = true;
  let listado = [];
  self.items = [];
  axios
    .post(
      this.$apiAdress +
        "/api/usercertificado" +
        "?token=" +
        localStorage.getItem("api_token"),
        {
          user_id: user_id,
          course_id: course_id,
        }
    )
    .then(function (response) {
      console.log(response.data);
      listado = response.data;

      window.open(response.data.certificado_url, '_blank');
      self.Loading = false;
      self.getCourses();
    })
    .catch(function (error) {
      console.log(error);
      console.log(listado);
      self.getCourses();
      self.Loading = false;
      //self.$router.push({ path: "/login" });
    });
}
export default {
  name: "UserCourses",
  mixins: [General],
  components: {
    General,
    AgreModal,
  },
  data: () => {
    return {
      Loading: false,
      items: [],
      AddModal: false,
      refrescarComponente: false,
      titleVideo: "",
      Secciones: [],
      searchQuery: '',
      itemsPerPage: 5,
      currentPage: 1
    };
  },
  watch: {
    refrescarComponente: function () {
      if (this.refrescarComponente) {
        this.getCourses();
        this.refrescarComponente = false;
      }
    },
  },
  methods: {
    GetPdf,
    getBadge(status) {
      return status === "Pagado"
        ? "success"
        : status === "No Pagado"
        ? "danger"
        : status === "Pending"
        ? "warning"
        : status === "Inactivo"
        ? "danger"
        : "primary";
    },
    borrarVinculo(id) {
      let self = this;
      this.$swal
      .fire({
        title: "ELIMINAR CURSO",
        text: "¿ ESTAS SEGURO QUE DECEAS QUITAR ESTE CURSO ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!",
      })
      .then((result) => {
        if (result.isConfirmed) {
          self.Loading = true;
          axios
          .post(
            this.$apiAdress +
              "/api/usercourses/" +
              id +
              "?token=" +
              localStorage.getItem("api_token"),
            {
              _method: "DELETE",
            }
          )
          .then(function (response) {
            self.getCourses();
            self.Loading = false;
          })
          .catch(function (error) {
            console.log(error);
            self.Loading = false;
            //self.$router.push({ path: '/login' });
          });
        }
      });

     
    },

    getCourses() {
      let self = this;
      self.Loading = true;
      axios
        .get(
          this.$apiAdress +
            "/api/usercourses/" +
            self.$route.params.id +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function (response) {
          self.items = response.data;
          console.log(response.data);
          self.Loading = false;
        })
        .catch(function (error) {
          console.log(error);
          //self.$router.push({ path: "/login" });
        });
    },
    courseUserTest ( id ) {
      let self = this;
      console.log(id);
      // const editLink = this.userCourseLink( id );
      
      this.$router.push({path: '/users/'+self.$route.params.id+'/courses/'+id+'/test-validate'});
    },
    handleFocus() {
        // Lógica a ejecutar cuando el input recibe foco
        console.log('Input enfocado');
        this.currentPage = 1
    },
    handleBlur() {
        // Lógica a ejecutar cuando el input pierde foco
        console.log('Input desenfocado'+ this.items.length);
        this.currentPage = 1;

    }
  },
  mounted: function () {
    this.getCourses();
  },
  computed: {
      filteredItems() {
          return this.items.filter(item => {
          return (
          item.CourseName.toLowerCase().includes(this.searchQuery.toLowerCase())
          );
      });
      },
      paginatedItems() {
          const startIndex = (this.currentPage - 1) * this.itemsPerPage; // 9 cursos por página
          const endIndex = startIndex + this.itemsPerPage;
          return this.filteredItems.slice(startIndex, endIndex);
      },
      totalPages() {
          return Math.ceil(this.filteredItems.length / this.itemsPerPage);
      },
      totalCourse() {
          return this.items.length;
      }
  },
};
</script>

<template>
  <div id="cursos-usuario">
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <h1>Cursos del usuario</h1>

    <hr />
    <AgreModal
      :modal="AddModal"
      @cerrarModal="AddModal = false"
      @child-refresh="refrescarComponente = true"
    />
    <CRow>
      <CCol md="12" v-for="(item, index) in items" :key="index">
        <div class="card">
          <div class="card-body">
            <CRow>
              <CCol md="6">
                <CRow>
                  <CCol md="3">
                    <img
                      :src="$apiAdress + '/storage/courses/' + item.image"
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
                    <CBadge :color="getBadge(item.status)">{{
                      item.status
                    }}</CBadge>
                  </CCol>
                </CRow>
              </CCol>
              <CCol md="6">
                <CRow>
                  <CCol md="3">
                    <CButton
                      v-c-tooltip="'Cambiar Status'"
                      color="info"
                      @click="AddModal = item"
                    >
                      <CIcon name="cil-color-border" />
                    </CButton>
                  </CCol>
                  <CCol md="3">
                    <CButton
                      v-c-tooltip="'Generar certificado'"
                      color="success"
                      @click="GetPdf(item.course_id)"
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
                  
                </CRow>
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
import AgreModal from "./edit-userCourses-modal";

function GetPdf(course_id) {
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
          user_id: localStorage.getItem("id"),
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
        : status === "Banned"
        ? "danger"
        : "primary";
    },
    borrarVinculo(id) {
      let self = this;
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
  },
  mounted: function () {
    this.getCourses();
  },
};
</script>

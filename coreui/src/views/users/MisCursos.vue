<template>
  <div id="mis-cursos">
      <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <h1>Mis Cursos</h1>
    <hr>
    
       <!-- <CRow> 
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
        <CCard>
      <CCardHeader class="text-center botonesP text-white">
        <b>MIS CURSOS</b>
      </CCardHeader>
      <CCardBody>
        <CCol sm="12" class="text-right">          
          <CCol sm="12">
            <CDataTable
              :items="items"
              :fields="fieldsCourse"
              column-filter
              :items-per-page="5"
              :noItemsView="tableText.noItemsViewText"
              :table-filter="tableText.tableFilterText"
              :items-per-page-select="tableText.itemsPerPageText"
              hover
              small
              sorter
              pagination
            >
              <template #status="{item}">
                <td>
                  <CBadge :color="getBadge(item.status)">{{
                    item.status
                  }}</CBadge>
                </td>
              </template>
              <template #Detalle="">
                <td class="py-2">
                  <CButton
                    color="success"
                    square
                    size="sm"
                    class="mr-1"
                    v-c-tooltip="'Ver'"
                  >
                    <CIcon name="cil-room" />
                  </CButton>                  
                </td>
              </template>
            </CDataTable>
          </CCol>
        </CCol>
      </CCardBody>
    </CCard>
   </div>
</template>
<script>
import axios from "axios";
import General from "@/_mixins/general";
const fieldsCourse = [
  
  { key: "CourseName", label: "TITULO" },
  { key: "description", label: "DESCRIPCION" },
  { key: "applies_to_date", label: "VIGENCIA" },
  {
    key: "Detalle",
    label: "",
    sorter: false,
    filter: false,
  },
];

const tableTextHelpers = {
  tableFilterText: {
    label: "FILTRAR:",
    placeholder: "CURSO",
  },
  itemsPerPageText: {
    label: "CURSO POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO POSEES NINGÚN CURSO",
  },
};
export default {
    name: 'MisCursos',
    mixins: [General],
    data: () =>{
        return{
            Loading: false,
            items: [],
            tableText: Object.assign({}, tableTextHelpers),
        }
    },
    props: {
    fieldsCourse: {
      type: Array,
      default() {
        return fieldsCourse;
      },
    },
  },
    methods: {

    },
    mounted: function(){
        
  let self = this;
  self.Loading = true;
  let listado = [];
  self.items = [];
  axios
    .get(
      this.$apiAdress +
        "/api/courses/mycourses?token=" +
        localStorage.getItem("api_token")
    )
    .then(function(response) {
      listado = response.data;
      self.items = listado.map((listado) =>
        Object.assign({}, self.items, {          
          CourseName: listado.CourseName,
          description: listado.description,
          applies_to_date: listado.applies_to_date,
        })
        );
      self.Loading = false;
    })
    .catch(function(error) {
      console.log(error);
      self.$router.push({ path: "/login" });
    });
    }
};
</script>
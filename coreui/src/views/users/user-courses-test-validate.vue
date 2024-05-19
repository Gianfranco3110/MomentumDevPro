<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <modalViewsTestRequest :modal="AddModal" @cerrarModal="AddModal = false" />

    <CCard>
      <CCardHeader class="text-center botonesP text-white">
        <b>LISTADO DE TEST DEL CURSO {{ name_course }}</b>
      </CCardHeader>
      <CCardBody>
        <CCol sm="12" class=" ">
          <CCol sm="12">
            <CDataTable
              class=" "
              :items="items"
              :fields="fields"
              :items-per-page="10"
              :noItemsView="tableText.noItemsViewText"
              :table-filter="tableText.tableFilterText"
              :items-per-page-select="tableText.itemsPerPageText"
              hover
              small
              sorter
              pagination
            >
              <template #request="{ item }">
                <td>
                  <p
                    v-if="item.type_question_num === '2'"
                    @click="AddModal = item"
                    class="text-dark mb-0"
                  >
                    {{ item.request }}
                  </p>
                  <p
                    v-if="item.type_question_num === '3'"
                    class="text-dark mb-0"
                  >
                    {{ item.request }}
                  </p>
                  <img
                    v-if="item.type_question_num === '1'"
                    :src="$apiAdress + item.url_img"
                    class="img_table"
                    @click="AddModal = item"
                    aria-label="Placeholder: Image cap"
                    role="img"
                  />
                </td>
              </template>
              <template #status="{ item }">
                <td>
                  <CBadge class="text-white" :color="getBadge(item.estado)">
                    {{ item.estado }}
                  </CBadge>
                </td>
              </template>
              
              <template #DocsRoute="{ item }">
               
                <td class="py-2">
                  <CButton
                    v-if="
                      (item.type_question_num === '1' ||
                      item.type_question_num === '2') && item.request != ''
                      && item.estado != 'Aprobada'
                    "
                    color="success"
                    square
                    size="sm"
                    class="mr-1"
                    v-c-tooltip="'Aprobar'"
                    @click="sendRevision(1, item.id_answer)"
                  >
                    <CIcon name="cil-check-circle" />
                  </CButton>

                  <CButton
                    v-if="
                      (item.type_question_num === '1' ||
                      item.type_question_num === '2') && item.request != ''
                      && item.estado != 'Aprobada'
                    "
                    color="danger"
                    square
                    size="sm"
                    class="mr-1"
                    v-c-tooltip="'Reporbar'"
                    @click="sendRevision(2, item.id_answer)"
                  >
                    <CIcon name="cil-x" />
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
import modalViewsTestRequest from "./modalViewsTestRequest.vue";
import General from "@/_mixins/general";
const fields = [
  
  { key: "question", label: "PREGUNTA" },
  { key: "request", label: "RESPUESTA" },
  { key: "status", label: "ESTADO" },
  {
    key: "DocsRoute",
    label: "",
    sorter: false,
    filter: false,
  },
];
const tableTextHelpers = {
  tableFilterText: {
    label: "FILTRAR:",
    placeholder: "TEST",
  },
  itemsPerPageText: {
    label: "TEST POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO HAY TEST DISPONIBLES",
  },
};

function sendRevision(val, id_answer) {
  const self = this;
  let status = "";
  console.log('id_answer',id_answer);
  //return;
  if (val == 1) status = "Aprobada";
  else status = "Reprobada";
  self.Loading = true;
  axios
    .post(self.$apiAdress + "/api/answer/validate-answer/", {
      status:status,
      id_answer: id_answer,
    })
    .then(function (response) {
      console.log("response", response);
      self.$toastr.success("Respuesta enviada con éxito!");
      self.ListQuestion(this.$route.params.id_course);
      self.Loading = false;
    })
    .catch(function (error) {
      console.log("error", error);
      self.Loading = false;
    });
}

export default {
  name: "Users",
  mixins: [General],
  components: {
    General,
    modalViewsTestRequest,
  },
  data: () => {
    return {
      items: [],
      currentPage: 1,
      perPage: 15,
      totalRows: 0,
      you: null,
      AddModal: false,
      Loading: false,
      refrescarComponente: false,
      tableText: Object.assign({}, tableTextHelpers),
      name_course: "",
    };
  },
  paginationProps: {
    align: "center",
    doubleArrows: false,
    previousButtonHtml: "prev",
    nextButtonHtml: "next",
  },
  props: {
    modal: null,
    fields: {
      type: Array,
      default() {
        return fields;
      },
    },
  },
  methods: {
    getBadge(status) {
      return status === "CORRECTO"
        ? "success"
        : status === "INCORRECTO"
        ? "danger"
        : status === "PENDIENTE"
        ? "warning"
        : status === "Banned"
        ? "danger"
        : "primary";
    },
    sendRevision,
    ListQuestion(id) {
      let self = this;
      self.Loading = true;
      let listado = [];
      self.items = [];
      axios
        .get(
          this.$apiAdress +
            "/api/coursestest/list/" +
            id +
            "?token=" +
            localStorage.getItem("api_token")
        )
        .then(function (response) {
          listado = response.data;
          console.log("listado nuevooo", listado);
          if (!listado[0] === undefined) {
            self.name_course = listado[0].courses.courseName.toUpperCase();
          }
          let Nro = 1;
          self.items = listado.map((listado) =>
            Object.assign({}, self.items, {
              Nro: Nro++,
              id: listado.id,
              question: listado.question,
              id_answer:listado.answerusers[0] === undefined ? null : listado.answerusers[0].id,
              request:
                listado.type_question === "1"
                  ? listado.answerusers[0] === undefined
                    ? ""
                    : listado.answerusers[0].answer
                  : listado.type_question === "2"
                  ? listado.answerusers[0] === undefined
                    ? ""
                    : listado.answerusers[0].answer
                  : listado.answerusers[0] === undefined
                  ? ""
                  : listado.answerusers[0].answer,
              estado:
                (listado.type_question === "3" ||  listado.type_question === "1") 
                  ? listado.answerusers[0] === undefined
                    ? "PENDIENTE"
                    : (listado.answerusers[0].answer == listado.valid_option )
                    ? "CORRECTO"
                    : "INCORRECTO"
                  : listado.answerusers[0].status,
              type_question_num: listado.type_question,
              // url_img: listado.type_question === '1' ? listado.answerusers[0]===undefined? null : listado.answerusers[0].path_img : null,
              url_img:
                listado.type_question === "1"
                  ? listado.answerusers[0] === undefined
                    ? null
                    : listado.answerusers[0].path_img
                  : null,
              seccion: listado.course_section.name,
              seccion_id: listado.course_section.id,
              type_question:
                listado.type_question === "1"
                  ? "Subir img"
                  : listado.type_question === "2"
                  ? "Escribir respuesta"
                  : "Selección simple",
              id_type: Number(listado.type_question),
            })
          );
          console.log("items", response);
          self.Loading = false;
        })
        .catch(function (error) {
          console.log(error);
          //self.$router.push({ path: "/login" });
        });
    },
  },
  watch: {
    refrescarComponente: function () {
      if (this.refrescarComponente) {
        this.refrescarComponente = false;
      }
    },
  },
  mounted: function () {
    this.ListQuestion(this.$route.params.id_course);
  },
};
</script>
<style lang="css" scoped>
.img_table {
  width: 6vw;
  height: 5vw;
  object-fit: contain;
}
svg {
  color: white !important;
}
</style>

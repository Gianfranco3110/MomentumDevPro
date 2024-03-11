<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <AgreModal
  
    />

    <CCard>
      <AgreModal
            :modal="AddModal"
            @cerrarModal="AddModal = false"
            @child-refresh="refrescarComponente = true"
          />
      <CCardHeader class="text-center botonesP text-white">
        <b>LISTADO DE USUARIOS</b>
      </CCardHeader>
      <CCardBody>
        <CCol sm="12" class="text-right ">
          <CButton
            square
            class="botonesP"
            color="dark"
            @click="redirect()"
          >
            <CIcon name="cil-playlist-add" />&nbsp; NUEVO USUARIO
          </CButton>
          <CCol sm="12">
            <CDataTable class="text-center "
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
          <template #status="{item}">
            <td>
              <CBadge :color="getBadge(item.status)">
                {{item.status}}
              </CBadge>
            </td>
          </template>
            <template #DocsRoute="{item}">
              <td class="py-2">
                <CButton
                  color="dark"
                  class="mr-1"
                  square
                  size="sm"
                  v-c-tooltip="'Editar'"
                  @click="editUser(item.id)"
                >
                <CIcon name="cil-pencil" />
                </CButton>
                <CButton
                v-if="you != item.id"
                  color="danger"
                  square
                  size="sm"
                  class="mr-1"
                  v-c-tooltip="'Eliminar'"
                  @click="deleteUser(item.id)"
                >
                  <CIcon name="cil-trash" />
                </CButton>

                <CButton
                  v-if="you != item.id"
                  color="info"
                  square
                  size="sm"
                  class="mr-1"
                  v-c-tooltip="'Asignar curso'"
                  @click="AddModal = item"
                >
                  <CIcon name="cil-info" />
                </CButton>

                <CButton
                  v-if="you != item.id"
                  color="success"
                  square
                  size="sm"
                  class="mr-1"
                  v-c-tooltip="'Cursos Asignados'"
                  @click="courseUser(item.id)"
                >
                  <CIcon name="cil-list" />
                </CButton>
              </td>
            </template>
          </CDataTable>
          </CCol>
        </CCol>
      </CCardBody>
    </CCard>
  </div>
  <!--<CRow>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CCol col="12" xl="12">
      <transition name="slide">
        <CCard>
          <AgreModal
            :modal="AddModal"
            @cerrarModal="AddModal = false"
            @child-refresh="refrescarComponente = true"
          />
          <CCardHeader>
            Usuarios
          </CCardHeader>
          <CCardBody>
            
            <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                    <th scope="col">Asignación</th>
                    <th scope="col"></th>     
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in items" :key="index">
                    <th scope="row">{{item.id}}</th>
                    <td>{{item.name}}</td>
                    <td>{{item.roles}}</td>
                    <td>
                      <CBadge :color="getBadge(item.status)">{{item.status}}</CBadge>
                    </td>
                    <td>
                      <CButton color="primary" @click="editUser(item.id)"><CIcon name="cil-pencil" /></CButton>
                    </td>
                    <td>
                      <CButton v-if="you != item.id" color="danger" @click="deleteUser(item.id)"><CIcon name="cil-X" />
                      </CButton>
                    </td>
                    <td>
                      <CButton v-if="you != item.id" color="success" @click="AddModal = item">Asignar curso</CButton>
                    </td>
                    <td>
                      <CButton v-if="you != item.id" color="info" @click="courseUser(item.id)">
                        Cursos Asignados
                      </CButton>
                    </td>
                  </tr>   
                </tbody>
              </table>
          </CCardBody>
        </CCard>
      </transition>
    </CCol>
  </CRow>-->
</template>

<script>
import axios from "axios";
import AgreModal from "./assign-course-modal";
import General from "@/_mixins/general";
const fields = [
  {
    key: "id",
    label: "ID",
    _style: "width:1%;",
  },
  { key: "cedula", label: "IDENTIFICACIÓN" },
  { key: "name", label: "NOMBRES" },
  { key: "roles", label: "ROL" },
  { key: "adress_all", label: "DIRECCIÓN",_style: "width:30%;", },
  { key: "status", label: "ESTATUS" },
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
    placeholder: "USUARIO",
  },
  itemsPerPageText: {
    label: "USUARIO POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO HAY USUARIOS DISPONIBLES",
  },
};
export default {
  name: "Users",
  mixins: [General],
  components: {
    General,
    AgreModal,
  },
  data: () => {
    return {
      items: [],
      fields: [
        "id",
        "name",
        "registered",
        "roles",
        "status",
        "editar",
        "eliminar",
        "asignar_curso",
      ],
      currentPage: 1,
      perPage: 15,
      totalRows: 0,
      you: null,
      AddModal: false,
      Loading: false,
      refrescarComponente: false,
      tableText: Object.assign({}, tableTextHelpers),
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
      return status === "Active"
        ? "success"
        : status === "Inactive"
        ? "danger"
        : status === "Pending"
        ? "warning"
        : status === "Banned"
        ? "danger"
        : "primary";
    },
    userLink(id) {
      return `users/${id.toString()}`;
    },
    editLink(id) {
      return `users/${id.toString()}/edit`;
    },
    showUser(id) {
      const userLink = this.userLink(id);
      this.$router.push({ path: userLink });
    },
    editUser(id) {
      const editLink = this.editLink(id);
      this.$router.push({ path: editLink });
    },
    deleteUser(id) {
      let self = this;
      
      let userId = id;
      this.$swal
      .fire({
        title: "ELIMINAR USUARIO",
        text: "¿ ESTAS SEGURO QUE DECEAS ELIMINAR ESTE USUARIO ?",
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
              "/api/users/" +
              id +
              "?token=" +
              localStorage.getItem("api_token"),
            {
              _method: "DELETE",
            }
          )
          .then(function(response) {
            self.Loading = false;
            self.$toastr.success("¡Usuario eliminado con exito!");
            self.getUsers();
          })
          .catch(function(error) {
            console.log(error);
            self.Loading = false;
            self.$toastr.danger("¡Error al eliminar usuario!");
          });
        }
      });
   
    },
    userCourseLink (id) {
      return `users/${id.toString()}/courses`
    },
    courseUser ( id ) {
      const editLink = this.userCourseLink( id );
      this.$router.push({path: editLink});
    },
    getUsers() {
      let self = this;
      self.Loading = true;
      let listado = [];
      axios
        .get(
          this.$apiAdress +
            "/api/users?token=" +
            localStorage.getItem("api_token")
        )
        .then(function(response) {
          listado = response.data.users;
          self.items = listado.map((listado) =>
            Object.assign({}, self.items, {
              id: listado.id,
              name: listado.name,
              registered: listado.registered,
              roles: listado.roles,
              status: listado.status,
              number_document: listado.number_document,
              type_document: listado.type_document,
              adress_all: listado.adress_all ==null?"Sín dirección asignado":listado.adress_all,
              cedula: listado.number_document==null? "--------------------" : listado.type_document+"-"+listado.number_document,
            })
          );
          self.you = response.data.you;
          self.Loading = false;
        })
        .catch(function(error) {
          console.log(error);
          self.Loading = false;
          self.$router.push({ path: "/login" });
        });
    },
    redirect(){
      this.$router.push({ path: "/Registro" });
    }
  },
  watch: {
    refrescarComponente: function() {
      if (this.refrescarComponente) {
        this.getUsers();
        this.refrescarComponente = false;
      }
    },
  },
  mounted: function() {
    this.getUsers();
  },
};
</script>

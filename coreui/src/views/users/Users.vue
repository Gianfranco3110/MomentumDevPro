<template>
  <CRow>
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
  </CRow>
</template>

<script>
import axios from "axios";
import AgreModal from "./assign-course-modal";
import General from "@/_mixins/general";

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
    };
  },
  paginationProps: {
    align: "center",
    doubleArrows: false,
    previousButtonHtml: "prev",
    nextButtonHtml: "next",
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
      self.Loading = true;
      let userId = id;
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

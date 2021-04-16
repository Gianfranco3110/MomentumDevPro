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
            Users
          </CCardHeader>
          <CCardBody>
            <CDataTable
              hover
              striped
              :items="items"
              :fields="fields"
              :items-per-page="5"
              pagination
            >
              <template #status="{item}">
                <td>
                  <CBadge :color="getBadge(item.status)">{{
                    item.status
                  }}</CBadge>
                </td>
              </template>
              <template #show="{item}">
                <td>
                  <CButton color="primary" @click="showUser(item.id)"
                    >Show</CButton
                  >
                </td>
              </template>
              <template #edit="{item}">
                <td>
                  <CButton color="primary" @click="editUser(item.id)"
                    >Edit</CButton
                  >
                </td>
              </template>
              <template #delete="{item}">
                <td>
                  <CButton
                    v-if="you != item.id"
                    color="danger"
                    @click="deleteUser(item.id)"
                    >Delete</CButton
                  >
                </td>
              </template>
              <template #Course="{item}">
                <td>
                  <CButton
                    v-if="you != item.id"
                    color="success"
                    @click="AddModal = item"
                    >Asignar curso</CButton
                  >
                </td>
              </template>
            </CDataTable>
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
        "show",
        "edit",
        "delete",
        "Course",
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
        this.getProducts();
        this.refrescarComponente = false;
      }
    },
  },
  mounted: function() {
    this.getUsers();
  },
};
</script>

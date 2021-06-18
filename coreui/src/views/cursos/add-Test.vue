<template>
  <div>
    <loading-overlay :active="Loading" :is-full-page="true" loader="bars" />
    <CModal
      title="NUEVO TEST"
      :closeOnBackdrop="false"
      color="dark"
      size="xl"
      :show.sync="AddTest"
    >
      <CRow>
        <CCol sm="6">
          <CCol sm="12">
            <div class="form-group form-row">
              <label class="text-right col-form-label required" for="origen"
                >Cursos</label
              >
              <div class="col-sm-6 input-group-sm">
                <CSelect placeholder="SELECCIONE" />
              </div>
            </div>
          </CCol>
          <CCol sm="12">
            <CTextarea
              addLabelClasses="required"
              rows="5"
              label="INGRESE LA PREGUNTA PARA EL TEST"
              maxlength="256"
              placeholder="Ingrese sus preguntas aqui.."
            />
          </CCol>
        </CCol>
        <!-- BOTON DE AGREGAR + -->
        <div>
          <template>
            <td class="center-cell">
              <CButton
                shape="square"
                color="success"
                size="sm"
                v-c-tooltip="'Añadir test'"
                class="align-items-right"
              >
                <CIcon name="cil-plus" />
              </CButton>
            </td>
          </template>
        </div>
        <CCol>
          <CDataTable
            :items="[]"
            :fields="[]"
            column-filter
            :items-per-page="3"
            :noItemsView="tableText.noItemsViewText"
            :table-filter="tableText.tableFilterText"
            :items-per-page-select="tableText.itemsPerPageText"
            hover
            small
            sorter
            pagination
          >
            <template #DocsRoute="{item}">
              <td class="py-2">
                <CButton
                  color="dark"
                  class="mr-1"
                  square
                  size="sm"
                  v-c-tooltip="'Ver'"
                >
                  <CIcon name="cil-search" />
                </CButton>
                <CButton
                  color="danger"
                  square
                  size="sm"
                  class="mr-1"
                  v-c-tooltip="'Quitar'"
                  @click="eliminar(item)"
                >
                  <CIcon name="cil-minus" />
                </CButton>
              </td>
            </template>
          </CDataTable>
        </CCol>
      </CRow>
      <template #footer>
        <CButton color="success">
          <CIcon name="cil-check-circle" />&nbsp; ACEPTAR
        </CButton>
        <CButton color="dark" @click="AddTest = false">
          <CIcon name="cil-chevron-circle-left-alt" />&nbsp; CANCELAR
        </CButton>
      </template>
    </CModal>
  </div>
</template>

<script>
import axios from "axios";
import General from "@/_mixins/general";
import UpperCase from "@/_validations/uppercase-directive";

const tableTextHelpers = {
  tableFilterText: {
    label: "FILTRAR:",
    placeholder: "PREGUNTA",
  },
  itemsPerPageText: {
    label: "PREGUNTA POR PAGINA:",
  },
  noItemsViewText: {
    noResults: "NO SE ENCONTRARON RESULTADOS",
    noItems: "NO HAY PREGUNTAS DISPONIBLES",
  },
};

//DATA
function data() {
  return {
    //MODELOS

    // VARIABLES
    AddTest: false,
    Loading: false,
    tableText: Object.assign({}, tableTextHelpers),
  };
}
export default {
  name: "add-modal",
  mixins: [General],
  data,
  props: {
    modal: null,
  },
  directives: UpperCase,
  watch: {
    modal: function() {
      if (this.modal) {
        this.AddTest = true;
        if (this.modal == true) {
        } else {
          console.log(this.modal);
        }
        this.$emit("cerrarModal");
      }
    },
  },
};
</script>

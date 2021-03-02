<template>
  <div class="container">
    <br>
    <CRow>
      <CCol sm="12">
        <CInput
          invalid-feedback="Campo requerido. {A..Z ,-.*-/#}"
          label="NOMBRE DE USUARIO"
          v-uppercase
          maxlength="20"
          v-model="$v.PackagingName.$model"
          placeholder="INTRODUZCA EL NOMBRE DE USUARIO"
          :is-valid="hasError($v.PackagingName)"
        />
      </CCol>
    </CRow>
    <CRow>
      <CCol sm="12">
        <CInput label="Credit Card Number" placeholder="0000 0000 0000 0000" />
      </CCol>
    </CRow>
    <CRow>
      <CCol sm="4">
        <CSelect
          label="Month"
          :options="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]"
        />
      </CCol>
      <CCol sm="4">
        <CSelect
          label="Year"
          :options="[
            2014,
            2015,
            2016,
            2017,
            2018,
            2019,
            2020,
            2021,
            2022,
            2023,
            2024,
            2025,
          ]"
        />
      </CCol>
      <CCol sm="4">
        <CInput label="CVV/CVC" placeholder="123" />
      </CCol>
    </CRow>
  </div>
</template>

<script>
import ValPrincipal from "@/_validations/ValPrincipal/val";
import UpperCase from "@/_validations/uppercase-directive";
import General from "@/_mixins/general";

function data() {
  return {
    //MODELO
    PackagingName: "",
  };
}
export default {
  data,
  mixins: [General],
  directives: UpperCase,
  validations: ValPrincipal,
};
</script>

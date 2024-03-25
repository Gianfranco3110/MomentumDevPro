<template v-if="show">
  <div>
    <div class="card">
      <div class="card-header">
        <h4>AQUI VA LA SECCION DE TEST : {{ title }}</h4>
      </div>
      <div class="col-md-12 row" v-for="(item, index) in data" :key="index">
        <pre>{{typeof(tipo)}}</pre>
        <div v-if="tipo === '1'" class="col-md-3">
          <label for="ask-title">{{ item.title }}</label>
          <CInput v-model="answer" />
        </div>
        <div v-else-if="tipo === '2'" class="col-md-3" >
          <label for="ask-title">{{ item.title }}</label>
          <input type="checkbox" name="tes" value="tes" :label="item.title" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//data
function data() {
  return {
    // VARIABLES
    title: "",
    answer: "",
  };
}
export default {
  name: "quick",
  data,
  props: {
    show: Boolean,
    data: Array,
    tipo: String
  },
};
</script>

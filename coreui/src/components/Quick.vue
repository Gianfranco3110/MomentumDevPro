<template>
  <div v-if="show" class="col-md-12">
    <div class="card customs-height">
      <div class="card-header botonesP text-center">
        <h4>Comprueba tus conocimientos {{ title }}</h4>
      </div>
      <div class="card-body mb-3">
        <div v-if="tipo === '1'" class="col-md-12 row">
          <div v-for="(item, index) in data" :key="index" class="col-md-12">
            <h5 for="ask-title-file">{{ item.question }}</h5>
            <div class="custom-input-file mt-3">
              <input
                class="input-file"
                label="Imagen del cuestionario"
                type="file"
                name="imagen"
                id="image"
                accept="image/*"
                placeholder="product picture"
              />
              Imagen del cuestionario...
            </div>
          </div>
        </div>
        <div v-if="tipo === '2'" class="col-md-12 row">
          <div v-for="(item, index) in data" :key="index" class="col-md-12">
            <CTextarea :label="item.question" v-model="answer[item.id]" />
          </div>
        </div>
        <div v-if="tipo === '3'">
          <div v-for="(pregunta, index) in data" :key="index" class="mb-5">
            <pre>{{pregunta.selectedOption}}</pre>
            <h5 class="mb-2">{{ pregunta.userQuestion }}</h5>
            <div class="row">
              <div
                v-for="(opcion, i) in pregunta.options"
                :key="i"
                class="col-md-4 mt-3"
              >
                <label :for="'ask-title-multiple-' + index + '-' + i">{{ opcion.option}}</label>
                <input
                  class="ml-2"
                  type="radio"
                  :id="'ask-title-multiple-' + index + '-' + i"
                  :name="'ask-title-multiple-' + index"
                  :value="opcion.option"
                  @change="updateSelectedOption(pregunta, opcion.option)"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <CButton @click="sendAnswer" class="btn botonesCan text-white mr-4">
          <CIcon name="cil-check-circle" />&nbsp; GUARDAR CAMBIOS
        </CButton>
      </div>
    </div>
  </div>
</template>

<script>
import General from "@/_mixins/general";
import axios from 'axios'

function updateSelectedOption(pregunta, selectedOption){
        pregunta.selectedOption = selectedOption;
        const existingAnswerIndex = this.selectedAnswers.findIndex(answer => answer.id_question === pregunta.id_question);
        
        if(existingAnswerIndex !== -1) {
            this.selectedAnswers[existingAnswerIndex].answer = selectedOption;
        } else {
            this.selectedAnswers.push({ id_question: pregunta.id_question, answer: selectedOption });
        }
        console.log('answer',this.selectedAnswers);
}
//data
function data() {
  return {
    // VARIABLES
    title: "",
    answer: {},
    selectedAnswers: [],
  };
}

function sendAnswer() {
 
  const self = this;
  let data = "";
  if(this.tipo === '3'){
    data = this.selectedAnswers;
  }else if(this.tipo === '2'){
    data = this.answer;
  }
  //self.dataUser.Loading = true;
  axios
    .post(self.$apiAdress + "/api/answer/store", {
      tipo: self.tipo,
      answer: data,
      id_user:localStorage.getItem("id")
    })
    .then(function (response) {
      console.log("response", response);
      self.$toastr.success("Respuesta enviadas con exito!");
      this.$v.$reset();
      //self.dataUser.Loading = false;
    })
    .catch(function (error) {
      console.log("error", error);
      //self.dataUser.Loading = false;
    });
}

export default {
  name: "quick",
  mixins: [General],
  data,
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    data: null,
    tipo: String,
  },
  methods: {
    sendAnswer,
    updateSelectedOption
  },
};
</script>
<style scoped>
svg {
  color: white !important;
}
.custom-input-file {
  background-color: #535d6d;
  color: #fff;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
  margin: 0;
  min-height: 15px;
  overflow: hidden;
  padding: 10px;
  position: relative;
  text-align: center;
  width: 100%;
}

.custom-input-file .input-file {
  border: 10000px solid transparent;
  cursor: pointer;
  font-size: 10000px;
  margin: 0;
  opacity: 0;
  outline: 0 none;
  padding: 0;
  position: absolute;
  right: -1000px;
  top: -1000px;
}
.customs-height {
  min-height: 60vh;
}
</style>

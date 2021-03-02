  //Data:

  //Metodos:
  function getBadge(status) {
    switch (status) {
      case 'ACTIVO':
        return 'success'
      case 'INACTIVO':
        return 'danger'
    }
  }

  function hasError(field){
    return field.$dirty ? !field.$error : null;
  }

  //Computeds
  function desactivado() {
    return this.$v.$invalid
  }

  function statusSelectColor(){
    return this.Status === 1;
  }

  export default {
    methods: {
      getBadge,
      hasError,
      statusSelectColor
    },
    computed: {
      desactivado
    }
  }
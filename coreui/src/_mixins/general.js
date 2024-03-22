
import axios from "axios";
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

function hasError(field) {
  return field.$dirty ? !field.$error : null;
}

//Computeds
function desactivado() {
  return this.$v.$invalid
}

function statusSelectColor() {
  return this.Status === 1;
}

// funcion para traer los estados 
async function getStated() {
  var stated = [];
  // await axios.get("https://www.universal-tutorial.com/api/getaccesstoken", {
  //   headers: {
  //     "Accept": "application/json",
  //     "api-token": "Zg5KFEd5KFMHYXLzSTKTSX8h9xu4rq5lv8_ngN_ukGN8AmwA1HIvYQs5rN7qYst7jGM",
  //     "user-email": "peluisrodriguez2@gmail.com"
  //   }
  // }).then(async function (response) {
  //   if (response.data) {
  //     // console.log(response.data);
  //     var auth_token = response.data.auth_token;
  //     localStorage.setItem("_token_countries", auth_token);

  //     await axios.get("https://www.universal-tutorial.com/api/countries/", {
  //       headers: {
  //         "Authorization": "Bearer " + auth_token,
  //         "Accept": "application/json",
  //       }
  //     }).then(async function (response) {
  //       if (response.data) {
  //         var countries = response.data;
  //         console.log(countries);
  //         // Buscamos el objeto del pais venezuela
  //         // Codigo elegante papa HA.
  //         const countrie_vnz = countries.find(countrie => countrie.country_phone_code === 58);
  //         // console.log(countrie_vnz);
  //         await await axios.get("https://www.universal-tutorial.com/api/states/" + countrie_vnz.country_name, {
  //           headers: {
  //             "Authorization": "Bearer " + auth_token,
  //             "Accept": "application/json",
  //           }
  //         }).then(function (response) {
  //           if (response.data) {
  //             let stated_resp = response.data;
  //             let stated_c_n = stated_resp.map((stated_resp) =>
  //               Object.assign({}, stated_c_n, {
  //                 label: stated_resp.state_name,
  //                 value: stated_resp.state_name,
  //               })
  //             );

  //             stated = stated.concat(stated_c_n);
  //             // console.log(stated);
  //           }
  //         }).catch(function (error) {
  //           console.log("axios3" + error)
  //         });
  //         // return countries
  //       }
  //     }).catch(function (error) {
  //       console.log("axios2" + error)
  //     });
  //   }
  // }).catch(function (error) {
  //   console.log("axios1" + error)
  // });

  await axios.get(this.$apiAdress+"/api/states", {
    headers: {
      "Accept": "application/json",
    }
  }).then(async function (response) {
      let stated_resp = response.data;
      // console.log(stated_resp
      let stated_c_n = stated_resp.map((stated_resp) =>
        Object.assign({}, stated_c_n, {
          label: stated_resp.state_name,
          value: stated_resp.id,
        })
      );

      stated = stated.concat(stated_c_n);
  }).catch(function (error) {
      console.log("axios1" + error)
  });

  return stated;
}

// funcion para traer los municipios o ciudades
async function getMunicipality(municipality) {
  var municipality_resp = [];
  // var auth_token = localStorage.getItem("_token_countries");
  // await await axios.get("https://www.universal-tutorial.com/api/cities/" + municipality, {
  //   headers: {
  //     "Authorization": "Bearer " + auth_token,
  //     "Accept": "application/json",
  //   }
  // }).then(function (response) {
  //   if (response.data) {

  //     let muni_resp = response.data;
  //     let municipality_nw = muni_resp.map((muni_resp) =>
  //       Object.assign({}, municipality_nw, {
  //         label: muni_resp.city_name,
  //         value: muni_resp.city_name,
  //       })
  //     );

  //     municipality_resp = municipality_resp.concat(municipality_nw);
      
  //     // return countries
  //   }
  // }).catch(function (error) {
  //   console.log("axios municipality" + error)
  // });
  await axios.get(this.$apiAdress+"/api/states?state_id="+municipality, {
    headers: {
      "Accept": "application/json",
    }
  }).then(async function (response) {
      let muni_resp = response.data;
      let municipality_nw = muni_resp.map((muni_resp) =>
        Object.assign({}, municipality_nw, {
          label: muni_resp.city_name,
          value: muni_resp.city_name,
        })
      );

      municipality_resp = municipality_resp.concat(municipality_nw);
  }).catch(function (error) {
      console.log("axios1" + error)
  });
  return municipality_resp;

}

async function getCourseDetailsLanding(id_course) {
  var course_resp = [];

  await axios.get(this.$apiAdress+"/api/courses/details/landig?course_id="+id_course, {
    headers: {
      "Accept": "application/json",
    }
  }).then(async function (response) {
      course_resp = response.data;

      // console.log(course_details);
  }).catch(function (error) {
      console.log("axios1" + error)
      return false;
  });
  return course_resp;

}
export default {
  methods: {
    getBadge,
    hasError,
    statusSelectColor,
    getStated,
    getMunicipality,
    getCourseDetailsLanding
  },
  computed: {
    desactivado
  }
}
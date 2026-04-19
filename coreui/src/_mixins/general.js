
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
async function getStated(id_pais) {
  var stated = [];

  await axios.get(this.$apiAdress+"/api/states?country_id="+id_pais, {
    headers: {
      "Accept": "application/json",
    }
  }).then(async function (response) {
      let stated_resp = response.data;
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

async function getpais() {
  var municipality_resp = [];
  await axios.get(this.$apiAdress+"/api/countries", {
    headers: {
      "Accept": "application/json",
    }
  }).then(async function (response) {
      //console.log('pais',response);
      let muni_resp = response.data;
      let municipality_nw = muni_resp.map((muni_resp) =>
        Object.assign({}, municipality_nw, {
          label: muni_resp.country_name,
          value: muni_resp.id,
        })
      );

      municipality_resp = municipality_resp.concat(municipality_nw);
  }).catch(function (error) {
      console.log("axios1" + error)
  });
  return municipality_resp;

}
function formLinkIframeVideo(linkValue) {
  let dataResp="";
  let url = new URL(linkValue);
  let host = url.host;
  let hostName = host.split('.')[1];
  if (hostName == 'youtube') {

    // Extraer el ID del video de la URL
    let videoId = linkValue.split('v=')[1];

    // Construir la nueva URL embebida
     dataResp = 'https://www.youtube.com/embed/' + videoId;

  }else{
    dataResp = url;
  }
  console.log(dataResp);
  return dataResp;
}

async function getCourseDetailsLanding(id_course) {
  var course_resp = [];

  await axios.get(this.$apiAdress+"/api/courses/details/landig?course_id="+id_course, {
    headers: {
      "Accept": "application/json",
    }
  }).then(async function (response) {
      course_resp = response.data;

      console.log('hola mundo2',response);
  }).catch(function (error) {
      console.log("axios1" + error)
      return false;
  });
  return course_resp;

}

async function getCourseUserAll(id_user) {
  var municipality_resp = [];

  await axios.get(this.$apiAdress+"/api/usercourses/list/"+id_user, {
    headers: {
      "Accept": "application/json",
    }
  }).then(async function (response) {
    console.log('videopressent',response);
      let muni_resp = response.data;
      let municipality_nw = muni_resp.map((muni_resp) =>
        Object.assign({}, municipality_nw, {
          name: muni_resp.courses.CourseName,
          course_id: muni_resp.curso_id,
          description: muni_resp.courses.description,
          video_presentation: muni_resp.video_presentation,
          status: muni_resp.status == "Pagado"?true:false,
          status_video: muni_resp.courses.status.name,
          status_id_video: muni_resp.courses.status.id,
          status_video_class: muni_resp.courses.status.class,
          certificado:muni_resp.certificado
        })
      );
      municipality_resp = municipality_resp.concat(municipality_nw);
      // console.log(course_resp);
  }).catch(function (error) {
      console.log("axios1" + error)
      return false;
  });
  return municipality_resp;
}
export default {
  methods: {
    getBadge,
    hasError,
    statusSelectColor,
    getStated,
    getMunicipality,
    getCourseDetailsLanding,
    formLinkIframeVideo,
    getCourseUserAll,
    getpais
  },
  computed: {
    desactivado
  }
}
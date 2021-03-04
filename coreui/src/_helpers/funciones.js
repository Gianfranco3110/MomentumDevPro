import XLSX  from 'xlsx';

const DateFormater = {
  toNormalDate(date, separator) {
    let newDay = new Date(date),
        day = ('0'+newDay.getDate()).slice(-2),
        month = ('0'+ (newDay.getMonth() + 1) ).slice(-2),
        year = newDay.getFullYear();
  
    separator = separator ? separator : '/';

    return `${day}${separator}${month}${separator}${year}`;
  },
  toLongDate(date) {
    let meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  
    return `${date.getDate()} de ${meses[date.getMonth()]} de ${date.getFullYear()}`;
  },
  toInvertDate(date, separator) {
    let newDay = new Date(date),
        day = ('0'+newDay.getDate()).slice(-2),
        month = ('0'+ (newDay.getMonth() + 1) ).slice(-2),
        year = newDay.getFullYear();
  
    separator = separator ? separator : '-';

    return `${year}${separator}${month}${separator}${day}`;
  }
}
const GenerateExcel = (jsonArray = [], name) => {
  if(Array.isArray(jsonArray)){
      let fileName = name ? name: '';
      let worksheet = XLSX.utils.json_to_sheet(jsonArray);
      let workbook = XLSX.utils.book_new();
      let today = DateFormater.toNormalDate(new Date(), '-');
      let time = new Date().getTime();

      XLSX.utils.book_append_sheet(workbook, worksheet, `${fileName}`);
      XLSX.writeFile(workbook, `${fileName}_${today}_${time}.xlsx`);
  } else {
      console.log('Error: Solo se aceptan Arrays como parametro.');
  }
}

function GenerateImgPlaceholder(text='N/A', width=200, height=200, colorTxt='#4f5d73', colorBg='#ebedef'){
  let canvas = document.createElement("canvas");
  let context = canvas.getContext("2d");
  canvas.width = height>=100?height:100;
  canvas.height = width=100?width:100;

  context.fillStyle = colorBg;
  context.fill();

  context.font = (canvas.height/4) + "px Arial";
  context.fillStyle = colorTxt;

  context.textAlign = "center";
  context.textBaseline = "middle";
  context.fillText(text, canvas.width/2, canvas.height/2);
      
  return canvas.toDataURL();
}

function GenerateSvgPlaceholder(options = {}) {
  let defaults = {
    width: 200,
    height: 150,
    bgColor: '#ebedef',
    textColor: '#4f5d73',
    fontFamily: 'sans-serif',
    fontSize: 30,
    dy: 10.5,
    fontWeight: 'bold',
    text: 'NO IMG'
  };
  options = {...defaults, ...options};

  let svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${options.width}" height="${options.height}" viewBox="0 0 ${options.width} ${options.height}">
  <rect fill="${options.bgColor}" width="${options.width}" height="${options.height}"/>
  <text fill="${options.textColor}" font-family="${options.fontFamily}" font-size="${options.fontSize}" dy="${options.dy}" font-weight="${options.fontWeight}" x="50%" y="50%" text-anchor="middle">${options.text}</text>
</svg>`;

  const cleaned = svg
    .replace(/[\t\n\r]/gim, '') // Strip newlines and tabs
    .replace(/\s\s+/g, ' ') // Condense multiple spaces
    .replace(/'/gim, '\\i'); // Normalize quotes

  const encoded = encodeURIComponent(cleaned)
    .replace(/\(/g, '%28') // Encode brackets
    .replace(/\)/g, '%29');

  return `data:image/svg+xml;charset=UTF-8,${encoded}`;
}

const tableTextHelpers = {
  tableFilterText: {
      label: 'Filtrar:',
      placeholder: 'INGRESE BUSQUEDA...'
  },
  itemsPerPageText: {
      label: 'Registros por Pagina:'
  },
  noItemsViewText: { 
      noResults: 'No se han encontrado resultados', 
      noItems: 'No hay registros disponibles'
  },
};

const imgInputMsgs = {
  upload: '<p>Tu dispositivo no soporta la subida de archivos.</p>', // HTML allowed
  drag: 'Click aqui para seleccionar un <br>FOTO', // HTML allowed
  tap: 'Toque para seleccionar un FOTO', // HTML allowed
  change: 'Cambiar Foto', // Text only
  remove: 'Eliminar Foto', // Text only
  select: 'Seleccionar un Foto', // Text only
  selected: '<p>Foto seleccionado!</p>', // HTML allowed
  fileSize: 'El tamaño del archivo excede el limite permitido.', // Text only
  fileType: 'El tipo de archivo no esta permitido.', // Text only
  aspect: 'Landscape/Portrait' // Text only
};

function validarExtension(datos) {
  let ruta = datos.name;

  if (! /\.(jpg|svg|jpeg|png|bmp|gif)$/i.test(datos.name)) {
      return false;
  }else{
      return true;
  }
}

function validURL(str) {
	var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
	  '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
	  '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
	  '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
	  '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
	  '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
	return !!pattern.test(str);
}

function slugify (text) {
  const a = 'àáäâèéëêìíïîòóöôùúüûñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;'
  const b = 'aaaaeeeeiiiioooouuuuncsyoarsnpwgnmuxzh------'
  const p = new RegExp(a.split('').join('|'), 'g')

  return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(p, c =>
        b.charAt(a.indexOf(c)))     // Replace special chars
    .replace(/&/g, '-and-')         // Replace & with 'and'
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '')             // Trim - from end of text
}

export { 
  DateFormater,
  tableTextHelpers,
  imgInputMsgs,
  GenerateExcel,
  validarExtension,
  GenerateImgPlaceholder,
  GenerateSvgPlaceholder,
  validURL,
  slugify
};
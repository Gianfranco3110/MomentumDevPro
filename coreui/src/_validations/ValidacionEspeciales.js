import { 
    helpers 
} from "vuelidate/lib/validators";

const credentials = helpers.regex('alphaNum', /(^[V,P,J,E]{1})(\d{9})$/gm);
const onlyText = helpers.regex('alpha', /^[a-zA-Z\s]+$/);
const onlyAlphanumeric = helpers.regex('alpha', /^[a-zA-ZñÑ .,0-9]+$/);
const siglasAlphanumeric = helpers.regex('alpha', /^[A-Z0-9]+$/);
const onlyNumeroTresdigitos= helpers.regex('alphaNum', /^\d{3}$/);
const onlyNumber = helpers.regex('alpha', /^[0-9]+$/);
const onlyMayusText = helpers.regex('alpha', /^[A-Z\s]+$/);
const onlyMayusTextEspecial = helpers.regex('alpha', /^[A-ZÑ -.,´\s]+$/);
const UtcZone = helpers.regex('alpha', /^([+-](?:2[0-3]|[01][0-9]):[0-5][0-9])$/);
const cellphone = (value) => /(^[+]{1})([\d]{11,15})+$/g.test(value);
const especiales = helpers.regex('alpha', /^[-\/\\a-zA-Z.,;0-9@ -#():Ññ]+$/);
const decimalEspecial = (value) => /^(\d+(.{1}\d{2})?)$/.test(value);
const inputColor = helpers.regex('alpha', /^#([A-F0-9]{6}|[A-F0-9]{3})$/);
const phoneTest = (value) => /^[\d]{4}[-]?\d{7}$|^[\+\d]{2,4}[-]?\d{7,11}$/.test(value);

const SoloEnteros = (e) => {
    var regex = new RegExp("^[0-9]+$");
    if (regex.test(e)) {
        return true;
    }
    return false
};

const SoloNumeros = (e) => {
    var regex = new RegExp("^[0-9.]+$");
    if (regex.test(e)) {
        return true;
    }
    return false
};

const SoloAlfanumericos = (e) => {
    var regex = new RegExp("^[a-zA-ZñÑ.,;0-9@ -/]+$");
    if (regex.test(e)) {
        return true;
    }
    return false
};

const SoloLetras = (e) => {
    var regex = new RegExp("^[a-zA-Z ]+$");
    if (regex.test(e)) {
        return true;
    }
    return false
};

const requiredSelect = (value) => {
    return value !== 0 && value !== "0";
}

const nullable = (value) => {
    if(value === '' )
    return true
}

export { 
    SoloEnteros, 
    SoloNumeros, 
    SoloAlfanumericos, 
    SoloLetras,
    requiredSelect,
    cellphone,
    nullable,
    decimalEspecial,
    phoneTest,
    onlyNumber,
    credentials, 
    onlyText,
    onlyNumeroTresdigitos,
    UtcZone,
    onlyMayusText,
    onlyAlphanumeric,
    siglasAlphanumeric,
    onlyMayusTextEspecial,
    especiales,
    inputColor
};
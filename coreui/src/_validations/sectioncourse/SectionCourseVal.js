import { required, maxLength, } from "vuelidate/lib/validators";
import {  especiales,SoloEnteros,decimalEspecial } from '@/_validations/ValidacionEspeciales';

export default () => {
    return {
        section : {
            name: { required, especiales, maxLength: maxLength(500) },
            orden: { required, SoloEnteros},
        }    
    }
}
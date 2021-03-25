import { required, maxLength, } from "vuelidate/lib/validators";
import {  especiales,decimalEspecial } from '@/_validations/ValidacionEspeciales';

export default () => {
    return {
        description: { required, especiales, maxLength: maxLength(256) },
        price: { required, especiales, maxLength: maxLength(20) }, 
        daysofvalidity: { required, especiales, maxLength: maxLength(20) },  
         
    }
}
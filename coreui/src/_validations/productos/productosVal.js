import { required, maxLength, } from "vuelidate/lib/validators";
import {  especiales, } from '@/_validations/ValidacionEspeciales';

export default () => {
    return {
        product : {
            description: { required, especiales, maxLength: maxLength(256) },
            title: { required,especiales, maxLength: maxLength(20) }, 
            product_type: { required,especiales, maxLength: maxLength(20) },
        }    
    }
}
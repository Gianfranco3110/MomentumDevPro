import { required, maxLength, } from "vuelidate/lib/validators";
import {  especiales,decimalEspecial } from '@/_validations/ValidacionEspeciales';

export default () => {
    return {
        PackagingName: { required, especiales, maxLength: maxLength(20) },
        
    }
}
import { required, maxLength, } from "vuelidate/lib/validators";
import {  especiales,SoloEnteros,decimalEspecial } from '@/_validations/ValidacionEspeciales';

export default () => {
    return {
        curso : {
            description: { required, especiales, maxLength: maxLength(256) },
            price: { required, decimalEspecial, maxLength: maxLength(20) }, 
            daysofvalidity: { required, SoloEnteros, maxLength: maxLength(20) },
            CourseName: { required, maxLength: maxLength(50) },
        }    
    }
}
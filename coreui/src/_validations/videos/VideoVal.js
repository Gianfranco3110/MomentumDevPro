import { required, maxLength, } from "vuelidate/lib/validators";
import {  especiales, } from '@/_validations/ValidacionEspeciales';

export default () => {
    return {
        video : {
            description: { required, especiales, maxLength: maxLength(256) },
            url_video: { required, maxLength: maxLength(500) },
            order: { required },
            section_id: { required },
        }    
    }
}
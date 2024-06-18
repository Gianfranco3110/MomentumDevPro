import { required, maxLength, } from "vuelidate/lib/validators";

export default () => {
    return {
        video : {
            description: { required, maxLength: maxLength(256) },
            url_video: { required, maxLength: maxLength(500) },
            order: { required },
            section_id: { required },
        }    
    }
}
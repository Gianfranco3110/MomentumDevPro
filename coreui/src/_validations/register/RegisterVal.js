import { required, maxLength,email,minLength,sameAs,helpers,numeric} from "vuelidate/lib/validators";


import {  especiales,SoloEnteros,decimalEspecial } from '@/_validations/ValidacionEspeciales';

export default () => {
    return {
        dataUser : {
            name: { required, especiales, maxLength: maxLength(256) },
            number_document: { required, especiales, maxLength: maxLength(256),numeric },
            type_document: { required },
            adress: { required },
            // value_stated: { required },
            // value_municipality: { required },
            street: { required },
            email: { required, especiales, maxLength: maxLength(256),email },
            password:{required,  minLength: minLength(5)},
            confirmPassword: { required, sameAsPassword: sameAs('password') }
        }    
    }
}
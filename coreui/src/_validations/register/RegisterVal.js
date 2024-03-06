import { required, maxLength,email,minLength,sameAs,helpers} from "vuelidate/lib/validators";


import {  especiales,SoloEnteros,decimalEspecial } from '@/_validations/ValidacionEspeciales';

export default () => {
    return {
        dataUser : {
            name: { required, especiales, maxLength: maxLength(256) },
            email: { required, especiales, maxLength: maxLength(256),email },
            password:{required,  minLength: minLength(5)},
            confirmPassword: { required, sameAsPassword: sameAs('password') }
        }    
    }
}
<template>
    <div>
        <label>{{ label }}</label>
        <input
            type="text"
            v-model="v$.value.$model"
            class="form-control form-control-lg"
            @input="$emit('has-errors', value, hasErrors)"
            :class=" { 'is-invalid': v$.value.$errors?.length > 0, 'is-valid': !v$.value.$invalid } "
        />
        <div class="error-wrapper">
            <div v-for="error of v$.value.$errors" :key="error.$uid" class="input-errors">
                <div class="text-danger">{{ error.$message }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import useVuelidate from '@vuelidate/core'
import { helpers, required, minLength } from '@vuelidate/validators'
import * as validators from '@vuelidate/validators'

export default defineComponent({
    props: ["inputValue", "message","type","label"],
    setup () {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            value: this.inputValue,
            invalidInput: false,
        }
    },
    computed: {
        validationRule() {
            if(this.type === "phone") {
                return (value) => {
                    const regex = /\+[1-9]\d{8,14}/
                    return regex.test(value);
                }
            }
            const validator = validators[this.type];
            if (validator) {
                return validator;
            } else {
                return helpers.withMessage(this.message, value => true)
            }
        },
        hasErrors() {
            return !!this.v$.value.$error;
        },
    },
    validations () {
        return {
            value: {
                required: helpers.withMessage(this.message, required),
                type: helpers.withMessage(this.message, this.validationRule),
                minLength: minLength(8)
            }
        }
    },
});

</script>

<style scoped>

</style>

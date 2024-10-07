<template>
    <div class="p-inputgroup flex-1 w-25">
        <InputText placeholder="Search" @keyup="search($event.target.value)" />
        <Button icon="pi pi-search" severity="warning" class="searchButton"/>
    </div>
</template>
<script>
import axios from "axios";
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
export default {
    components:{
        Button,
        InputText
    },
    methods: {
        async search($event) {
            this.$emit('text-updated', $event);
        },
    },
}
</script>
<style scoped>

</style>

<template>
    <base-dialog
        v-if="!isLoading"
        :title="brand.name"
        @handle-submit="deleteBrand"
        @close="closeDialog"
    >
        <div class="form-group d-flex">
            <i class="mdi mdi-table-question text-danger"></i>
            <ul class="ms-5 list-group">
                <li class="h4">Are you sure you want to delete this Brand? </li>
                <li class="h4">All Products associated with this brand will also be deleted.</li>
                <li class="h4 text-uppercase text-danger">This action can not be undone.</li>
            </ul>
        </div>
    </base-dialog>
    <div>
    </div>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import BrandService from "../Services/BrandService.js";

export default {
    components: {
        BaseDialog,
    },
    props: [
        'brandId'
    ],
    emits: ['close-dialog','update-brands'],
    data() {
        return {
            brand: {},
            isLoading: false,
        };
    },
    methods: {
        async deleteBrand() {
            try {
                await BrandService.deleteBrand(this.brandId)
            } catch (error) {
                console.error(error);
            }
            this.$emit('close-dialog');
            this.$emit('update-brands');
        },
        closeDialog() {
            this.$emit('close-dialog');
        }
    },
    async mounted(payload) {
        this.brand = (await BrandService.getBrandById(payload, this.brandId));
    }
};
</script>

<style scoped>
.fa-sharp {
    font-size:50px;
    color:red;
}
.p-d-flex {
    display: flex;
}
.p-d-flex div {
    margin-left:15px;
}

</style>


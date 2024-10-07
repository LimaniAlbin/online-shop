<template>
    <base-dialog
        v-if="!isLoading"
        :title="product.name"
        @handle-submit="deleteProduct"
        @close="closeDialog"
    >
        <div class="form-group d-flex my-3">
            <i class="mdi mdi-table-question text-danger"></i>
            <div class="ms-5 my-auto">
                <h5 >Are you sure you want to delete this Product.</h5>
                <h5>This action can not be undone.</h5>
            </div>
        </div>
    </base-dialog>
    <div>
    </div>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import ProductService from "../../admin/Services/ProductService";

export default {
    components: {
        BaseDialog,
    },
    props: [
        'productId'
    ],
    emits: ['close-dialog','update-products'],
    data() {
        return {
            product: {},
            isLoading: false,
        };
    },
    methods: {
        async deleteProduct() {

            try {
                await ProductService.deleteProduct(this.productId)
            } catch (error) {
                console.error(error);
            }
            this.$emit('close-dialog');
            this.$emit('update-products');
        },
        closeDialog() {
            this.$emit('close-dialog');
        }
    },
    async mounted() {
        this.product = await ProductService.getProductById(this.productId);
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


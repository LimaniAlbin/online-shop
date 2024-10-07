<template>
    <base-dialog
        v-if="!isLoading"
        :title="category.name"
        @handle-submit="deleteCategory"
        @close="closeDialog"
    >
        <div class="form-group d-flex">
            <i class="mdi mdi-table-question text-danger"></i>
            <ul class="ms-5 list-group">
                <li class="h4">Are you sure you want to delete this Category? </li>
                <li class="h4">All Products associated with this category will also be deleted.</li>
                <li class="h4 text-uppercase text-danger">This action can not be undone.</li>
            </ul>
        </div>
    </base-dialog>
    <div>
    </div>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import CategoryService from "../Services/CategoryService.js";

export default {
    components: {
        BaseDialog,
    },
    props: [
        'categoryId'
    ],
    emits: ['close-dialog','update-categories'],
    data() {
        return {
            category: {},
            isLoading: false,
        };
    },
    methods: {
        async deleteCategory() {
            try {
                await CategoryService.deleteCategory(this.categoryId)
            } catch (error) {
                console.error(error);
            }
            this.$emit('close-dialog');
            this.$emit('update-categories');
        },
        closeDialog() {
            this.$emit('close-dialog');
        }
    },
    async mounted() {
        this.category = (await CategoryService.getCategoryById(this.categoryId));
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


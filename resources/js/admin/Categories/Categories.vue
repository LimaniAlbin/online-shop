<template>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <loading-spinner v-if="isLoading"/>
                    <div class="card" v-else>
                        <div class="card-body">
                            <h4 class="card-title">Categories</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <button
                                    @click="showModal = true"
                                    class="btn btn-primary"
                                    style="margin: 20px 0"
                                >
                                    <i class="mdi mdi-plus text-white"></i>
                                    Add New Category
                                </button>

                            </div>
                            <div class="table-responsive rounded rounded-2 ">
                                <table
                                    class="table rounded rounded-2 overflow-hidden table-hover table-striped table-bordered align-middle mb-0 bg-white">
                                    <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th class="text-center w-25" colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="category in categories"
                                        :key="category.id"
                                    >
                                        <td>
                                            {{ category.name }}
                                        </td>
                                        <td class="table_desc" @click="openImageModal(category.image)">
                                            <img :src="'images/categories/' + category.image" alt="Category Image"
                                                 class="category-image"/>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                @click="showEditCategoryModal = true;categoryId=category.id"
                                                class="btn btn-primary"
                                            >
                                                <i class="mdi mdi-pencil me-1"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                @click="showDeleteCategoryModal = true;categoryId=category.id"
                                                class="btn btn-danger"
                                            >
                                                <i class="mdi mdi-trash-can me-1"></i>
                                            </button
                                            >
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <create-category v-if="showModal" @close-dialog="showModal = false" @update-categories="fetchData"/>
    <edit-category v-if="showEditCategoryModal" :category-id="categoryId" @update-categories="fetchData"
                @close-dialog="showEditCategoryModal = false"/>
    <delete-category v-if="showDeleteCategoryModal" :category-id="categoryId" @update-categories="fetchData"
                  @close-dialog="showDeleteCategoryModal = false"/>

    <div class="modal" v-if="showImageModal" @click="closeImageModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img :src="'images/categories/' + enlargedImage" alt="Enlarged Category Image" class="enlarged-image"/>
        </div>
    </div>

</template>


<script>
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import CreateCategory from "./CreateCategory.vue";
import EditCategory from "./EditCategory.vue";
import DeleteCategory from "./DeleteCategory.vue";
import CategoryService from "../Services/CategoryService";
import LoadingSpinner from "../components/LoadingSpinner.vue";


export default {
    components: {
        Button,
        CreateCategory,
        EditCategory,
        DeleteCategory,
        InputText,
        LoadingSpinner,

    },
    data() {
        return {
            categories: [],
            categoryId: null,
            showModal: false,
            showEditCategoryModal: false,
            showDeleteCategoryModal: false,
            isLoading: false,
            showImageModal: false,
            enlargedImage: '',
        };
    },
    methods: {
        async fetchData() {
            try {
                this.isLoading = true;
                this.categories = await CategoryService.getCategories();
                this.isLoading = false;
            } catch (error) {
                console.error(error);
            }
        },
        openImageModal(image) {
            this.enlargedImage = image;
            this.showImageModal = true;
        },
        closeImageModal() {
            this.showImageModal = false;
        },
    },
    async mounted() {
        await this.fetchData()
    }


};
</script>
<style scoped>
.table th, table td {
    white-space: normal;
}

.category-image {
    display: block;
    margin: 0 auto;
    border-radius: 0;
    width: 50px;
    height: auto;
}

.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 10000;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    max-width: 100%;
    max-height: 100%;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    color: white;
    cursor: pointer;
}

.enlarged-image {
    display: block;
    margin: 0 auto;
    border-radius: 0;
    max-width: 80%;
    max-height: 80%;
}

</style>


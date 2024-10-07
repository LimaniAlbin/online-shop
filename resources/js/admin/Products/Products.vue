<template>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <loading-spinner v-if="isLoading"/>
                    <div class="card" v-else>
                        <div class="card-body">
                            <h4 class="card-title">Products</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <button
                                    @click="showModal = true"
                                    class="btn btn-primary"
                                    style="margin: 20px 0"
                                >
                                    <i class="mdi mdi-plus text-white"></i>
                                    Add New Product
                                </button>
                                <Search @text-updated="search($event)"></Search>

                            </div>
                            <div class="table-responsive rounded rounded-2 ">
                                <table
                                    class="table rounded rounded-2 overflow-hidden table-hover table-striped table-bordered align-middle mb-0 bg-white">
                                    <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Image</th>
                                        <th>Description</th>
                                        <th class="text-center" colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="product in products"
                                        :key="product.id"
                                    >
                                        <td>
                                            {{ product.name }}
                                        </td>
                                        <td class="table_desc">
                                            {{ product.brand.name }}
                                        </td>
                                        <td class="table_desc">
                                            {{ product.category.name }}
                                        </td>
                                        <td class="table_desc">
                                            {{ product.price }}€
                                        </td>
                                        <td class="table_desc">
                                            {{ product.quantity }}
                                        </td>
                                        <td class="table_desc" @click="openImageModal(product.image)">
                                            <img :src="'images/products/' + product.image" alt="Product Image"
                                                 class="product-image"/>
                                        </td>
                                        <td class="table_desc text-center">
                                            {{ product.description }}
                                        </td>

                                        <td class="text-center">
                                            <button
                                                @click="showEditProductModal = true;productId=product.id"
                                                class="btn btn-primary"
                                            >
                                                <i class="mdi mdi-pencil me-1"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                @click="showDeleteProductModal = true;productId=product.id"
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
                            <div class="d-flex items-center justify-content-center p-2 mt-4">
                                <v-pagination class="" v-model="page" :pages="pageCount" :range-size="1" active-color="#DCEDFF" @update:modelValue="handleChange">

                                </v-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <create-product v-if="showModal" @close-dialog="showModal = false" @update-products="fetchData"/>
    <edit-product v-if="showEditProductModal" :product-id="productId" @update-products="fetchData"
                  @close-dialog="showEditProductModal = false"/>
    <delete-product v-if="showDeleteProductModal" :product-id="productId" @update-products="fetchData"
                    @close-dialog="showDeleteProductModal = false"/>

    <div class="modal" v-if="showImageModal" @click="closeImageModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img :src="'images/products/' + enlargedImage" alt="Enlarged Product Image" class="enlarged-image"/>
        </div>
    </div>

</template>


<script>
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import CreateProduct from "./CreateProduct.vue";
import EditProduct from "@/admin/Products/EditProduct.vue";
import DeleteProduct from "./DeleteProduct.vue";
import {ref} from "vue";
import ProductService from "@/admin/Services/ProductService";
import LoadingSpinner from "../components/LoadingSpinner.vue";
import VPagination from '@hennge/vue3-pagination'
import '@hennge/vue3-pagination/dist/vue3-pagination.css'
import Search from "@/admin/components/Search.vue";


export default {
    components: {
        Button,
        CreateProduct,
        EditProduct,
        DeleteProduct,
        InputText,
        LoadingSpinner,
        VPagination,
        Search
    },
    data() {
        return {
            products: [],
            productId: null,
            showModal: false,
            showEditProductModal: false,
            showDeleteProductModal: false,
            showImageModal: false,
            enlargedImage: '',
            isLoading: false,
            page: ref(1),
            pageCount: ref(null),
            per_page: ref(null),
            totalItems: 0
        };
    },
    methods: {
        async fetchData(text = "") {
            try {

                const response = await ProductService.getProducts(this.page, text);
                this.pageCount = response.page_count;
                this.totalItems = response.totalItems;
                this.per_page = this.totalItems / response.per_page;
                this.products = response.paginate.data;

            } catch (error) {
                console.error(error);
            }
        },
        async search(text) {
            this.page = 1;
            await this.fetchData(text)
        },
        openImageModal(image) {
            this.enlargedImage = image;
            this.showImageModal = true;
        },
        async handleChange() {
            await this.fetchData()
        },

        closeImageModal() {
            this.showImageModal = false;
        },
    },
    async mounted() {
        this.isLoading = true;
        await this.fetchData()
        this.isLoading = false;
    },




};
</script>
<style scoped>
.table th, table td {
    white-space: normal;
}

.product-image {
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

<template>
    <div class="container py-5">
        <div class="row">
            <Filter @filterByBrand="handleFilterByBrand" @filterByCategory="handleFilterByCategory" @resetFilter="handleResetFilter"></Filter>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-6 pb-4 ms-auto ">
                        <div class="d-flex">
                            <Search @text-updated="search($event)" class="w-100"></Search>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <LoadingSpinner v-if="isLoading"></LoadingSpinner>
                    <div v-else-if="filteredProducts.length === 0" class="col-md-12 my-auto mx-auto">
                        <h3 class="text-center text-black ">No products found.</h3>
                    </div>
                    <div class="col-md-4" v-for="product in filteredProducts" :key="product"
                         v-else-if="products.length >=1">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
                                <img class="card-img rounded-0 img-fluid product-image"
                                     :src="'images/products/' + product.image"/>
                                <div
                                    class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li>
                                            <router-link :to="'shop/' + product.id" class="btn btn-success text-white">
                                                <i class="mdi mdi-eye"></i>
                                            </router-link>
                                        </li>
                                        <li>
                                            <a class="btn btn-success text-white mt-2">
                                                <i class="mdi mdi-cart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <a class="h4 text-decoration-none align-self-center">{{ product.name }}</a>
                                <ul class="list-unstyled d-flex justify-content-center mb-1">
                                    <li>
                                        <i class="text-warning mdi mdi-star"></i>
                                        <i class="text-warning mdi mdi-star"></i>
                                        <i class="text-warning mdi mdi-star"></i>
                                        <i class="text-muted mdi mdi-star"></i>
                                        <i class="text-muted mdi mdi-star"></i>
                                    </li>
                                </ul>
                                <p class="text-center mb-0">{{ product.price }}€</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <ul class="pagination pagination-lg justify-content-end">
                <li class="page-item" v-for="pageNumber in pageCount" :key="pageNumber">
                    <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-black"
                       :class="{ active: pageNumber === page }"
                       href="#"
                       @click="handleChange(pageNumber)">{{ pageNumber }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

import ProductService from "../../admin/Services/ProductService";
import {ref} from 'vue'
import VPagination from '@hennge/vue3-pagination'
import '@hennge/vue3-pagination/dist/vue3-pagination.css'
import Filter from "../components/Filter.vue";
import Search from "../../admin/components/Search.vue";
import LoadingSpinner from "../../admin/components/LoadingSpinner.vue";

export default {
    components: {
        Search,
        VPagination,
        Filter,
        LoadingSpinner
    },
    data() {
        return {
            products: [],
            productId: null,
            filteredProducts: [],
            page: ref(1),
            pageCount: ref(null),
            per_page: ref(null),
            totalItems: 0,
            isLoading: false
        }
    },
    methods: {
        async fetchData(text = '') {
            try {
                const response = await ProductService.getProducts(this.page, text);
                this.pageCount = response.page_count;
                this.totalItems = response.totalItems;
                this.per_page = this.totalItems / response.per_page;
                this.products = response.paginate.data;
                this.filteredProducts = response.paginate.data;
                this.activeFilter = null;
            } catch (error) {
                console.error(error)
            }
        },
        async search(text) {
            this.page = 1;
            await this.fetchData(text)
        },
        async handleChange(newPage) {
            this.page = Math.min(newPage, this.pageCount);
            await this.fetchData();
        },
        handleFilterByBrand(brand) {
            this.filteredProducts = this.products.filter(product => product.brand.id === brand.id);

            this.pageCount = Math.min(this.page, this.pageCount);
            this.page = 1;
        },
        handleFilterByCategory(category) {
            this.filteredProducts = this.products.filter(product => product.category.id === category.id);
            this.pageCount = Math.min(this.page, this.pageCount);
            this.page = 1;
        },
        handleResetFilter() {
            this.isLoading = true;
            this.page = 1;
            this.fetchData();
            this.isLoading = false;
        },

    },
    async mounted() {
        this.isLoading = true;
        await this.fetchData();
        this.isLoading = false;
    }
}
</script>


<style scoped>
LoadingSpinner {
    margin: 0 auto;
}
</style>

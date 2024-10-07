<template>
    <LoadingSpinner v-if="isLoading"></LoadingSpinner>
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel" v-else>
        <ol class="carousel-indicators">
            <li v-for="(product, index) in latestProducts" :key="product.id" :data-bs-target="'#template-mo-zay-hero-carousel'" :data-bs-slide-to="index" :class="{ active: index === 0 }"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item" v-for="(product, index) in latestProducts" :key="product.id" :class="{ active: index === 0 }" >
                <div class="container">
                    <div class="row p-5" >
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last product-select" @click="sendToItem(product.id)">
                            <img class="img-fluid" :src="'images/products/' + product.image" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                <h1 class="h1 text-success product-select" @click="sendToItem(product.id)">{{ product.name }}</h1>

                                <p>{{ product.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel"
           role="button" data-bs-slide="prev">
            <i class="mdi mdi-arrow-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel"
           role="button" data-bs-slide="next">
            <i class="mdi mdi-arrow-right"></i>
        </a>
    </div>

    <CategoriesOfTheMonth></CategoriesOfTheMonth>
</template>

<script>
import ProductService from "../admin/Services/ProductService";
import LoadingSpinner from "../admin/components/LoadingSpinner.vue";
import CategoriesOfTheMonth from "@/client/layouts/BestCategories.vue";

export default {
    components: {
        CategoriesOfTheMonth,
        LoadingSpinner
    },
    data() {
        return {
            products: [],
            latestProducts: [],
            isLoading: false
        }
    },
    methods: {
        async fetchProducts() {
            this.isLoading = true;
            const response = await ProductService.getProducts();
            this.products = response.paginate.data;
            this.GetLatestProducts();
            this.isLoading = false;
        },
        GetLatestProducts() {
            this.latestProducts = this.products.slice(0, 2);
        },
        sendToItem(id) {
            this.$router.push(`/shop/${id}`)
        }

    },

    mounted() {

        this.fetchProducts()
        this.GetLatestProducts()

    }
}
</script>


<style scoped>
    .product-select {
        cursor: pointer;
    }
</style>

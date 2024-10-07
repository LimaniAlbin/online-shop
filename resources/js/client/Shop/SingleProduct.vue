<template>
    <LoadingSpinner v-if="isLoading"></LoadingSpinner>
    <section class="bg-light" v-else>
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img rounded-0 img-fluid product-image"
                             :src="'../images/products/' + product.image"/>
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2">{{ product.name }}</h1>
                            <p class="h3 py-2">{{ product.price }}€</p>
                            <p class="py-2">
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <span class="list-inline-item text-dark">Rating 4.8</span>
                            </p>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h5>Brand:</h5>
                                </li>
                                <li class="list-inline-item">
                                    <p class="">{{ brands.name }}<strong></strong></p>
                                </li>
                            </ul>

                            <h5>Description:</h5>
                            <p>{{ product.description }}</p>

                            <form action="" method="GET">
                                <input type="hidden" name="product-title" value="Activewear">
                                <div class="row">
                                    <div class="col-auto">
                                        <ul class="list-inline pb-3">
                                            <li class="list-inline-item text-right">
                                                Quantity
                                                <input type="hidden" name="product-quanity" id="product-quanity"
                                                       value="1">
                                            </li>
                                            <li class="list-item">
                                                <p class="lead">Items in stock: {{ product.quantity }}</p>
                                            </li>
                                            <li class="list-inline-item"><span class="btn btn-success" id="btn-minus"
                                                                               @click="subtractQuantity">-</span></li>
                                            <li class="list-inline-item"><span class="badge bg-secondary"
                                                                               id="var-value">{{
                                                    productsChosen
                                                }}</span></li>
                                            <li class="list-inline-item"><span class="btn btn-success" id="btn-plus"
                                                                               @click="addQuantity">+</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col d-grid">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">
                                            Buy
                                        </button>
                                    </div>
                                    <div class="col d-grid">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit"
                                                value="addtocard">Add To Cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ProductService from "../../admin/Services/ProductService";
import BrandService from "../../admin/Services/BrandService";
import LoadingSpinner from "../../admin/components/LoadingSpinner.vue";

export default {
    props: ['id'],
    components: {
        LoadingSpinner
    },
    data() {
        return {
            product: {},
            brands: {
                name
            },
            productsChosen: 1,
            isLoading: false
        }

    },
    methods: {
        async getProductById() {
            this.isLoading = true;
            this.product = await ProductService.getProductById(this.id)
            this.isLoading = false;
        },
        async getBrands() {
            this.isLoading = true;
            this.brands = await BrandService.getBrands();
            const brands = this.brands.find((brand) => brand.id === this.product.brand_id)
            this.brands.name = brands.name
            this.isLoading = false;

        },
        addQuantity() {
            if (this.productsChosen < this.product.quantity) {
                this.productsChosen++;
            }
        },
        subtractQuantity() {
            if (this.productsChosen > 1) {
                this.productsChosen--;
            }
        }
    },
    mounted() {
        this.getProductById();
        this.getBrands();

    }
}
</script>


<style scoped>

</style>

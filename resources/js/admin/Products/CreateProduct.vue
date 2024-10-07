<template>
    <loading-spinner v-if="isLoading"></loading-spinner>
    <base-dialog v-else
                 title="Create Product"
                 actionDescription="Add a new Product"
                 @handle-submit="createProduct(!v$.$invalid)"
                 @close="closeDialog"
                 :approve-submit="v$.$invalid"
    >

        <div class="form-group col">
            <validation-input label="Name" :input-value="product.name" message="Name can not be empty"
                              @has-errors="product.name = $event"></validation-input>
        </div>
        <div class="form-group col">
            <label for="create_product_brand">Brand</label>
            <div class="card p-fluid">
                <Dropdown
                    v-model="selectedBrand"
                    :options="brands"
                    optionLabel="name"
                    placeholder="Select a Brand"
                    class="w-full md:w-14rem"
                />
            </div>
        </div>

        <div class="form-group col">
            <label for="create_product_brand">Category</label>
            <div class="card p-fluid">
                <Dropdown
                    v-model="selectedCategory"
                    :options="categories"
                    optionLabel="name"
                    placeholder="Select a Category"
                    class="w-full md:w-14rem"
                />
            </div>
        </div>

        <div class="form-group col">
            <label for="create_product_price">Price</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="create_product_price"
                v-model="product.price"
            />
        </div>
        <div class="form-group col">
            <label for="create_product_quantity">Quantity</label>
            <input
                type="number"
                class="form-control form-control-lg"
                id="create_product_quantity"
                v-model="product.quantity"
                min="0"
            />
        </div>
        <div class="form-group col">
            <label for="create_product_image" class="form-label">Image</label>
            <input type="file" id="create_product_image" @change="handleImageChange" accept="image/*" class="form-control form-control-lg"/>
            <img v-if="imagePreview" :src="imagePreview" alt="Selected Image" class="selected-image" @click="showModal = true" />
        </div>



            <div class="form-group col">
                <label for="create_product_description">Description</label>
                <input
                    type="text"
                    class="form-control form-control-lg"
                    id="create_product_description"
                    v-model="product.description"
                />
            </div>


        <transition name="modal">
            <div class="modal" v-if="showModal" @click="showModal = false">
                <div class="modal-content" @click.stop>
                    <img :src="imagePreview" alt="Selected Image" class="enlarged-image" />
                </div>
            </div>
        </transition>
    </base-dialog>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import ProductService from "../Services/ProductService";
import BrandService from "../Services/BrandService";
import Dropdown from 'primevue/dropdown';
import LoadingSpinner from "../components/LoadingSpinner.vue";
import ValidationInput from "@/admin/components/ValidationInput.vue";
import { useVuelidate } from '@vuelidate/core'
import CategoryService from "@/admin/Services/CategoryService";

export default {
    components: {
        ValidationInput,
        BaseDialog,
        Dropdown,
        LoadingSpinner
    },
    props: {
        showModal: {
            type: Boolean,
            default: false
        }
    },
    setup() {
        return { v$: useVuelidate() }
    },
    emits: ['close-dialog', 'update-products'],
    data() {
        return {
            product: {
                image: null
            },
            brands: {},
            categories: {},
            selectedBrand: null,
            selectedCategory: null,
            isLoading: false,
            imagePreview: null,
            showModal: false
        };
    },
    methods: {
        async createProduct(isFormValid) {
            if (!isFormValid) {
                return;
            }
            this.isLoading = true;
            const formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('brand_id', this.selectedBrand ? this.selectedBrand.id : null);
            formData.append('category_id', this.selectedCategory ? this.selectedCategory.id : null)
            formData.append('price', this.product.price);
            formData.append('quantity', this.product.quantity)
            formData.append('description', this.product.description);
            formData.append('image', this.product.image);

            await ProductService.addProducts(formData);
            this.isLoading = false;
            this.$emit('update-products');
            this.$emit('close-dialog');
            this.isLoading = false;
        },
        handleImageChange(event) {
            const file = event.target.files[0];
            this.product.image = file;
            this.imagePreview = URL.createObjectURL(file);
        },
        closeDialog() {
            this.$emit('close-dialog');
        }
    },
    async mounted() {

        try {
            this.brands = await BrandService.getBrands();
        } catch (error) {
            console.error(error);
        }
        try {
            this.categories = await CategoryService.getCategories();
            console.log(this.categories)
        } catch (error) {
            console.error(error);
        }
    }
};
</script>

<style scoped>
.selected-image {
    display: block;
    width: 200px;
    height: auto;
    margin-top: 10px;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal-content {
    max-width: 90%;
    max-height: 90%;
    overflow: auto;
    background-color: #fff;
    padding: 20px;
    text-align: center;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.enlarged-image {
    display: block;
    max-width: 100%;
    max-height: 100%;
    margin: 0 auto;
}
</style>

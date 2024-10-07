<template>
    <base-dialog
        v-if="!isLoading && brands.length"
        title="Edit Product"
        actionDescription="Edit"
        @handle-submit="editProduct"
        @close="closeDialog"
    >

        <div class="form-group col">
            <label for="create_product_name">Name</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="create_product_name"
                v-model="product.name"
            />
        </div>
        <div class="form-group col">
            <label for="create_product_brand">Brand</label>
            <div class="card p-fluid">
                <Dropdown
                    v-model="product.brand_id"
                    :options="brands"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="Select a Brand"
                    class="w-full md:w-14rem"
                />
            </div>
        </div>
        <div class="form-group col">
            <label for="create_product_category">Category</label>
            <div class="card p-fluid">
                <Dropdown
                    v-model="product.category_id"
                    :options="categories"
                    optionLabel="name"
                    optionValue="id"
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
                min="1"
            />
        </div>

        <div class="form-group col">
            <div class="form-group col current-image-container">
                <label>Current Image</label>
                <img v-if="product.imagePreview || product.image"
                     :src="product.imagePreview || '/images/products/' + product.image" alt="Current Image" class="current-image"
                     @click="showModal = true"/>
            </div>
            <input type="file" id="edit_product_image" @change="handleImageChange" accept="image/*" class="form-control form-control-lg"/>
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
                    <img :src="product.imagePreview" alt="Selected Image" class="enlarged-image"/>
                </div>
            </div>
        </transition>


    </base-dialog>
    <div>
    </div>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import ProductService from "../Services/ProductService";
import BrandService from "../Services/BrandService";
import Dropdown from 'primevue/dropdown';
import CategoryService from "@/admin/Services/CategoryService";

export default {
    components: {
        BaseDialog,
        Dropdown
    },
    props: [
        'productId'
    ],
    emits: ['close-dialog', 'update-products'],
    data() {
        return {
            product: {
                image: null,
                imagePreview: null
            },
            brands: {},
            categories: {},
            selectedBrand: null,
            selectedCategory: null,
            isLoading: false,
            showModal: false,
            isImageChanged: false,
        };
    },
    methods: {
        async getProductById() {
            try {
                this.product = await ProductService.getProductById(this.productId);
                this.product.imagePreview = this.product.image;
            } catch (error) {
                console.error(error);
            }
        },
        async fetchBrands() {
            try {
                this.brands = await BrandService.getBrands();
            } catch (error) {
                console.error(error);
            }
        },
        async fetchCategories() {
            try {
                this.categories = await CategoryService.getCategories();
            } catch (error) {
                console.error(error);
            }
        },
        async editProduct() {
            try {
                const formData = new FormData();
                formData.append('name', this.product.name);
                formData.append('brand_id', this.product.brand_id);
                formData.append('category_id', this.product.category_id);
                formData.append('price', this.product.price);
                formData.append('quantity', this.product.quantity);
                formData.append('description', this.product.description);
                if (this.isImageChanged) {
                    formData.append('image', this.product.image);
                }

                await ProductService.editProduct(formData, this.productId);
                this.$emit('update-products');
                this.closeDialog();
            } catch (error) {
                console.error(error);
            }
        },

        handleImageChange(event) {
            const file = event.target.files[0];
            this.product.image = file;
            this.product.imagePreview = URL.createObjectURL(file);
            this.isImageChanged = true;
        },
        closeDialog() {
            this.$emit('close-dialog');
        }
    },
    async mounted() {
        try {
            const productData = await ProductService.getProductById(this.productId);
            await this.fetchBrands();
            await this.fetchCategories();
            this.product = productData;
            this.product.imagePreview = '/images/products/' + this.product.image;
            this.isImageChanged = false;

        } catch (error) {
            console.error(error);
        }
    }
};
</script>

<style scoped>

.current-image-container {
    width: 100%;
    height: auto;
    max-width: 100%;
    max-height: 200px;
    overflow: hidden;
}

.current-image {
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


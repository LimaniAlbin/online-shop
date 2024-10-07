<template>
    <base-dialog
        v-if="!isLoading"
        title="Edit Category"
        actionDescription="Edit"
        @handle-submit="editCategory"
        @close="closeDialog"
    >

        <div class="form-group col">
            <label for="create_brand_name">Name</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="create_category_name"
                v-model="category.name"
            />
        </div>

        <div class="form-group col">
            <div class="form-group col current-image-container">
                <label>Current Image</label>
                <img v-if="category.imagePreview || category.image"
                     :src="category.imagePreview || '/images/categories/' + category.image" alt="Current Image"
                     class="current-image"
                     @click="showModal = true"/>
            </div>
            <input type="file" id="edit_category_image" @change="handleImageChange" accept="image/*"
                   class="form-control form-control-lg"/>
        </div>

        <transition name="modal">
            <div class="modal" v-if="showModal" @click="showModal = false">
                <div class="modal-content" @click.stop>
                    <img :src="category.imagePreview" alt="Selected Image" class="enlarged-image"/>
                </div>
            </div>
        </transition>
    </base-dialog>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import Dropdown from 'primevue/dropdown';
import CategoryService from "@/admin/Services/CategoryService";
import ProductService from "@/admin/Services/ProductService";

export default {
    components: {
        BaseDialog,
        Dropdown
    },
    props: [
        'categoryId'
    ],
    emits: ['close-dialog', 'update-categories'],
    data() {
        return {
            category: {
                image: null,
                imagePreview: null
            },
            isLoading: false,
            showModal: false,
            isImageChanged: false,
        };
    },
    methods: {
        async getCategoryById() {
            try {
                this.category = await CategoryService.getCategoryById(this.categoryId)
                this.category.imagePreview = this.category.image;

            } catch (error) {
                console.error(error);
            }
        },
        async editCategory() {
            try {
                const formData = new FormData();
                formData.append('name', this.category.name)
                if (this.isImageChanged) {
                    formData.append('image', this.category.image);
                }
                await CategoryService.editCategory(formData, this.categoryId)
                this.$emit('update-categories');
                this.closeDialog()
            } catch (error) {
                console.error(error)
            }

        },
        handleImageChange(event) {
            const file = event.target.files[0];
            this.category.image = file;
            this.category.imagePreview = URL.createObjectURL(file);
            this.isImageChanged = true;
        },
        closeDialog() {
            this.$emit('close-dialog');
        }
    },
    async mounted() {
        try {
            this.category = await CategoryService.getCategoryById(this.categoryId);
            this.category.imagePreview = '/images/categories/' + this.category.image;
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

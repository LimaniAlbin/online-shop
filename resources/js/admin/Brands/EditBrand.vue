<template>
    <base-dialog
        v-if="!isLoading"
        title="Edit Brand"
        actionDescription="Edit"
        @handle-submit="editBrand"
        @close="closeDialog"
    >

        <div class="form-group col">
            <label for="create_brand_name">Name</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="create_brand_name"
                v-model="brand.name"
            />
        </div>
        <div class="form-group col">
            <div class="form-group col current-image-container">
                <label>Current Image</label>
                <img v-if="brand.imagePreview || brand.logo"
                     :src="brand.imagePreview || '/logos/' + brand.logo" alt="Current Image"
                     class="current-image"
                     @click="showModal = true"/>
            </div>
            <input type="file" id="edit_brand_image" @change="handleImageChange" accept="image/*"
                   class="form-control form-control-lg"/>
        </div>

        <transition name="modal">
            <div class="modal" v-if="showModal" @click="showModal = false">
                <div class="modal-content" @click.stop>
                    <img :src="brand.imagePreview" alt="Selected Image" class="enlarged-image"/>
                </div>
            </div>
        </transition>


    </base-dialog>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";

import BrandService from "../Services/BrandService";
import Dropdown from 'primevue/dropdown';
import brandService from "../Services/BrandService";

export default {
    components: {
        BaseDialog,
        Dropdown
    },
    props: [
        'brandId'
    ],
    emits: ['close-dialog', 'update-brands'],
    data() {
        return {
            brand: {
                logo: null,
                imagePreview: null
            },
            isLoading: false,
            showModal: false,
        };
    },
    methods: {
        async editBrand() {
            try {
                const formData = new FormData();
                formData.append('name', this.brand.name);
                if (this.isImageChanged) {
                    formData.append('logo', this.brand.logo);
                }
                await BrandService.editBrand(formData, this.brandId)
                this.$emit('update-brands');
                this.closeDialog()
            } catch (error) {
                console.error(error);
            }
        },
        handleImageChange(event) {
            const file = event.target.files[0];
            this.brand.logo = file;
            this.brand.imagePreview = URL.createObjectURL(file);
            this.isImageChanged = true;
        },
        closeDialog() {
            this.$emit('close-dialog');
        }
    },
    async mounted() {
        this.brand = await BrandService.getBrandById(this.brandId);
        this.brand.imagePreview = 'logos/' + this.brand.logo;
        this.isImageChanged = false;
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

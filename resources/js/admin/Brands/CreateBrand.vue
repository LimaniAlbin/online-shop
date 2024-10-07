<template>
    <base-dialog
        title="Create Brand"
        actionDescription="Add a new Brand"
        @handle-submit="createBrand"
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
            <label for="create_brand_logo" class="form-label">Logo</label>
            <input type="file" id="create_brand_logo" @change="handleImageChange" accept="image/*" class="form-control form-control-lg"/>
            <img v-if="imagePreview" :src="imagePreview" alt="Selected Image" class="selected-image" @click="showModal = true" />
        </div>

        <div class="form-check form-check-flat form-check-primary"></div>

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
import BrandService from "../Services/BrandService";
import Dropdown from 'primevue/dropdown';

export default {
    components: {
        BaseDialog,
        Dropdown
    },
    props: {
        showModal: {
            type: Boolean,
            default: false
        }
    },
    emits: ['close-dialog', 'update-brands'],
    data() {
        return {
            brand: {
                logo: null
            },
            showModal: false,
            imagePreview: null,
            isLoading: false,
        };
    },
    methods: {
        async createBrand() {
            try {
                this.isLoading= true;

                const formData = new FormData()
                formData.append('name', this.brand.name);
                formData.append('logo', this.brand.logo);

                await BrandService.addBrand(formData)

                this.isLoading = false;

                this.$emit('update-brands');
                this.$emit('close-dialog');
            } catch (error) {
                console.error(error)
            }
        }, handleImageChange(event) {
            const file = event.target.files[0];
            this.brand.logo = file;
            this.imagePreview = URL.createObjectURL(file);
        },
        closeDialog() {
            this.$emit('close-dialog');
        }
    }
};
</script>

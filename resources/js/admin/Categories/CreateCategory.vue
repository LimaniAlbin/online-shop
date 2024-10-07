<template>
    <base-dialog
        title="Create Category"
        actionDescription="Add a new Category"
        @handle-submit="createCategory"
        @close="closeDialog"
    >

        <div class="form-group col">
            <label for="create_category_name">Name</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="create_category_name"
                v-model="category.name"
            />
        </div>

        <div class="form-group col">
            <label for="create_category_image" class="form-label">Image</label>
            <input type="file" id="create_category_image" @change="handleImageChange" accept="image/*" class="form-control form-control-lg"/>
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
import CategoryService from "../../admin/Services/CategoryService";
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
    emits: ['close-dialog', 'update-categories'],
    data() {
        return {
            category: {
                image: null
            },
            isLoading: false,
            imagePreview: null,
            showModal: false
        };
    },
    methods: {
        async createCategory() {
            try {
                this.isLoading = true
                const formData = new FormData()
                formData.append('name', this.category.name);
                formData.append('image', this.category.image)
                await CategoryService.addCategory(formData)
                this.isLoading = false;
                this.$emit('update-categories');
                this.$emit('close-dialog');
            } catch (error) {
                console.error(error)
            }
        },
        handleImageChange(event) {
            const file = event.target.files[0];
            this.category.image = file;
            this.imagePreview = URL.createObjectURL(file);
        },
        closeDialog() {
            this.$emit('close-dialog');
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

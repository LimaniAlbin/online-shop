<template>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <loading-spinner v-if="isLoading"/>
                    <div class="card" v-else>
                        <div class="card-body">
                            <h4 class="card-title">Brands</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <button
                                    @click="showModal = true"
                                    class="btn btn-primary"
                                    style="margin: 20px 0"
                                >
                                    <i class="mdi mdi-plus text-white"></i>
                                    Add New Brand
                                </button>

                            </div>
                            <div class="table-responsive rounded rounded-2 ">
                                <table
                                    class="table rounded rounded-2 overflow-hidden table-hover table-striped table-bordered align-middle mb-0 bg-white">
                                    <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Name</th>
                                        <th>Logo</th>
                                        <th class="text-center w-25" colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="brand in brands"
                                        :key="brand.id"
                                    >
                                        <td>
                                            {{ brand.name }}
                                        </td>

                                        <td class="table_desc" @click="openImageModal(brand.logo)">
                                            <img :src="'logos/' + brand.logo" alt="Brand Logo"
                                                 class="brand-image"/>
                                        </td>

                                        <td class="text-center">
                                            <button
                                                @click="showEditBrandModal = true;brandId=brand.id"
                                                class="btn btn-primary"
                                            >
                                                <i class="mdi mdi-pencil me-1"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                @click="showDeleteBrandModal = true;brandId=brand.id"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" v-if="showImageModal" @click="closeImageModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img :src="'logos/' + enlargedImage" alt="Enlarged Category Image" class="enlarged-image"/>
        </div>
    </div>

    <create-brand v-if="showModal" @close-dialog="showModal = false" @update-brands="fetchData"/>
    <edit-brand v-if="showEditBrandModal" :brand-id="brandId" @update-brands="fetchData"
                @close-dialog="showEditBrandModal = false"/>
    <delete-brand v-if="showDeleteBrandModal" :brand-id="brandId" @update-brands="fetchData"
                  @close-dialog="showDeleteBrandModal = false"/>

</template>


<script>
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import CreateBrand from "./CreateBrand.vue";
import EditBrand from "./EditBrand.vue";
import DeleteBrand from "./DeleteBrand.vue";
import BrandService from "../Services/BrandService";
import LoadingSpinner from "../components/LoadingSpinner.vue";


export default {
    components: {
        Button,
        CreateBrand,
        EditBrand,
        DeleteBrand,
        InputText,
        LoadingSpinner
    },
    data() {
        return {
            brands: [],
            brandId: null,
            showModal: false,
            showEditBrandModal: false,
            showDeleteBrandModal: false,
            isLoading: false,
            showImageModal: false,
            enlargedImage: ''
        };
    },
    methods: {
        async fetchData() {
            try {
                this.isLoading = true;
                this.brands = await BrandService.getBrands();
                this.isLoading = false;
            } catch (error) {
                console.error(error);
            }
        },
        openImageModal(image) {
            this.enlargedImage = image;
            this.showImageModal = true;
        },
        closeImageModal() {
            this.showImageModal = false;
        },
    },

    async mounted() {
        await this.fetchData()
    }


};
</script>
<style scoped>
.table th, table td {
    white-space: normal;
}

.brand-image {
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
    max-width: 60%;
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
    height: 150px;
    max-width: 80%;
    max-height: 80%;
}

</style>


<template>
    <div class="col-lg-3">
        <ul class="list-group">
            <li class="list-group-item list-all mb-1" @click="resetFilter">All</li>
        </ul>
        <Accordion>
            <AccordionTab class="list-group" header="Brands">
                <li class="list-group-item" v-for="brand in brands" :key="brand.name" @click="filterByBrand(brand)"
                    :class="{ 'active': brand === activeFilter }">
                    <img class="brand-logo" :src="'logos/' + brand.logo" alt="Brand Logo" /> {{ brand.name }}
                </li>
            </AccordionTab>
        </Accordion>

        <Accordion>
            <AccordionTab class="list-group" header="Categories">
                <li class="list-group-item" v-for="category in categories" :key="category.name" @click="filterByCategory(category)"
                    :class="{ 'active': category === activeFilter }">
                    <img class="brand-logo" :src="'/images/categories/' + category.image" alt="Brand Logo" /> {{ category.name }}
                </li>
            </AccordionTab>
        </Accordion>

    </div>
</template>

<script>
import BrandService from '../../admin/Services/BrandService'
import Accordion from 'primevue/accordion'
import AccordionTab from 'primevue/accordiontab';
import CategoryService from "@/admin/Services/CategoryService";

export default {
    components: {
        Accordion,
        AccordionTab
    },
    data() {
        return {
            brands: [],
            categories: [],
            activeFilter: null
        };
    },
    methods: {
        async fetchData() {
            this.brands = await BrandService.getBrands();
            this.categories = await CategoryService.getCategories()
        },
        filterByBrand(brand) {
            this.activeFilter = brand;
            this.$emit('filterByBrand', brand);
        },
        filterByCategory(category) {
            this.activeFilter = category;
            this.$emit('filterByCategory', category)
        },
        resetFilter() {
            this.activeFilter = null;
            this.$emit('resetFilter');
        },
    },
    async mounted() {
        await this.fetchData()
    }
};
</script>


<style scoped>
.active {
    background-color: #69bb7e;
    border-color: #69bb7e;
    font-weight: bold;
}

.list-all {
    padding: 1rem;
    background-color: #f8f9fa;
    color: #6c757d;
    border-radius: 6px;
    cursor: pointer;
}



.list-all:hover {
    background-color: #f1f1f1;
}

.brand-logo {
    display: inline-block;
    width: 2.5rem; /* Adjust the width as needed */
    height: 1.9rem; /* Adjust the height as needed */
    margin-right: 5px; /* Adjust the spacing between the logo and brand name */
}
</style>

<template>
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Best Categories</h1>
                <p>
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 p-5 mt-3" v-for="category in chosenCategories" :key="category.id">
                <img :src="'images/categories/' + category.image" class="rounded-circle img-fluid border">
                <h5 class="text-center mt-3 mb-3">{{ category.name }}</h5>
<!--                <p class="text-center"><a class="btn btn-success">Go Shop</a></p>-->
            </div>
        </div>
    </section>
    <!-- End Categories of The Month -->
</template>

<script>
    import CategoryService from "@/admin/Services/CategoryService";

    export default {
        data() {
            return {
                categories: [],
                chosenCategories: []
            }
        },
        methods: {
            async getCategories() {
                this.categories = await CategoryService.getCategories();
                this.chosenCategories = this.categories.filter(category => category.name === "Laptop" || category.name === "Mouse1");
                console.log(this.chosenCategories)
            }
        },
        mounted() {
            this.getCategories()
        }
    }
</script>

<style scoped>

</style>

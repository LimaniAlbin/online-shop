<template>
    <TheTopBar></TheTopBar>
    <TheNavbar></TheNavbar>
    <router-view></router-view>
    <TheFooter></TheFooter>
</template>

<script>
import TheNavbar from "./layouts/TheNavbar.vue";
import TheTopBar from "./layouts/TheTopBar.vue";
import TheFooter from "./layouts/TheFooter.vue";

export default {
    name: 'Home',
    components: {
        TheFooter,
        TheTopBar,
        TheNavbar
    }
}
</script>

<style scoped>

</style>

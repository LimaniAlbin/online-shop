

<template>
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="index.html">
                Zay
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">About</a>
                        </li>
                        <li class="nav-item">
                            <router-link to="/shop" class="nav-link">Shop</router-link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar align-self-center d-flex">

                    <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                        <i class="fa fa-fw fa-search text-dark mr-2"></i>
                    </a>
                    <a class="nav-icon position-relative text-decoration-none" href="#">
                        <i class="mdi mdi-cart text-dark me-1"></i>
                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">7</span>
                    </a>
<!--                    <a class="nav-icon position-relative text-decoration-none" href="#">-->
<!--                        <i class="mdi mdi-account me-3"></i>-->
<!--                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">+99</span>-->
<!--                    </a>-->
                    <div v-if="username">
                        <p>Welcome, {{ username }}</p>
                        <button @click="logout" class="btn-danger ms-4 position-relative text-decoration-none">Logout</button>
                    </div>
                    <div v-else>
                        <button class="btn btn-primary ms-4 position-relative text-decoration-none" @click="goToLoginForm">
                            Login
                        </button>
                        <button class="btn btn-info ms-4 position-relative text-decoration-none text-white" @click="goToRegisterForm">
                            Register
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </nav>
</template>

<script>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import {useRouter} from 'vue-router';

export default {
    setup() {
        const router = useRouter();
        const username = ref('');

        onMounted(async () => {

            await fetchUserProfile();
        });

        const fetchUserProfile = async () => {
            try {
                const response = await axios.get('/api/auth/user-profile', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,

                    },
                });
                if (response.status === 200) {
                    const user = response.data;
                    username.value = user.name;
                } else {

                    console.error('Failed to retrieve user profile');
                }
            } catch (error) {

                console.error(error);
            }
        };

        const logout = () => {

            localStorage.removeItem('token');
            localStorage.removeItem('userRole');

            window.location.reload();
            router.push({path: '/'});

        };
        const goToLoginForm = () => {

            router.push({path: '/login'});
        };

        const goToRegisterForm = () => {
            router.push({path: '/register'});
        };



        return {
            username,
            logout,
            goToLoginForm,
            goToRegisterForm
        };
    },
};
</script>

<style scoped>

</style>

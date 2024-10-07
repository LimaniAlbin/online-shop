<template>
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            <div class="me-3">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
            </div>
            <div>
                <router-link to="/" class="navbar-brand brand-logo" href="index.html">
                    <img src="#" alt="logo"/>
                </router-link>
                <a class="navbar-brand brand-logo-mini" href="index.html">
                    <img src="admin/images/logo-mini.svg" alt="logo"/>
                </a>
            </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
            <ul class="navbar-nav">
                <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                    <h1 class="welcome-text text-black">Admin Dashboard</h1>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <div v-if="username" >
                        <p>Welcome, {{ username }}</p>
                        <button @click="logout" class="btn btn-danger">Logout</button>
                    </div>
                    <div v-else>
                        <button @click="goToLoginForm" class="btn btn-primary">Login</button>
                        <button @click="goToRegisterForm" class="btn btn-info ms-3">Register</button>
                    </div>
                </li>
            </ul>


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
            // Fetch user profile data on component mount
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
                    // Handle error
                    console.error('Failed to retrieve user profile');
                }
            } catch (error) {
                // Handle error
                console.error(error);
            }
        };

        const logout = () => {
            localStorage.removeItem('token');
            localStorage.removeItem('userRole');


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

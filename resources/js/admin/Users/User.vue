<template>
    <loading-spinner v-if="isLoading"></loading-spinner>
    <div class="main-panel" v-else>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <loading-spinner v-if="isLoading" />
                    <div class="card" v-else>
                        <div class="card-body">
                            <h4 class="card-title">Users</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <button
                                    @click="showModal = true"
                                    class="btn btn-primary"
                                    style="margin: 20px 0"
                                >
                                    <i class="mdi mdi-plus text-white"></i>
                                    Add New User
                                </button>
                            </div>
                            <div class="table-responsive rounded rounded-2">
                                <table
                                    class="table rounded rounded-2 overflow-hidden table-hover table-striped table-bordered align-middle mb-0 bg-white"
                                >
                                    <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Role</th>
                                        <th class="text-center" colspan="2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.password }}</td>
                                        <td>{{ user.role }}</td>
                                        <td class="text-center">
                                            <button
                                                @click="showEditUserModal = true; userId = user.id"
                                                class="btn btn-primary"
                                            >
                                                <i class="mdi mdi-pencil me-1"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                @click="showDeleteUserModal = true; userId = user.id"
                                                class="btn btn-danger"
                                            >
                                                <i class="mdi mdi-trash-can me-1"></i>
                                            </button>
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

    <create-user
        v-if="showModal"
        @close-dialog="showModal = false"
        @update-users="fetchData"
    />
    <edit-user
        v-if="showEditUserModal"
        :user-id="userId"
        @update-users="fetchData"
        @close-dialog="showEditUserModal = false"
    />
    <delete-user
        v-if="showDeleteUserModal"
        :user-id="userId"
        @update-users="fetchData"
        @close-dialog="showDeleteUserModal = false"
    />
</template>

<script>
import CreateUser from "./CreateUser.vue";
import EditUser from "./EditUser.vue";
import DeleteUser from "./DeleteUser.vue";
import { ref } from "vue";
import UserService from "../Services/UserService";
import LoadingSpinner from "../components/LoadingSpinner.vue";

export default {
    components: {
        CreateUser,
        EditUser,
        DeleteUser,
        LoadingSpinner,
    },
    data() {
        return {
            users: [],
            userId: null,
            showModal: false,
            showEditUserModal: false,
            showDeleteUserModal: false,
            isLoading: false,
        };
    },
    methods: {
        async fetchData() {
            try {
                this.isLoading = true;
                this.users = await UserService.getUsers();
                this.isLoading = false;
            } catch (error) {
                console.error(error);
            }
        },
    },
    async mounted() {
        await this.fetchData();
    },
};
</script>

<style scoped>
.table th,
table td {
    white-space: normal;
}
</style>

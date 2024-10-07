<template>
    <base-dialog
        v-if="!isLoading"
        :title="user.firstname + ' ' + user.lastname"
        @handle-submit="deleteUser"
        @close="closeDialog"
    >
        <div class="form-group d-flex my-3">
            <i class="mdi mdi-table-question text-danger"></i>
            <div class="ms-5 my-auto">
                <h5>Are you sure you want to delete this User?</h5>
                <h5>This action cannot be undone.</h5>
            </div>
        </div>
    </base-dialog>
    <div></div>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import UserService from "@/admin/Services/UserService";

export default {
    components: {
        BaseDialog,
    },
    props: ["userId"],
    emits: ["close-dialog", "update-users"],
    data() {
        return {
            user: {},
            isLoading: false,
        };
    },
    methods: {
        async deleteUser() {
            try {
                await UserService.deleteUser(this.userId);
                this.$emit("close-dialog");
                this.$emit("update-users");
            } catch (error) {
                console.error(error);
            }
        },
        closeDialog() {
            this.$emit("close-dialog");
        },
        async getUser() {
            try {
                this.user = await UserService.getUserById(this.userId);
            } catch (error) {
                console.error(error);
            }
        },
    },

};
</script>

<style scoped>
.fa-sharp {
    font-size: 50px;
    color: red;
}
.p-d-flex {
    display: flex;
}
.p-d-flex div {
    margin-left: 15px;
}
</style>

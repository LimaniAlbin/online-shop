<template>
    <base-dialog
        v-if="!isLoading && user"
        title="Edit User"
        actionDescription="Edit"
        @handle-submit="editUser"
        @close="closeDialog"
    >
        <div class="form-group col">
            <label for="edit_user_name">Name</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="edit_user_name"
                v-model="user.name"
            />
        </div>
        <div class="form-group col">
            <label for="edit_user_email">Email</label>
            <input
                type="email"
                class="form-control form-control-lg"
                id="edit_user_email"
                v-model="user.email"
            />
        </div>
        <div class="form-group col">
            <label for="edit_user_role">Role</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="edit_user_role"
                v-model="user.role"
            />
        </div>
    </base-dialog>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import UserService from "../Services/UserService";

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
        async getUserById() {
            try {
                this.user = await UserService.getUserById(this.userId);
            } catch (error) {
                console.error(error);
            }
        },
        async editUser() {
            try {
                await UserService.editUser(this.user, this.userId);
                this.$emit("update-users");
                this.closeDialog();
            } catch (error) {
                console.error(error);
            }
        },
        closeDialog() {
            this.$emit("close-dialog");
        },
    },
    async mounted() {
        await this.getUserById();
    },
};
</script>

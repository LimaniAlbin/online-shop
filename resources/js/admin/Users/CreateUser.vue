<template>
    <loading-spinner v-if="isLoading"></loading-spinner>
    <base-dialog
        v-else
        title="Create User"
        actionDescription="Add a new User"
        @handle-submit="createUser(!v$.$invalid)"
        @close="closeDialog"
        :approve-submit="v$.$invalid"
    >
        <div class="form-group">
            <validation-input
                label="Name"
                :input-value="user.name"
                message="Name cannot be empty"
                @has-errors="user.name = $event"
            ></validation-input>
        </div>
        <div class="form-group">
            <validation-input
                label="Email"
                :input-value="user.email"
                message="Email is invalid"
                @has-errors="user.email = $event"
            ></validation-input>
        </div>
        <div class="form-group">
            <label for="create_user_password">Password</label>
            <input
                type="password"
                class="form-control form-control-lg"
                id="create_user_password"
                v-model="user.password"
            />
        </div>
        <div class="form-group">
            <label for="create_user_password_confirmation">Confirm Password</label>
            <input
                type="password"
                class="form-control form-control-lg"
                id="create_user_password_confirmation"
                v-model="user.passwordConfirmation"
            />
        </div>
        <div class="form-group">
            <label for="create_user_role">Role</label>
            <input
                type="text"
                class="form-control form-control-lg"
                id="create_user_role"
                v-model="user.role"
            />
        </div>
    </base-dialog>
</template>

<script>
import BaseDialog from "../components/BaseDialog.vue";
import UserService from "../Services/UserService";
import ValidationInput from "@/admin/components/ValidationInput.vue";
import { useVuelidate } from "@vuelidate/core";
import LoadingSpinner from "../components/LoadingSpinner.vue";

export default {
    components: {
        ValidationInput,
        BaseDialog,
        LoadingSpinner,
    },
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },
    },
    setup() {
        return { v$: useVuelidate() };
    },
    emits: ["close-dialog", "update-users"],
    data() {
        return {
            user: {
                name: "",
                email: "",
                password: "",
                passwordConfirmation: "",
                role: "",
            },
            isLoading: false,
        };
    },
    methods: {
        async createUser(isFormValid) {
            if (!isFormValid) {
                return;
            }
            if (this.user.password.trim() !== this.user.passwordConfirmation.trim()) {
                console.error("Password confirmation does not match");
                return;
            }
            this.isLoading = true;
            try {
                await UserService.addUser(this.user);
                this.$emit("update-users");
                this.$emit("close-dialog");
            } catch (error) {
                console.error(error);
            } finally {
                this.isLoading = false;
            }
        },
        closeDialog() {
            this.$emit("close-dialog");
        },
    },
};
</script>

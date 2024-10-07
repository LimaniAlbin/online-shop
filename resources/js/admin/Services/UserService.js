import axios from "../../plugins/axios";

class UserService {
    async getUsers() {
        try {
            return (await axios.get('/users')).data;
        } catch (error) {
            console.error(error);
        }
    }

    async getUserById(userId) {
        try {
            return (await axios.get(`/users/${userId}`)).data;
        } catch (error) {
            console.error(error);
        }
    }

    async addUser(payload) {
        try {
            const { name, email, password, passwordConfirmation, role } = payload;
            const userPayload = {
                name,
                email,
                password,
                password_confirmation: passwordConfirmation,
                role,
            };
            return (await axios.post('/users', userPayload)).data;
        } catch (error) {
            console.error(error);
            throw error;
        }
    }

    async editUser(payload, userId) {
        try {
            return await axios.put(`/users/${userId}`, payload);
        } catch (error) {
            console.error(error);
        }
    }

    async deleteUser(userId) {
        try {
            return await axios.delete(`/users/${userId}`);
        } catch (error) {
            console.error(error);
        }
    }
}

export default new UserService();

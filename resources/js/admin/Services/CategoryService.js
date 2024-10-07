import axios from '../../plugins/axios';

class CategoryService {

    async getCategories() {
        try {
            return (await axios.get('/categories')).data;
        } catch (error) {
            console.error(error);
        }
    }

    async getCategoryById(categoryId) {
        try {
            return (await axios.get(`/categories/${categoryId}`)).data
        } catch (error) {
            console.error(error)
        }
    }

    async addCategory(payload) {
        try {
            return (await axios.post('/categories', payload)).data
        } catch (error) {
            console.error(error)
        }
    }

    async editCategory(formData, categoryId){
        try {
            formData.append('_method', 'PUT');
            return (await axios.post(`/categories/${categoryId}`, formData)).data;
        }  catch (error) {
            console.error(error)
        }
    }

    async deleteCategory(categoryId) {
        try {
            return (axios.delete(`categories/${categoryId}`)).data;
        } catch (error) {
            console.error(error)
        }
    }
}

export default new CategoryService();

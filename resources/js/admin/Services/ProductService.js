import axios from "../../plugins/axios"


class ProductService {
    async getProducts(page, text) {
        try {
            return (await axios.get('/products', {
                params: {
                    page,
                    text
                }
            })).data;
        } catch (error) {
            console.error(error)
        }
    };

    async getProductById(productId) {
        try {
            return (await axios.get(`/products/${productId}`)).data;
        } catch (error) {
            console.error(error)
        }
    }

    async addProducts(payload) {
        try {
            const response = (await axios.post('/products', payload)).data;
            console.log(response)
            return response;
        } catch (error) {
            console.error(error)
        }
    };

    async editProduct(formData, productId) {
        try {
            formData.append('_method', 'PUT');

            await axios.post(`/products/${productId}`, formData);
        } catch (error) {
            console.error(error);
            throw error;
        }
    }

    async deleteProduct(productId) {
        try {
            return (await axios.delete(`/products/${productId}`)).data;
        } catch (error) {
            console.error(error)
        }
    }
}

export default new ProductService()

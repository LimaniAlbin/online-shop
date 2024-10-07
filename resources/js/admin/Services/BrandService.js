import axios from '../../plugins/axios';

class BrandService {

    async getBrands() {
        try {
            return (await axios.get('/brands')).data;
        } catch (error) {
            console.error(error);
        }
    }

    async getBrandById(brandId) {
        try {
            return (await axios.get(`/brands/${brandId}`)).data
        } catch (error) {
            console.error(error)
        }
    }

    async addBrand(payload) {
        try {
            return (await axios.post('/brands', payload)).data
        } catch (error) {
            console.error(error)
        }
    }

    async editBrand(formData, brandId){
        try {
            formData.append('_method', 'PUT');
            return (await axios.post(`/brands/${brandId}`, formData)).data;
        }  catch (error) {
            console.error(error)
        }
    }

    async deleteBrand(brandId) {
        try {
            return (axios.delete(`brands/${brandId}`)).data;
        } catch (error) {
            console.error(error)
        }
    }
}

export default new BrandService();

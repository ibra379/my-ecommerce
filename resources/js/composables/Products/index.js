export default function useProducts() {
    const add = async (productId) => {
        return await axios.post('api/products', {productId});
    }

    const getCount = async () => {
        return await axios.get('api/products/count');
    }

    return {
        add,
        getCount
    }
}

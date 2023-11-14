import {ref} from "vue";

export default function useProducts() {
    const products = ref([]);
    const cartCount = ref(0)

    const getProducts = async () => {
        const {data} = await axios.get('api/products');
        products.value = data?.cartContent;
    }

    const add = async (productId) => {
        return await axios.post('api/products', {productId});
    }

    const getCount = async () => {
        return axios.get('api/products/count').then(res => {
            return res?.data?.count;
        }).catch(() => {
        });
    }

    const increaseQuantity = async (productId) => {
        const {data} = await axios.get(`api/products/increase/${productId}`);
        products.value = data?.cartContent;
        cartCount.value = data?.cartCount;
    }
    const decreaseQuantity = async (productId) => {
        const {data} = await axios.get(`api/products/decrease/${productId}`);
        products.value = data?.cartContent;
        cartCount.value = data?.cartCount;
    }

    const destroyProduct = async (productId) => {
        const {data} = await axios.delete(`api/products/${productId}`);
        products.value = data?.cartContent;
        cartCount.value = data?.cartCount;
    }

    return {
        add,
        getCount,
        products,
        cartCount,
        getProducts,
        destroyProduct,
        increaseQuantity,
        decreaseQuantity
    }
}

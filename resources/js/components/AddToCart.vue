<script setup>
import useProducts from "../composables/Products/index.js";
import emitter from 'tiny-emitter/instance';
import {inject} from "vue";

const toast = inject('toast')
const {add} = useProducts();

const productId = defineProps(['product-id']);

async function addToCart() {
    axios.get('/sanctum/csrf-cookie').then(async (res) => {
        const {data} = await add(productId);
        emitter.emit('product-add', data.count || 0);
    }).catch(() => {
        console.log('sdafasd')
        toast.error('Merci de vous connecter pour rajouter un produit!');
    });
}
</script>

<template>
    <div class="flex items-center justify-between py-4" :key="productId">
        <button
            class="focus:outline-none text-white rounded-md cursor-pointer text-xs font-semibold px-3 py-2 bg-indigo-700"
            v-on:click.prevent="addToCart"
        >
            Ajouter au panier
        </button>
    </div>
</template>

<script setup>
import useProducts from "../composables/Products/index.js";
import emitter from 'tiny-emitter/instance';

const {add} = useProducts();

const productId = defineProps(['product-id']);

async function addToCart(){
    const {data} = await add(productId);

    emitter.emit('product-add', data.count)
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

<style scoped>

</style>

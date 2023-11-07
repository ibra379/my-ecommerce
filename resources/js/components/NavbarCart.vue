<script setup>
import {onMounted, ref} from "vue";
import useProducts from "../composables/Products/index.js";
import emitter from 'tiny-emitter/instance';

const {getCount} = useProducts();

let cartCount = ref(0);

emitter.on('product-add', (event) => cartCount.value = event);

onMounted(async () => {
    const {data} = await getCount();

    cartCount.value = data.count;
});
</script>

<template>
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex mr-10">
        <a href="/shoppingCart" class="relative">
            <span
                class="absolute -top-1 left-4 rounded-full bg-indigo-700 w-5 h-5 text-xs text-white flex items-center justify-center">{{
                    cartCount
                }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-sm font-medium leading-5 text-gray-600 "
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </a>
    </div>
</template>

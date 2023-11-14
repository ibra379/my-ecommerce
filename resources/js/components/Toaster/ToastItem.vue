<script setup lang="ts">
import SuccessVector from "@/SVG/SuccessVector.vue";
import ErrorVector from "@/SVG/ErrorVector.vue";
import CrossVector from "@/SVG/CrossVector.vue";
import {ToastItemType} from "@/Store/toast";
import {onMounted} from "vue";

const props = (defineProps<{
    toastData: ToastItemType
}>());

const emit = defineEmits(['remove']);

onMounted(() => {
    setTimeout(() => emit('remove'), props.toastData.duration || 3000)
})

const id = props.toastData.success ? 'toast-success' : 'toast-danger';
</script>

<template>
    <div :id="id"
         class="flex items-center w-full max-w-sm p-4 mb-2 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
         role="alert">
        <div
            v-if="props.toastData.success"
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"
        >
            <SuccessVector/>
            <span class="sr-only">Check icon</span>
        </div>
        <div
            v-else
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200"
        >
            <ErrorVector/>
            <span class="sr-only">Error icon</span>
        </div>
        <div class="ml-3 text-sm font-normal dark:text-gray-100">
            {{ props.toastData.message }}
        </div>
        <button
            class="ml-1 -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            @click="$emit('remove')"
            aria-label="Close"
            type="button"
        >
            <span class="sr-only">Close</span>
            <CrossVector/>
        </button>
    </div>
</template>

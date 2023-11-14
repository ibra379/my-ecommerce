<script setup lang="ts">
import ToastItem from "@/Components/Toaster/ToastItem.vue";
import toast from "@/Store/toast";
</script>

<template>
    <Teleport to="body">
        <TransitionGroup
            tag="div"
            enter-from-class="translate-x-full opacity-0 transform-gpu"
            leave-to-class="translate-x-full opacity-0 transform-gpu"
            class="fixed top-4 right-4 z-50 space-y-2 max-w-sm"
            enter-active-class="duration-500"
            leave-active-class="duration-500"
        >
            <ToastItem
                @remove="toast.remove(index as number)"
                v-for="(item, index) in toast.items"
                :key="item.key"
                :toastData="item"
            />
        </TransitionGroup>
    </Teleport>
</template>

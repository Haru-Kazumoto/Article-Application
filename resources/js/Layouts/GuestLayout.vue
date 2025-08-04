<template>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-gray-900 px-4 md:px-6 py-3 md:py-4 shadow">
            <div class="flex items-center justify-between flex-wrap gap-y-2">
                <h1 class="text-2xl font-extrabold text-white tracking-tight whitespace-nowrap">
                    <span>Article</span><span class="text-amber-300">Nest</span>
                </h1>

                <div class="flex items-center space-x-3 cursor-pointer text-white">
                    <n-button quaternary color="white" @click="router.visit(route('dashboard'))" size="large">
                        <template #icon>
                            <n-icon size="20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                                </svg>
                            </n-icon>
                        </template>
                        Back To Dashboard
                    </n-button>
                </div>
            </div>

        </header>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center px-4 py-8 bg-gray-100 ">
            <slot />
        </main>
    </div>
</template>


<script lang="ts">
import { defineComponent } from 'vue'
import BackButton from '@/Components/BackButton.vue'
import { router } from '@inertiajs/vue3'
import { NButton, NIcon } from 'naive-ui'

export default defineComponent({
    components: {
        BackButton,
        NButton,
        NIcon
    },
    setup() {


        return {
            router
        }
    }
})
</script>

<style scoped></style>

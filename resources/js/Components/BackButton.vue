<template>
    <n-button quaternary @click="goBack" size="large">
        <template #icon>
            <n-icon size="20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                </svg>
            </n-icon>
        </template>
        Back
    </n-button>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { router } from '@inertiajs/vue3'
import { NButton, NIcon } from 'naive-ui'

export default defineComponent({
    name: 'BackButton',
    components: {
        NButton,
        NIcon,
    },
    props: {
        to: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        function goBack() {
            router.visit(route(props.to))
        }

        return {
            goBack,
        }
    },
})
</script>

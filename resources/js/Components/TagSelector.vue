<template>
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Article Tags</h3>
        <div class="mt-6 relative">
            <!-- Scrollable container -->
            <div ref="scrollContainer"
                class="relative flex overflow-x-auto gap-3 px-4 py-2 hide-scrollbar scroll-smooth scrollbar-hide">
                <button v-for="tag in tags" :key="tag.slug" @click="toggleTag(tag.slug)"
                    class="flex-shrink-0 flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium border transition-all duration-200 whitespace-nowrap"
                    :class="[
                        tag.selected
                            ? 'bg-gray-900 text-white border-gray-900'
                            : 'bg-white text-gray-800 border-gray-300 hover:bg-gray-100',
                    ]">
                    <span>{{ tag.name }}</span>
                    <n-icon v-if="tag.selected" size="10" class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>

                    </n-icon>
                </button>
            </div>

            <!-- Left blur -->
            <div
                class="absolute left-0 top-0 h-full w-8 bg-gradient-to-r from-white via-white/70 to-transparent pointer-events-none" />

            <!-- Right blur -->
            <div
                class="absolute right-0 top-0 h-full w-8 bg-gradient-to-l from-white via-white/70 to-transparent pointer-events-none" />
        </div>

    </div>
</template>

<script lang="ts">
import { defineComponent, PropType, onMounted, ref } from 'vue';

type Tags = {
    name: string;
    slug: string;
    selected: boolean;
}

export default defineComponent({
    props: {
        tags: { type: Array as PropType<Tags[]>, required: true }
    },
    setup(props, { emit }) {
        const scrollContainer = ref<HTMLDivElement | null>(null)

        function toggleTag(slug: string) {
            const tag = props.tags.find((t) => t.slug === slug)
            if (tag) tag.selected = !tag.selected
            emitSelectedTags();
        }


        function emitSelectedTags() {
            const selected = props.tags
                .filter(tag => tag.selected)
                .map(tag => tag.slug)
            emit('update:selected', selected)
        }


        onMounted(() => {
            const el = scrollContainer.value
            if (!el) return

            el.addEventListener('wheel', (e) => {
                if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                    e.preventDefault()
                    el.scrollLeft += e.deltaY
                }
            }, { passive: false })
        })

        return {
            toggleTag,
            scrollContainer
        }
    }
})
</script>
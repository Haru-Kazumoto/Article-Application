<template>
    <div
        class="flex flex-col sm:flex-row bg-white rounded-xl shadow hover:shadow-md transition-shadow duration-300 overflow-hidden">
        <!-- Thumbnail -->
        <div class="w-full sm:w-1/3 h-48 sm:h-auto bg-cover bg-center" :style="{
            backgroundImage: `url(${article.thumbnail || defaultThumbnail})`,
        }" />

        <!-- Content -->
        <div class="flex-1 p-4 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:underline cursor-pointer"
                    @click="$emit('read', article.slug)">
                    {{ article.title }}
                </h2>
                <p class="text-gray-700 text-sm mb-3 line-clamp-3">
                    {{ article.summary }}
                </p>
            </div>
            <div class="flex items-center justify-between mt-2 text-sm text-gray-500">
                <div class="flex items-center gap-2">
                    <n-avatar round size="small" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCQSEQ8FsJIDaJGl6qOaoRkK7iXQNmo6dLKg&s" />
                    <span>By {{ article.publisher_name }}</span>
                </div>
                <span>{{ article.published_at }}</span>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue'
import { NAvatar } from 'naive-ui'

type Article = {
    title: string;
    slug: string;
    summary: string;
    published_at: string;
    publisher_name?: string;
    avatar?: string;
    thumbnail?: string;
}

export default defineComponent({
    name: 'ArticleCard',
    props: {
        article: {
            type: Object as PropType<Article>,
            required: true
        }
    },
    components: {
        NAvatar,
    },
    emits: ['read'],
    setup(props, { emit }) {
        const defaultThumbnail =
            'https://i.ytimg.com/vi/LdNsr_oQ100/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLCqNNdjPiJ0qLCrr_ooLQYTZc_Qyg'

        const defaultAvatar =
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCQSEQ8FsJIDaJGl6qOaoRkK7iXQNmo6dLKg&s'

        return {
            defaultThumbnail,
            defaultAvatar
        }
    }
})
</script>

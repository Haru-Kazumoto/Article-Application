<template>
    <BaseLayout>
        <div class="px-4 md:px-6 py-6">
            <div class="max-w-3xl mx-auto space-y-6 text-justify leading-relaxed text-gray-800 text-[17px]">

                <!-- Judul Artikel -->
                <div class="py-3">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        {{ article.title }}
                    </h1>

                    <!-- Info Penulis -->
                    <div class="mt-3 flex items-center space-x-3 text-sm text-gray-600">
                        <img src="https://www.pngmart.com/files/21/Admin-Profile-PNG-Isolated-Pic.png"
                            alt="Author Avatar" class="w-8 h-8 rounded-full object-cover" />
                        <div>
                            <div class="font-medium text-gray-800">{{ article.fullname }}</div>
                            <div class="text-xs text-gray-500">{{ article.published_at }}</div>
                        </div>
                    </div>

                </div>
                <!-- Tombol Kembali, hanya muncul jika bukan di /dashboard -->
                <BackButton to="dashboard" />

                <!-- Thumbnail Artikel -->
                <img src="https://i.ytimg.com/vi/LdNsr_oQ100/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLCqNNdjPiJ0qLCrr_ooLQYTZc_Qyg"
                    alt="Thumbnail" class="w-full rounded-lg shadow-sm object-cover" />

                <!-- Isi Konten Artikel -->
                <div v-html="article.content" class="prose max-w-none prose-slate dark:prose-invert" />


                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mt-8">
                    <span v-for="tag in tags" :key="tag.name"
                        class="bg-amber-100 text-amber-800 text-sm px-3 py-1 rounded-full">
                        #{{ tag.name }}
                    </span>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>

<script lang="ts">
import { defineComponent, PropType, ref } from 'vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import BackButton from '@/Components/BackButton.vue';

type Tag = {
    name: string;
}

export default defineComponent({
    components: {
        BaseLayout,
        BackButton
    },
    props: {
        article: { type: Object, required: true },
        tags: { type: Array as PropType<Tag[]>, required: true }
    },
    setup() {
        const articleTitle = ref('Mengenal Lebih Dalam tentang Vue.js 3')
        const articleContent = ref(`
            <p>Vue.js 3 adalah salah satu framework JavaScript modern yang digunakan untuk membangun antarmuka pengguna yang interaktif dan efisien.</p>
            <p>Dengan komposisi API dan performa yang lebih baik, Vue 3 memberikan fleksibilitas dalam pengembangan aplikasi web berskala besar maupun kecil.</p>
            <h2>Fitur Baru di Vue 3</h2>
            <ul>
                <li>Composition API</li>
                <li>Teleport</li>
                <li>Fragments</li>
                <li>Improved TypeScript support</li>
            </ul>
        `)
        const articleTags = ref([
            { name: 'Vue.js', slug: 'vuejs' },
            { name: 'JavaScript', slug: 'javascript' },
            { name: 'Frontend', slug: 'frontend' }
        ])

        return {
            articleTitle,
            articleContent,
            articleTags
        }
    }
})
</script>

<style scoped>
/* Tambahkan gaya tambahan jika perlu */
</style>

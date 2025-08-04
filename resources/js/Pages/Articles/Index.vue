<template>
    <BaseLayout>
        <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-14 space-y-6">
            <BackButton to="dashboard" />
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
                <!-- Creator Profile -->
                <div class="lg:col-span-2">
                    <div class="sticky top-20">
                        <div
                            class="bg-white rounded-xl shadow hover:shadow-md transition-shadow duration-300 overflow-hidden p-4 flex gap-4 items-start">
                            <n-avatar size="large" round :src="creator.avatar || defaultAvatar" class="flex-shrink-0" />
                            <div class="flex flex-col">
                                <span class="text-lg font-semibold">
                                    {{ creator.fullname }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Creator
                                </span>
                                <p class="text-sm text-gray-600 mt-2 line-clamp-3">
                                    Join At {{ creator.join_at }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Artikel -->
                <div class="lg:col-span-3 flex flex-col gap-3">
                    <template v-if="articles.data.length > 1">
                        <ArticleCard v-for="article in articles.data" :key="article.slug" :article="article"
                            @read="handleReadArticle(article.slug)" />
                        <div class="w-full overflow-x-auto">
                            <div class="flex justify-center sm:justify-end min-w-[300px]">
                                <n-pagination v-model:page="articles.current_page" :page-count="articles.last_page"
                                    :page-size="articles.per_page" @update:page="handlePageChange"
                                    @update:page-count="articles.last_page = articles.last_page" />
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="flex flex-col items-center justify-center h-96 text-gray-500">
                            <img src="/images/empty_image.png" alt="Tidak ada artikel"
                                class="w-48 h-48 object-contain mb-4" />
                            <p>Tidak ada artikel yang tersedia.</p>
                        </div>
                    </template>
                </div>



            </div>
        </div>
    </BaseLayout>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import BaseLayout from '@/Layouts/BaseLayout.vue'
import { NCard, NAvatar, NPagination } from 'naive-ui'
import ArticleCard from '@/Components/ArticleCard.vue'
import BackButton from '@/Components/BackButton.vue'
import { router } from '@inertiajs/vue3'

export default defineComponent({
    components: {
        NCard, NAvatar, BaseLayout, ArticleCard, BackButton, NPagination
    },
    props: {
        articles: { type: Object, required: true },
        creator: { type: Object, required: true }
    },
    setup(props) {
        console.log(props);

        const defaultAvatar =
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCQSEQ8FsJIDaJGl6qOaoRkK7iXQNmo6dLKg&s'


        function handleReadArticle(slug: string) {
            router.get(route('read', slug));
        }

        function handlePageChange(page: number) {
            router.get(route('article.index', props.creator.id), {
                page
            }, {
                preserveState: true,
                replace: true
            });
        }

        return {
            handlePageChange,
            defaultAvatar,
            handleReadArticle
        }
    }
});
</script>

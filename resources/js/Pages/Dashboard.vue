<template>
    <BaseLayout>
        <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Carousel -->
            <SliderCarousel :sliderItems />

            <div class="flex justify-center mt-6">
                <n-input v-model:value="searchTitle" placeholder="Search articles..." size="large"
                    class="bg-white/10 backdrop-blur-md text-white border border-white/30 rounded-md w-full shadow-sm"
                    @keyup.enter="handleSearchTitle" clearable />
            </div>

            <!-- Sticky Search Info -->
            <div v-if="searchTitle?.trim()"
                class="sticky top-[64px] z-40 bg-white/70 backdrop-blur-sm py-2 px-4 text-2xl text-black mt-2 ms-1 shadow-sm">
                Search for "<span class="font-semibold">{{ searchTitle }}</span>"
            </div>


            <!-- Tag Selector -->
            <TagSelector :tags @update:selected="handleSearchByTags" />

            <!-- Main content and sidebar -->
            <div class="mt-8 flex flex-col lg:flex-row gap-6">
                <!-- Main Articles -->
                <div class="w-full lg:w-3/4 space-y-6">
                    <div v-for="(article, index) in articles.data" :key="index"
                        class="flex flex-col sm:flex-row bg-white rounded-xl shadow hover:shadow-md transition-shadow duration-300 overflow-hidden">
                        <!-- Thumbnail -->
                        <div class="w-full sm:w-1/3 h-48 sm:h-auto bg-cover bg-center"
                            :style="{ backgroundImage: `url(https://i.ytimg.com/vi/LdNsr_oQ100/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLCqNNdjPiJ0qLCrr_ooLQYTZc_Qyg})` }">
                        </div>

                        <!-- Content -->
                        <div class="flex-1 p-4 flex flex-col justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:underline cursor-pointer"
                                    @click="handleReadArticle(article.slug)">
                                    {{ article.title }}
                                </h2>
                                <p class="text-gray-700 text-sm mb-3 line-clamp-3">
                                    {{ article.summary }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between mt-2 text-sm text-gray-500">
                                <!-- Avatar + Nama -->
                                <div class="flex items-center gap-2">
                                    <n-avatar round size="small"
                                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCQSEQ8FsJIDaJGl6qOaoRkK7iXQNmo6dLKg&s" />
                                    <span>By {{ article.publisher_name }}</span>
                                </div>
                                <!-- Tanggal -->
                                <span>{{ article.published_at }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full overflow-x-auto">
                        <div class="flex justify-center sm:justify-end min-w-[300px]">
                            <n-pagination v-model:page="articles.current_page" :page-count="articles.last_page"
                                :page-size="articles.per_page" @update:page="handlePageChange"
                                @update:page-count="articles.last_page = articles.last_page" />
                        </div>
                    </div>


                </div>

                <!-- Sidebar -->
                <div class="w-full lg:w-1/4 space-y-4">
                    <div class="bg-white rounded-xl shadow p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Recent Articles</h3>
                        <ul class="space-y-3">
                            <li v-for="(recent, idx) in recentArticles" :key="idx"
                                class="text-sm text-gray-700 hover:underline cursor-pointer">
                                {{ recent.title }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>


<style>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>


<script lang="ts">
import { defineComponent, ref, PropType, computed } from 'vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { NCarousel, NIcon, NAvatar, NInput, NPagination } from 'naive-ui';
import SliderCarousel from '@/Components/SliderCarousel.vue';
import TagSelector from '@/Components/TagSelector.vue';
import { router } from '@inertiajs/vue3';

type Tags = {
    name: string;
    slug: string;
    selected: boolean;
}

export default defineComponent({
    components: {
        NCarousel,
        BaseLayout,
        NIcon,
        NAvatar,
        NInput,
        NPagination,
        SliderCarousel,
        TagSelector
    },
    props: {
        tags: { type: Array as PropType<Tags[]>, required: true },
        articles: { type: Object, required: true }
    },
    setup(props, { emit }) {
        const searchTitle = ref<string | null>(null);
        const selectedSlugs = computed(() => {
            return props.tags
                .filter(tag => tag.selected)
                .map(tag => tag.slug)

        });

        function handlePageChange(page: number) {
            router.get(route('dashboard'), {
                page,
                slugs: selectedSlugs.value,
                title: searchTitle.value
            }, { preserveState: true, replace: true });
        }

        function handleSearchTitle() {
            router.get(route('dashboard'), {
                title: searchTitle.value
            }, {
                replace: true,
                preserveState: true,
            });
        }

        function handleSearchByTags() {
            router.reload({
                data: {
                    slugs: selectedSlugs.value
                },
                only: ['articles']
            });
        }

        function handleReadArticle(slug: string) {
            router.get(route('read', slug));
        }

        const recentArticles = ref([
            { title: 'Getting Started with Vue 3' },
            { title: 'Understanding Tailwind CSS Layouts' },
            { title: '10 Tips for Writing Better Code' },
            { title: 'What’s New in ES2025?' },
        ])

        return {
            handlePageChange,
            handleSearchTitle,
            handleSearchByTags,
            recentArticles,
            selectedSlugs,
            searchTitle,
            handleReadArticle,
            sliderItems: [
                {
                    image: 'https://www.cloud-kinetics.com/wp-content/uploads/2019/08/Eight-Essential-Digital-Transformation-Technologies.jpg',
                    title: 'Latest Technology',
                    description: 'The latest updates on technology and innovation.',
                },
                {
                    image: 'https://binus.ac.id/alsut/wp-content/uploads/2025/04/Accounting-in-the-Digital-Era.jpg',
                    title: 'Finance',
                    description: 'Interesting articles about the world of finance.',
                },
                {
                    image: 'https://cloudinary.hbs.edu/hbsit/image/upload/s--jcW2HPqC--/f_auto,c_fill,h_375,w_750,/v20200101/EA99CC738B99D0AA67987EC2976D550F.jpg',
                    title: 'Marketing',
                    description: 'Tips and tricks in marketing.',
                },
            ]

        }
    }
})
</script>
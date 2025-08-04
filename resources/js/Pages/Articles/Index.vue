<template>
    <BaseLayout>
        <div class="space-y-6 px-6 py-4">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Manage Articles</h1>
                <n-button type="primary" @click="router.visit(route('office.create'))">
                    <template #icon>
                        <n-icon>
                            <PlusIcon />
                        </n-icon>
                    </template>
                    New Article
                </n-button>
            </div>

            <!-- Article Table -->
            <n-data-table :columns="columns" :data="articles" :pagination="{ pageSize: 5 }" :bordered="true" />
        </div>
    </BaseLayout>

</template>

<script lang="ts">
import { defineComponent, h } from 'vue'
import BaseLayout from '@/Layouts/BaseLayout.vue'
import { NButton, NIcon, NDataTable } from 'naive-ui'
import { router } from '@inertiajs/vue3'

export default defineComponent({
    components: {
        BaseLayout,
        NButton,
        NIcon,
        NDataTable,
    },
    setup() {
        function createColumns() {
            return [
                {
                    title: 'Title',
                    key: 'title',
                    width: 150,
                },
                {
                    title: 'Category',
                    key: 'category',
                    width: 150,
                },
                {
                    title: 'Author',
                    key: 'author',
                    width: 150,
                },
                {
                    title: 'Actions',
                    key: 'actions',
                    width: 150,
                    render: (row: any) =>
                        h(
                            'div',
                            { class: 'space-x-2' },
                            [
                                h(
                                    NButton,
                                    {
                                        type: 'primary',
                                        size: 'small',
                                        onClick: () => handleEdit(row.id),
                                    },
                                    {
                                        icon: () =>
                                            h(NIcon, null, { default: () => h(null) }),
                                    }
                                ),
                                h(
                                    NButton,
                                    {
                                        type: 'error',
                                        size: 'small',
                                        onClick: () => handleDelete(row.id),
                                    },
                                    {
                                        icon: () =>
                                            h(NIcon, null, { default: () => h(null) }),
                                    }
                                ),
                            ]
                        ),
                },
            ]
        }

        function handleCreate() {
            router.visit('/articles/create')
        }

        function handleEdit(id: number) {
            router.visit(`/articles/${id}/edit`)
        }

        function handleDelete(id: number) {
            if (confirm('Are you sure you want to delete this article?')) {
                router.delete(`/articles/${id}`)
            }
        }

        return {
            articles: [
                { id: 1, title: 'First Article', category: 'Tech', author: 'Admin' },
                { id: 2, title: 'Second Article', category: 'Finance', author: 'Editor' },
            ],
            columns: createColumns(),
            router
        }
    },
    methods: {

    },
})
</script>

<style scoped>
/* Optional styling */
</style>

<template>
    <BaseLayout>
        <div class="max-w-4xl mx-auto px-6 py-6 space-y-6">
            <h1 class="text-2xl font-bold">Create New Article</h1>

            <!-- Title -->
            <div>
                <label class="block font-medium mb-1">Title</label>
                <n-input v-model:value="form.title" placeholder="Enter article title" />
            </div>

            <!-- Summary -->
            <div>
                <label class="block font-medium mb-1">Summary</label>
                <n-input type="textarea" v-model:value="form.summary" placeholder="Enter a short summary"
                    :autosize="{ minRows: 3, maxRows: 5 }" />
            </div>

            <!-- Tags -->
            <div>
                <label class="block font-medium mb-1">Tags</label>
                <n-select multiple placeholder="Choose your article tags" :options="tagOptions"/>
            </div>

            <!-- Content -->
            <div>
                <label class="block font-medium mb-1">Content</label>
                <n-input type="textarea" v-model:value="form.content" placeholder="Write your article content..."
                    :autosize="{ minRows: 10, maxRows: 20 }" />
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <n-button type="primary">
                    Submit Article
                </n-button>
            </div>
        </div>
    </BaseLayout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import BaseLayout from '@/Layouts/BaseLayout.vue'
import { NButton, NInput, NSelect } from 'naive-ui'

export default defineComponent({
    props: {
        tags: { type: Array, required: true }
    },
    components: {
        NButton,
        NInput,
        NSelect,
        BaseLayout
    },
    setup(props) {
        const form = ref({
            title: '',
            summary: '',
            tags: [] as string[],
            content: ''
        });

        const tagOptions = props.tags.map((tag: any) => ({
            label: tag.name,
            value: tag.id
        }))


        function handleSubmit() {
            // Lakukan validasi atau submit ke API
            console.log('Submitting:', form.value)

            // Contoh redirect setelah submit
            // router.push('/articles')
        }

        return {
            tagOptions,
            form,
            handleSubmit
        }
    }
});
</script>

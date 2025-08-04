<template>
    <BaseLayout>
        <div class="max-w-4xl mx-auto px-6 py-6 space-y-6">
            <h1 class="text-2xl font-bold">Create New Article</h1>
            <BackButton to="dashboard" />

            <n-form :model="form" :rules="rules" ref="formRef" label-placement="top">
                <!-- Title -->
                <n-form-item label="Title" path="title">
                    <n-input v-model:value="form.title" placeholder="Enter article title" />
                </n-form-item>

                <div class="grid grid-cols-1 sm:grid-cols-5  gap-4">
                    <!-- Thumbnail -->
                    <div class="col-span-1">
                        <n-form-item label="Thumbnail">
                            <n-upload accept="image/*" :max="1" list-type="image-card" :default-upload="false"
                                :on-change="handleImageUpload">
                                Klik untuk Upload
                            </n-upload>
                        </n-form-item>
                    </div>

                    <!-- Summary -->
                    <div class="col-span-4">
                        <n-form-item label="Summary" path="summary">
                            <n-input type="textarea" v-model:value="form.summary" placeholder="Enter a short summary"
                                :autosize="{ minRows: 3, maxRows: 5 }" />
                        </n-form-item>
                    </div>
                </div>

                <!-- Tags -->
                <n-form-item label="Tags" path="tags">
                    <n-select multiple v-model:value="form.tags" placeholder="Choose your article tags"
                        :options="tagOptions" />
                </n-form-item>

                <label for="" class="block font-medium">Content</label>
                <div id="content-editor" style="height: 300px"></div>

                <!-- Submit -->
                <div class="text-right mt-4">
                    <n-button type="primary" @click="handleSubmit">
                        Submit Article
                    </n-button>
                </div>
            </n-form>
        </div>
    </BaseLayout>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import BaseLayout from '@/Layouts/BaseLayout.vue'
import { FormInst, FormRules, NButton, NForm, NFormItem, NInput, NSelect, NUpload } from 'naive-ui'
import BackButton from '@/Components/BackButton.vue'

export default defineComponent({
    props: {
        tags: { type: Array, required: true }
    },
    components: {
        NButton,
        NInput,
        NSelect,
        BaseLayout,
        NUpload,
        NForm,
        NFormItem,
        BackButton
    },
    setup(props) {
        const formRef = ref<FormInst | null>(null)

        const form = ref({
            title: '',
            summary: '',
            tags: [] as string[],
            content: '',
            thumbnail: null as File | null,
        })

        const rules: FormRules = {
            title: {
                required: true,
                message: 'Title is required',
                trigger: ['blur', 'input']
            },
            summary: {
                required: true,
                message: 'Summary is required',
                trigger: ['blur', 'input']
            },
            tags: {
                type: 'array',
                required: true,
                message: 'Please select at least one tag',
                trigger: 'change'
            },
            content: {
                required: true,
                message: 'Content is required',
                trigger: 'blur'
            },
            thumbnail: {
                required: true,
                message: 'Thumbnail is required',
                trigger: 'change'
            }
        }

        const tagOptions = props.tags.map((tag: any) => ({
            label: tag.name,
            value: tag.slug,
        }));

        function handleImageUpload({ file }: { file: any }) {
            form.value.thumbnail = file.file
        }

        function handleSubmit(e: MouseEvent) {
            e.preventDefault();
            console.log("KE HIT")

            formRef.value?.validate((errors) => {
                if (errors) {
                    return;
                }

                // Contoh: kirim ke server
                const formData = new FormData()
                formData.append('title', form.value.title)
                formData.append('summary', form.value.summary)
                formData.append('tags', JSON.stringify(form.value.tags))
                formData.append('content', form.value.content)
                formData.append('thumbnail', form.value.thumbnail!)

                router.post(route('article.store'), formData, {
                    forceFormData: true
                });
            })
        }

        onMounted(() => {
            const quill = new Quill('#content-editor', {
                theme: 'snow'
            });

            quill.on('text-change', () => {
                form.value.content = quill.root.innerHTML
            })
        });

        return {
            formRef,
            form,
            rules,
            tagOptions,
            handleImageUpload,
            handleSubmit,
        }
    }
});
</script>


<template>
    <GuestLayout>
        <div
            class="w-full max-w-sm bg-white  rounded-lg shadow p-6 sm:p-8 border border-gray-200 ">
            <n-form ref="formRef" :model="formModel" :rules="rules" class="space-y-4">
                <h5 class="text-xl font-medium text-gray-900 ">Sign in to our platform</h5>

                <n-form-item label="Email" path="email">
                    <n-input v-model:value="formModel.email" placeholder="name@company.com" type="text" />
                </n-form-item>

                <n-form-item label="Password" path="password">
                    <n-input v-model:value="formModel.password" type="password" show-password-on="click"
                        placeholder="••••••••" />
                </n-form-item>


                <n-button color="#111827" class="w-full" @click="handleSubmit">
                    Login to your account
                </n-button>

                <div class="text-sm text-gray-600  text-center">
                    Not registered?
                    <a href="#" class="text-blue-700 hover:underline ">Create account</a>
                </div>
            </n-form>
        </div>
    </GuestLayout>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue'
import { FormInst, FormRules, useMessage } from 'naive-ui'
import { NForm, NFormItem, NButton, NInput } from 'naive-ui';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { router } from '@inertiajs/vue3';

export default defineComponent({
    components: {
        NForm, NFormItem, NButton, NInput, GuestLayout
    },
    setup() {
        const formRef = ref<FormInst | null>(null);
        const formModel = ref({
            email: '',
            password: '',
            remember: false
        })

        const rules: FormRules = {
            email: [
                { required: true, message: 'Email is required', trigger: ['blur', 'input'] },
                { type: 'email', message: 'Email format is invalid', trigger: ['blur', 'input'] }
            ],
            password: [
                { required: true, message: 'Password is required', trigger: ['blur', 'input'] }
            ]
        }

        function handleSubmit(e: MouseEvent) {
            e.preventDefault()
            formRef.value?.validate((errors) => {
                if (errors) {
                    return;
                } 

                router.post(route('login'), {
                    email: formModel.value.email,
                    password: formModel.value.password
                });
            })
        }

        return {
            formRef,
            formModel,
            rules,
            handleSubmit
        }
    }
});
</script>
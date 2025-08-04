<template>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-gray-900 px-4 md:px-6 py-3 md:py-4 shadow">
            <div class="flex items-center justify-between flex-wrap gap-y-2">
                <!-- Kiri: Logo -->
                <h1 class="text-2xl font-extrabold text-white tracking-tight whitespace-nowrap">
                    <span>Article</span><span class="text-amber-300">Nest</span>
                </h1>

                <!-- Kanan: Avatar -->
                <div class="flex items-center space-x-3 cursor-pointer text-white">
                    <n-dropdown trigger="click" :options="dropdownOptions" @select="handleSelect">
                        <div class="flex items-center space-x-2">
                            <n-avatar round size="medium"
                                src="https://www.pngmart.com/files/21/Admin-Profile-PNG-Isolated-Pic.png" />
                            <div class="hidden sm:block text-sm leading-tight text-white">
                                <p class="font-semibold">{{ page.props.auth.user ? (page.props.auth.user as
                                    any).fullname : 'Guest User' }}
                                </p>
                                <p class="text-xs opacity-75">{{ page.props.auth.user ? page.props.auth.user.email : '-'
                                    }}</p>
                            </div>
                        </div>
                    </n-dropdown>

                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-50 p-4 md:p-6">
            <slot />
        </main>



        <footer class="bg-white shadow-sm dark:bg-gray-900">
            <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                        <span>Article</span><span class="text-amber-300">Nest</span>
                    </h1>
                    <ul
                        class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                        <li>
                            <a href="https://haru-kazumoto.github.io/ziaurrahman/" class="hover:underline">About
                                Developer</a>
                        </li>
                    </ul>
                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
                <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="#"
                        class="hover:underline">ArticleNest</a>. All Rights Reserved.</span>
            </div>
        </footer>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { NAvatar, NInput, NDropdown, NButton } from 'naive-ui'
import { router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue';

export default defineComponent({
    components: {
        NAvatar,
        NDropdown,
        NInput,
        NButton
    },
    setup() {
        const page = usePage();
        const dropdownOptions = computed(() => {
            return page.props.auth?.user
                ? [
                    { label: 'Create article', key: 'create' },
                    { label: 'My article', key: 'index' },
                    { label: 'Logout', key: 'logout' },
                ]
                : [
                    { label: 'Login', key: 'login' },
                    { label: 'Register', key: 'register' },
                ]
        })

        function handleSelect(key: string) {
            switch (key) {
                case 'login':
                    router.visit(route('login'));
                    break;

                case 'register':
                    router.visit(route('register'));
                    break;

                case 'create':
                    router.visit(route('article.create')); 
                    break;

                case 'index':
                    router.visit(route('article.index', page.props.auth.user.id)); 
                    break;

                case 'logout':
                    router.post(route('logout'));
                    break;

                default:
                    console.warn(`Unknown dropdown key: ${key}`);
            }
        }


        return {
            dropdownOptions,
            router,
            handleSelect,
            page
        }
    }
})
</script>
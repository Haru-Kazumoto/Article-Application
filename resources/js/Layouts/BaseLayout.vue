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
                    <n-button quarternary type="info" @click="router.visit(route('office'))">
                        <template #icon>
                            <n-icon size="20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </n-icon>
                        </template>
                        Create Article
                    </n-button>

                    <!-- <n-avatar round size="medium"
                        src="https://www.pngmart.com/files/21/Admin-Profile-PNG-Isolated-Pic.png" />
                    <div class="hidden sm:block text-sm leading-tight">
                        <p class="font-semibold">Guest User</p>
                        <p class="text-xs opacity-75">johndoe@example.com</p>
                    </div> -->
                </div>
                <!-- <n-dropdown :options="dropdownOptions" @select="handleSelect">
                </n-dropdown> -->
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
import { router } from '@inertiajs/vue3'

export default defineComponent({
    components: {
        NAvatar,
        NDropdown,
        NInput, 
        NButton
    },
    setup() {
        const dropdownOptions = [
            { label: 'Profile', key: 'profile' },
            { label: 'Settings', key: 'settings' },
            { label: 'Logout', key: 'logout' },
        ]

        // function handleSelect(key: string) {
        //     if (key === 'logout') {
        //         // logika logout
        //         console.log('Logging out...')
        //     } else {
        //         console.log('Selected:', key)
        //     }
        // }

        return {
            dropdownOptions,
            router
            // handleSelect
        }
    }
})
</script>
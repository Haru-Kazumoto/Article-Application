<template>
    <n-carousel autoplay draggable show-arrow :slides-per-view="1" dot-type="line"
        class="rounded-xl overflow-hidden shadow-md">
        <div v-for="(item, index) in sliderItems" :key="index"
            class="w-full h-60 sm:h-64 md:h-72 bg-cover bg-center flex items-end p-4 sm:p-6"
            :style="{ backgroundImage: `url(${item.image})` }">
            <div class="bg-white bg-opacity-80 p-3 sm:p-4 rounded shadow w-full max-w-lg">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">{{ item.title }}</h2>
                <p class="text-gray-600 text-sm">{{ item.description }}</p>
            </div>
        </div>
    </n-carousel>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { NCarousel } from 'naive-ui';

type SliderItem = {
    image: string, 
    title: string,
    description: string
}

export default defineComponent({
    props: {
        sliderItems: { type: Array as PropType<SliderItem[]>, required: true }
    },
    components: {
        NCarousel
    },
    setup() {


        return {}
    }
})
</script>

<style scoped></style>
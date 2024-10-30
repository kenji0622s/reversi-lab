<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    messages: Object,
});
const form = reactive({
    name: '',
    description: '',
    description_en: '',
});

const storeBrain = () => {
    router.post(route('brains.store'), form);
}
</script>

<template>

    <Head title="Create Brain" />
    <BasicLayout :messages="messages">
        <template #title>
            Create Brain
        </template>
        <div class="w-4/5 md:w-2/5 mx-auto mt-4">
            <a :href="route('brains.index')" class="text-emerald-600 text-xs inline-block py-1">
                <i class="fa-solid fa-angle-left"></i>
                戻る
            </a>

            <form @submit.prevent="storeBrain">
                <div class="container bg-neutral-100 mt-2 pt-4 pb-8 px-4 rounded-md shadow-sm border-2 border-neutral-300">
                    <div class="md:px-8 mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600 font-bold">名前</label>
                                    <input type="text" id="name" name="name" v-model="form.name"
                                        class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="description" class="leading-7 text-sm text-gray-600 font-bold">日本語説明</label>
                                    <textarea id="description" name="description" v-model="form.description"
                                        class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="description_en" class="leading-7 text-sm text-gray-600 font-bold">英語説明</label>
                                    <textarea id="description_en" name="description_en" v-model="form.description_en"
                                        class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>

                            <div class="mt-2 w-full flex justify-center">
                                <button class="bg-emerald-500 text-white px-4 py-2 rounded-md font-bold">作成</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </BasicLayout>
</template>

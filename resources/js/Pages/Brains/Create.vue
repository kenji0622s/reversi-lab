<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

defineProps({
    messages: Object,
});

const form = reactive({
    ja_name: '',
    en_name: '',
    ja_description: '',
    en_description: '',
    created_by: '',
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
                <div
                    class="container bg-neutral-100 mt-2 pt-4 pb-8 px-4 rounded-md shadow-sm border-2 border-neutral-300">
                    <div class="md:px-8 mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="ja_name" class="leading-7 text-sm text-gray-600 font-bold">日本語名前</label>
                                    <span class="text-sm text-red-500">*</span>
                                    <input type="text" id="ja_name" name="ja_name" v-model="form.ja_name"
                                        class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="en_name" class="leading-7 text-sm text-gray-600 font-bold">英語名前</label>
                                    <span class="text-sm text-red-500">*</span>
                                    <input type="text" id="en_name" name="en_name" v-model="form.en_name"
                                        class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="ja_description"
                                        class="leading-7 text-sm text-gray-600 font-bold">日本語説明</label>
                                    <span class="text-sm text-red-500">*</span>
                                    <textarea id="ja_description" name="ja_description" v-model="form.ja_description"
                                        class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="en_description"
                                        class="leading-7 text-sm text-gray-600 font-bold">英語説明</label>
                                    <span class="text-sm text-red-500">*</span>
                                    <textarea id="en_description" name="en_description" v-model="form.en_description"
                                        class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="created_by"
                                        class="leading-7 text-sm text-gray-600 font-bold">作成者</label>
                                    <input type="text" id="created_by" name="created_by" v-model="form.created_by"
                                        class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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

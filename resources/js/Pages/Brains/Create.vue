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
        <form @submit.prevent="storeBrain">
            <div class="container px-5 py-8 mx-auto">
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div class="flex flex-wrap -m-2">
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">名前</label>
                                <input type="text" id="name" name="name" v-model="form.name"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                        </div>
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="description" class="leading-7 text-sm text-gray-600">説明</label>
                                <input type="text" id="description" name="description" v-model="form.description"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                        </div>

                        <div class="mt-4 w-full flex justify-center">
                            <button class="bg-emerald-500 text-white px-4 py-2 rounded-md font-bold">作成</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </BasicLayout>
</template>

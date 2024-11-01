<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { nl2br } from '@/common';

const props = defineProps({
    brain: Object,
    messages: Object,
});

// const deleteBrain = (id) => {
//     router.delete(route('brains.destroy', { brain: id }));
// }
</script>

<template>

    <Head title="Brain" />

    <BasicLayout :messages="messages">

        <template #title>
            {{ messages.lang === 'ja' ? brain.ja_name : brain.en_name }}
        </template>

        <div class="w-4/5 md:w-2/5 mx-auto mt-4">
            <a :href="route('brains.index')" class="text-emerald-600 text-xs inline-block py-1">
                <i class="fa-solid fa-angle-left"></i>
                戻る
            </a>
            <div class="mt-2 bg-neutral-100 p-4 rounded-md shadow-sm border-2 border-neutral-300">
                <div class="p-2 w-full">
                    <div class="flex items-center gap-2">
                        <label for="id" class="leading-7 text-sm text-gray-700 font-bold">ID</label>
                        <div id="id" class="w-full  text-base outline-none text-gray-700 py-1 leading-8">
                            {{ brain.id }}
                        </div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <div>
                        <label for="ja_ame" class="leading-7 text-sm text-gray-700 font-bold">日本語名前</label>
                        <div id="ja_name" class="w-full  text-base outline-none text-gray-700 py-1">
                            {{ brain.ja_name }}
                        </div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <div>
                        <label for="en_name" class="leading-7 text-sm text-gray-700 font-bold">英語名前</label>
                        <div id="en_name" class="w-full  text-base outline-none text-gray-700 py-1">
                            {{ brain.en_name }}
                        </div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <div>
                        <label for="ja_description" class="leading-7 text-sm text-gray-700 font-bold">日本語説明</label>
                        <div id="ja_description" class="w-full  text-base outline-none text-gray-700 py-1" v-html="nl2br(brain.ja_description)"></div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <div>
                        <label for="en_description" class="leading-7 text-sm text-gray-700 font-bold">英語説明</label>
                        <div id="en_description" class="w-full  text-base outline-none text-gray-700 py-1" v-html="nl2br(brain.en_description)"></div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <div>
                        <label for="created_by" class="leading-7 text-sm text-gray-700 font-bold">作成者</label>
                        <div id="created_by" class="w-full  text-base outline-none text-gray-700 py-1">
                            {{ brain.created_by }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center items-center gap-4 mt-6">
                <Link as="button" :href="route('brains.edit', { brain: brain.id })"
                    class="bg-emerald-500 text-white px-4 py-2 rounded-md font-bold">
                編集する
                </Link>
                <!-- <button @click="deleteBrain(brain.id)"
                    class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md font-bold">
                    削除する
                </button> -->
            </div>
        </div>
    </BasicLayout>
</template>
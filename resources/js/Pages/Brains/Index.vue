<script setup>
import { Head, Link } from '@inertiajs/vue3';
import BasicLayout from '@/Layouts/BasicLayout.vue';

defineProps({
    brains: Object,
});
</script>

<template>

    <Head title="Brains" />
    <BasicLayout>
        <template #title>
            Brains
        </template>
        <div class="w-4/5 mx-auto mt-4">
            <template v-for="(brain, i) in brains" :key="i">
                <a :href="route('brains.records', brain.id)">
                    <div
                        class="bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm flex justify-between items-center gap-8">
                        <div>
                            <div class="text-lg font-bold mb-1">{{ brain.name }}</div>
                            <div class="text-sm">{{ brain.description }}</div>
                        </div>
                        <i class="fa-solid fa-angle-right text-xl text-emerald-600"></i>
                    </div>
                </a>

                <div class="text-right" v-if="$page.props.auth.user">
                    <a :href="route('brains.show', brain.id)" class="text-emerald-600 text-xs inline-block py-1 px-2">
                        編集
                    </a>
                </div>
                <div class="mb-4"></div>
            </template>
        </div>
        <div class="fixed bottom-4 right-4" v-if="$page.props.auth.user">
            <Link as="button" :href="route('brains.create')"
                class="bg-emerald-500 text-white text-2xl rounded-md font-bold md:w-16 md:h-16 w-12 h-12 flex items-center justify-center">
            +
            </Link>
        </div>
    </BasicLayout>
</template>

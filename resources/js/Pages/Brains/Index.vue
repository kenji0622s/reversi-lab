<script setup>
import { Head } from '@inertiajs/vue3';
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Link } from '@inertiajs/vue3';

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
        <div class="w-3/5 mx-auto mt-4 py-2 px-4 bg-white border border-neutral-300 shadow-sm rounded-md">
            <table class="text-center w-full">
                <thead>
                    <tr>
                        <th class="w-4 py-1">ID</th>
                        <th class="w-24">名前</th>
                        <!-- <th>説明</th> -->
                        <th class="w-4" v-if="$page.props.auth.user"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brain in brains" :key="brain.id">
                        <td class="py-1">
                            <Link :href="route('brains.records', brain.id)" class="text-blue-600">
                                {{ brain.id }}
                            </Link>
                        </td>
                        <td>{{ brain.name }}</td>
                        <!-- <td>{{ brain.description }}</td> -->
                        <td v-if="$page.props.auth.user">
                            <Link :href="route('brains.show', brain.id)" class="text-emerald-500 text-sm">
                                <i class="fa-solid fa-arrow-right"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="fixed bottom-4 right-4" v-if="$page.props.auth.user">
            <Link as="button" :href="route('brains.create')" class="bg-emerald-500 text-white text-2xl rounded-md font-bold md:w-16 md:h-16 w-12 h-12 flex items-center justify-center">
                +
            </Link>
        </div>
    </BasicLayout>
</template>

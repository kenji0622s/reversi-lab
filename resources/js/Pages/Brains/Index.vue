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
        <div class="w-fit mx-auto">
            <table class="text-center">
                <thead>
                    <tr>
                        <th class="w-4">ID</th>
                        <th class="w-24">名前</th>
                        <th class="w-24">説明</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brain in brains" :key="brain.id">
                        <td>
                            <Link :href="route('brains.show', brain.id)" class="text-blue-600">
                                {{ brain.id }}
                            </Link>
                        </td>
                        <td>{{ brain.name }}</td>
                        <td>{{ brain.description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </BasicLayout>
</template>

<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    records: Array,
});
</script>

<template>
    <BasicLayout :messages="messages">
        <template #title>
            Records
        </template>
        <div class="w-fit mx-auto mt-4">
            <table class="text-center">
                <thead>
                    <tr>
                        <th class="w-4">ID</th>
                        <th class="w-24">黒</th>
                        <th class="w-24">白</th>
                        <th class="w-32">結果</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records" :key="record.id">
                        <td>{{ record.id }}</td>
                        <td>{{ record.black_player }}</td>
                        <td>{{ record.white_player }}</td>
                        <td>
                            <template v-if="record.count_black > record.count_white">
                                黒勝ち
                            </template>
                            <template v-else-if="record.count_black < record.count_white">
                                白勝ち
                            </template>
                            <template v-else>引き分け</template>
                            ({{ record.count_black }}:{{ record.count_white }})
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="fixed bottom-4 right-4" v-if="$page.props.auth.user">
            <Link as="button" :href="route('records.create')" class="bg-emerald-500 text-white text-2xl rounded-md font-bold md:w-16 md:h-16 w-12 h-12 flex items-center justify-center">
                +
            </Link>
        </div>
    </BasicLayout>
</template>

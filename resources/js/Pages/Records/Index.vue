<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';

defineProps({
    records: Array,
});
</script>

<template>
    <BasicLayout>
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
                        <td>{{ record.black_model }}</td>
                        <td>{{ record.white_model }}</td>
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
    </BasicLayout>
</template>

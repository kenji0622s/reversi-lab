<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';

defineProps({
    userRecords: Array,
});
</script>

<template>
    <BasicLayout>
        <template #title>
            Your Records
        </template>
        <div class="w-fit mx-auto mt-4">
            <table class="text-center">
                <thead>
                    <tr>
                        <th class="w-4">ID</th>
                        <th class="w-24">Brain</th>
                        <th class="w-32">Result</th>
                        <th class="w-32">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="userRecord in userRecords" :key="userRecord.id">
                        <td>{{ userRecord.id }}</td>
                        <td>{{ userRecord.brain.name }}</td>
                        <td>
                            <template v-if="userRecord.result === 'win'">
                                黒勝ち
                            </template>
                            <template v-else-if="userRecord.result === 'lose'">
                                白勝ち
                            </template>
                            <template v-else>引き分け</template>
                        </td>
                        <td>{{ userRecord.created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </BasicLayout>
</template>

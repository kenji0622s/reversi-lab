<script setup>
import { ref } from 'vue';
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Link } from '@inertiajs/vue3';
import dayjs from 'dayjs';
defineProps({
    users: Array,
    brainRecords: Array,
    userRecords: Array,
    messages: Object,
});

const showBrainRecordsFlag = ref(false);
const showUserRecordsFlag = ref(true);

</script>

<template>
    <BasicLayout :messages="messages">
        <template #title>
            Records
        </template>

        <div class="w-11/12 md:w-2/5 mx-auto mt-4">
            <div class="flex items-center justify-center gap-4 mb-4 relative w-fit mx-auto">
                <button
                    class="border-2 border-neutral-300 py-2 px-4 rounded-md shadow-sm text-sm font-bold w-24 md:w-32"
                    :class="{ 'bg-emerald-500 text-white': showUserRecordsFlag, 'bg-neutral-100 text-neutral-900': !showUserRecordsFlag }"
                    @click="showBrainRecordsFlag = false; showUserRecordsFlag = true">Users</button>
                <button
                    class="border-2 border-neutral-300 py-2 px-4 rounded-md shadow-sm text-sm font-bold w-24 md:w-32"
                    :class="{ 'bg-emerald-500 text-white': showBrainRecordsFlag, 'bg-neutral-100 text-neutral-900': !showBrainRecordsFlag }"
                    @click="showBrainRecordsFlag = true; showUserRecordsFlag = false">Brains</button>
                <button class="absolute -right-12 p-2" onclick="window.location.reload()">
                    <i class="fa-solid fa-rotate-right text-lg text-emerald-600"></i>
                </button>
            </div>
            <div
                class="bg-neutral-100 border-2 border-neutral-300 p-4 md:p-6 rounded-md shadow-sm text-center text-sm md:text-base w-full md:w-11/12 mx-auto">
                <!-- ユーザーの対戦成績 -->
                <table class="w-full" v-if="showUserRecordsFlag">
                    <thead>
                        <tr class="bg-neutral-300">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Brain</th>
                            <th>Result</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="userRecord in userRecords" :key="userRecord.id" class="border-b border-neutral-300">
                            <td>{{ userRecord.id }}</td>
                            <td>
                                {{ users.find(user => user.id === userRecord.user_id)?.name || 'Guest' }}
                            </td>
                            <td>{{ userRecord.brain_id }}</td>
                            <td>
                                <template v-if="userRecord.user_discs > userRecord.brain_discs">
                                    勝ち
                                </template>
                                <template v-else-if="userRecord.user_discs === userRecord.brain_discs">
                                    引き分け
                                </template>
                                <template v-else>
                                    負け
                                </template>
                            </td>
                            <td>{{ dayjs(userRecord.created_at).format('MM/DD HH:mm') }}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- ブレインの対戦成績 -->
                <table class="w-full" v-if="showBrainRecordsFlag">
                    <thead>
                        <tr class="bg-neutral-300">
                            <th>ID</th>
                            <th>Brain</th>
                            <th>Opponent</th>
                            <th>Result</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="brainRecord in brainRecords" :key="brainRecord.id"
                            class="border-b border-neutral-300">
                            <td>{{ brainRecord.id }}</td>
                            <td>{{ brainRecord.brain_id }}</td>
                            <td>{{ brainRecord.opponent_id }}</td>
                            <td>
                                <template v-if="brainRecord.brain_discs > brainRecord.opponent_discs">
                                    勝ち
                                </template>
                                <template v-else-if="brainRecord.brain_discs < brainRecord.opponent_discs">
                                    負け
                                </template>
                                <template v-else>
                                    引き分け
                                </template>
                                <span class="text-sm">
                                    ({{ brainRecord.brain_discs }}:{{ brainRecord.opponent_discs }})
                                </span>
                            </td>
                            <td>{{ dayjs(brainRecord.created_at).format('MM/DD HH:mm') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="fixed bottom-4 right-4"
            v-if="$page.props.auth.user && $page.props.auth.user.is_admin && show_brains_flag">
            <Link as="button" :href="route('records.create')"
                class="bg-emerald-500 text-white text-2xl rounded-md font-bold md:w-16 md:h-16 w-12 h-12 flex items-center justify-center">
            +
            </Link>
        </div>
    </BasicLayout>
</template>

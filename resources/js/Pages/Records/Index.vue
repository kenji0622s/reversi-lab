<script setup>
import { ref } from 'vue';
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Link } from '@inertiajs/vue3';
import dayjs from 'dayjs';
defineProps({
    records: Array,
    userRecords: Array,
    messages: Object,
});

const show_brains_flag = ref(true);
const show_users_flag = ref(false);

</script>

<template>
    <BasicLayout :messages="messages">
        <template #title>
            Records
        </template>

        <div class="w-11/12 mx-auto mt-4">
            <div class="flex items-center justify-center gap-4 mb-4">
                <button class="border-2 border-neutral-300 py-2 px-4 rounded-md shadow-sm text-sm font-bold"
                    :class="{ 'bg-emerald-500 text-white':  show_brains_flag, 'bg-neutral-100 text-neutral-900': !show_brains_flag }"
                    @click="show_brains_flag = true; show_users_flag = false">Brains</button>
                <button class="border-2 border-neutral-300 py-2 px-4 rounded-md shadow-sm text-sm font-bold"
                    :class="{ 'bg-emerald-500 text-white': show_users_flag, 'bg-neutral-100 text-neutral-900': !show_users_flag }"
                    @click="show_brains_flag = false; show_users_flag = true">Users</button>
            </div>
            <div class="bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm text-center text-sm">
                <table class="w-full" v-if="show_brains_flag">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Black</th>
                            <th>White</th>
                            <th>Winner</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in records" :key="record.id">
                            <td>{{ record.id }}</td>
                            <td>{{ record.black_player }}</td>
                            <td>{{ record.white_player }}</td>
                            <td>
                                <template v-if="record.count_black > record.count_white">
                                    Black
                                </template>
                                <template v-else-if="record.count_black < record.count_white">
                                    White
                                </template>
                                <template v-else>-</template>
                                ({{ record.count_black }}:{{ record.count_white }})
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="w-full" v-if="show_users_flag">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>BrainID</th>
                            <th>Winner</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="userRecord in userRecords" :key="userRecord.id">
                            <td>{{ userRecord.id }}</td>
                            <td>{{ userRecord.user_id }}</td>
                            <td>{{ userRecord.brain_id }}</td>
                            <td>
                                <template v-if="userRecord.result == 'win'">
                                    user
                                </template>
                                <template v-else-if="userRecord.result == 'lose'">
                                    brain
                                </template>
                                <template v-else>-</template>
                             
                            </td>
                            <td>{{ dayjs(userRecord.created_at).format('YYYY/MM/DD') }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="fixed bottom-4 right-4" v-if="$page.props.auth.user && $page.props.auth.user.is_admin && show_brains_flag">
            <Link as="button" :href="route('records.create')"
                class="bg-emerald-500 text-white text-2xl rounded-md font-bold md:w-16 md:h-16 w-12 h-12 flex items-center justify-center">
            +
            </Link>
        </div>
    </BasicLayout>
</template>

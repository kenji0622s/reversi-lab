<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
    userRecords: Object,
    messages: Object,
});

// グループ化されたデータを配列に変換
const groupedRecords = Object.values(props.userRecords);
const groupedRecordsResult = [];
for (let i = 0; i < groupedRecords.length; i++) {
    let win = 0;
    let draw = 0;
    let lose = 0;
    for (let j = 0; j < groupedRecords[i].length; j++) {
        switch (groupedRecords[i][j].result) {
            case 'win':
                win++;
                break;
            case 'draw':
                draw++;
                break;
            case 'lose':
                lose++;
                break;
        }
    }
    groupedRecordsResult.push({
        'win': win,
        'draw': draw,
        'lose': lose,
        'rate': ((win / (win + draw + lose)) * 100).toFixed(2) + '%',
    });
}

const show_records_flag = ref(Array(groupedRecords.length).fill(false));
const show_records = (index) => {
    show_records_flag.value[index] = !show_records_flag.value[index];
}

const checked = ref(false);
</script>

<template>
    <BasicLayout :messages="messages">
        <template #title>
            <template v-if="$page.props.auth.user">
                My Records
            </template>
            <template v-else>
                Guest Records
            </template>
        </template>
        <div class="w-4/5 mx-auto mt-6">
            <div v-for="(group, brainId) in groupedRecords" :key="brainId"
                class="mb-4 bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm">
                <div @click="show_records(brainId)">
                    <p class="text-lg font-bold">vs {{ group[0].brain.name }}</p>
                    <p class="mb-2" v-if="messages.lang === 'ja'">{{ group[0].brain.description }}</p>
                    <p class="mb-2" v-else>{{ group[0].brain.description_en }}</p>
                    <div class="flex justify-between items-center">
                        <!-- <p class="font-bold">勝率 10%（ 12 勝 12 分 12 敗）</p> -->
                        <p class="font-bold">{{ messages.user_records.win_rate }} {{ groupedRecordsResult[brainId].rate }}
                            <span class="block text-sm">{{ messages.user_records.win }} {{ groupedRecordsResult[brainId].win }} | {{ messages.user_records.lose }} {{ groupedRecordsResult[brainId].lose }} | {{ messages.user_records.draw }} {{ groupedRecordsResult[brainId].draw }}</span>
                        </p>
                        <i class="fa-solid fa-angle-down text-lg text-emerald-500"
                            v-if="!show_records_flag[brainId]"></i>
                        <i class="fa-solid fa-angle-up text-lg text-emerald-500" v-else></i>
                    </div>

                </div>
                <table class="text-center mx-auto mt-4 w-full" v-if="show_records_flag[brainId]">
                    <thead>
                        <tr>
                            <th class="w-1/2">{{ messages.user_records.date }}</th>
                            <th class="w-1/2">{{ messages.user_records.result }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in group" :key="record.id">
                            <td>{{ dayjs(record.created_at).format('YYYY/MM/DD') }}</td>
                            <td>
                                <template v-if="record.result === 'win'">
                                    {{ messages.user_records.win }}
                                </template>
                                <template v-else-if="record.result === 'draw'">
                                    {{ messages.user_records.draw }}
                                </template>
                                <template v-else>
                                    {{ messages.user_records.lose }}
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="!$page.props.auth.user && !checked">
            <div class="w-full mt-16 h-[calc(100vh-4rem)] bg-neutral-300/90 absolute top-0 left-0">
                <div class="mt-24 p-8 w-4/5 mx-auto bg-white rounded-md">
                    <p class="mb-4 text-sm">
                        {{ messages.user_records.guest_modal_message }}
                    </p>
                    <div class="flex justify-center items-center gap-4">
                        <Link :href="route('login')" class="text-sm border-2 border-emerald-500 bg-emerald-500 text-white font-bold block mx-auto px-4 py-2 rounded-md w-1/2 text-center">
                            {{ messages.common.login }}
                        </Link>
                        <Link :href="route('register')" class="text-sm border-2 border-emerald-500 text-emerald-500 font-bold block mx-auto px-4 py-2 rounded-md w-1/2 text-center">
                            {{ messages.common.register }}
                        </Link>
                    </div>
                    <div class="mt-4 text-center">
                        <button class="text-emerald-600 text-xs font-bold" @click="checked = true">
                            {{ messages.user_records.guest_modal_link }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </BasicLayout>
</template>

<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
    userRecords: Object,
    messages: Object,
});

const userRecords = props.userRecords;
const userRecordKeys = Object.keys(props.userRecords);
const userRecordValues = Object.values(props.userRecords);

console.log('userRecords', userRecords);
console.log('userRecordKeys', userRecordKeys);
console.log('userRecordValues', userRecordValues);

const userRecordsResults = [];
for (let i = 0; i < userRecordKeys.length; i++) {
    let win = 0;
    let draw = 0;
    let lose = 0;
    for (let j = 0; j < userRecordValues[i].length; j++) {
        if (userRecordValues[i][j].user_discs > userRecordValues[i][j].brain_discs) {
            win++;
        } else if (userRecordValues[i][j].user_discs === userRecordValues[i][j].brain_discs) {
            draw++;
        } else {
            lose++;
        }
    }
    userRecordsResults.push({
        'win': win,
        'draw': draw,
        'lose': lose,
        'rate': ((win / (win + draw + lose)) * 100).toFixed(2) + '%',
    });
}


console.log('userRecordsResults', userRecordsResults);

const showUserRecordsFlag = ref(Array(userRecordKeys.length).fill(false));
const showUserRecords = (index) => {
    showUserRecordsFlag.value[index] = !showUserRecordsFlag.value[index];
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
        <div class="w-4/5 md:w-2/5 mx-auto mt-6">
            <div v-for="(opponentBrain, i) in userRecordValues" :key="i"
                class="mb-4 bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm">
                <div @click="showUserRecords(i)">
                    <p class="text-lg font-bold">vs {{ messages.lang === 'ja' ? opponentBrain[0].brain.ja_name : opponentBrain[0].brain.en_name }}</p>
                    <p class="mb-2">{{ messages.lang === 'ja' ? opponentBrain[0].brain.ja_description : opponentBrain[0].brain.en_description }}</p>
                    <div class="flex justify-between items-center">
                        <p class="font-bold">{{ messages.user_records.win_rate }} {{ userRecordsResults[i].rate }}
                            <span class="block text-sm">{{ messages.user_records.win }} {{ userRecordsResults[i].win }} | {{ messages.user_records.lose }} {{ userRecordsResults[i].lose }} | {{ messages.user_records.draw }} {{ userRecordsResults[i].draw }}</span>
                        </p>
                        <i class="fa-solid fa-angle-down text-lg text-emerald-500"
                            v-if="!showUserRecordsFlag[i]"></i>
                        <i class="fa-solid fa-angle-up text-lg text-emerald-500" v-else></i>
                    </div>

                </div>
                <table class="text-center mx-auto mt-4 w-full md:w-72" v-if="showUserRecordsFlag[i]">
                    <thead>
                        <tr class="bg-neutral-300">
                            <th>check</th>
                            <th class="w-1/2">{{ messages.user_records.date }}</th>
                            <th class="w-1/2">{{ messages.user_records.result }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in opponentBrain" :key="record.id" class="border-b border-neutral-300">
                            <td>{{ record.user_id }} vs {{ record.brain_id }}</td>
                            <td>{{ dayjs(record.created_at).format('YYYY/MM/DD') }}</td>
                            <td>
                                <template v-if="record.user_discs > record.brain_discs">
                                    {{ messages.user_records.win }}
                                </template>
                                <template v-else-if="record.user_discs === record.brain_discs">
                                    {{ messages.user_records.draw }}
                                </template>
                                <template v-else>
                                    {{ messages.user_records.lose }}
                                </template>
                                <span class="text-sm">({{ record.user_discs }}:{{ record.brain_discs }})</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="!$page.props.auth.user && !checked">
            <div class="w-full mt-16 h-[calc(100vh-4rem)] bg-neutral-100/95  absolute top-0 left-0">
                <div class="mt-24 p-8 w-4/5 md:w-96 mx-auto bg-neutral-100 border-2 border-neutral-400 shadow-md rounded-md">
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

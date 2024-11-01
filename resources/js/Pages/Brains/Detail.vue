<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { ref } from 'vue';
import { nl2br } from '@/common';

const props = defineProps({
    brain: Object,
    brains: Object,
    brainRecords: Object,
    userRecords: Object,
    messages: Object,
});

const brain = props.brain;
const brains = props.brains;
const brainRecords = props.brainRecords;
const brainRecordKeys = Object.keys(brainRecords);
const brainRecordsValues = Object.values(brainRecords);
const userRecords = props.userRecords;
let vsUserResult;
let vsUserWin = 0;
let vsUserDraw = 0;
let vsUserLose = 0;

for (let i = 0; i < userRecords.length; i++) {
    if (userRecords[i].brain_discs > userRecords[i].user_discs) {
        vsUserWin++;
    } else if (userRecords[i].brain_discs === userRecords[i].user_discs) {
        vsUserDraw++;
    } else {
        vsUserLose++;
    }
}
vsUserResult = {
    'win': vsUserWin,
    'draw': vsUserDraw,
    'lose': vsUserLose,
    'rate': ((vsUserWin / (vsUserWin + vsUserDraw + vsUserLose)) * 100).toFixed(2) + '%',
};

const showVsUserRecordsFlag = ref(false);
const brainResults = [];
for (let i = 0; i < brains.length; i++) {
    let win = 0;
    let draw = 0;
    let lose = 0;
    let games = 0;
    if (brainRecordsValues[i]) {
        for (let j = 0; j < brainRecordsValues[i].length; j++) {
            games++;
            if (
                brainRecordsValues[i][j].brain_discs > brainRecordsValues[i][j].opponent_discs
            ) {
                win++;
            } else if (brainRecordsValues[i][j].brain_discs === brainRecordsValues[i][j].opponent_discs) {
                draw++;
            } else {
                lose++;
            }
        }
    }
        brainResults.push({
            'key': brainRecordKeys[i],
            'win': win,
            'draw': draw,
            'lose': lose,
            'rate': ((win / games) * 100).toFixed(2) + '%',
            'games': games,
        });
}

console.log('brainResults', brainResults);

const showBrainRecordsFlag = ref(Array(brainRecordKeys.length).fill(false));
const showBrainRecords = (index) => {
    showBrainRecordsFlag.value[index] = !showBrainRecordsFlag.value[index];
}

</script>

<template>

    <Head :title="`${brain.name} Records`" />

    <BasicLayout :messages="messages">
        <template #title>
            {{ messages.lang === 'ja' ? brain.ja_name : brain.en_name }} Records
        </template>
        <div class="w-4/5 md:w-2/5 mx-auto">

            <a :href="route('brains.index')" class="text-emerald-600 text-xs inline-block py-1 mt-2">
                <i class="fa-solid fa-angle-left"></i>
                {{ messages.common.back }}
            </a>

            <div class="mb-4">
                <div class="text-lg font-bold">{{ messages.lang === 'ja' ? brain.ja_name : brain.en_name }}</div>
                <div v-if="messages.lang === 'ja'" v-html="nl2br(brain.ja_description)"></div>
                <div v-else v-html="nl2br(brain.en_description)"></div>
            </div>

            <!-- ユーザーとの対戦成績 -->
            <div class="mb-4 bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm">
                <div @click="showVsUserRecordsFlag = !showVsUserRecordsFlag">
                    <p class="text-lg font-bold">vs {{ messages.brains.human }}</p>
                    <div class="flex justify-between items-center">
                        <p class="font-bold">{{ messages.brains.win_rate }} {{ vsUserResult.rate }}
                            <span class="block text-sm">{{ messages.brains.win }} {{ vsUserResult.win }} | {{
                                messages.brains.lose }} {{ vsUserResult.lose }} | {{ messages.brains.draw }} {{
                                    vsUserResult.draw }}</span>
                        </p>
                        <i class="fa-solid fa-angle-down text-lg text-emerald-500" v-if="!showVsUserRecordsFlag"></i>
                        <i class="fa-solid fa-angle-up text-lg text-emerald-500" v-else></i>
                    </div>
                </div>

                <div v-if="showVsUserRecordsFlag">
                    <table class="text-center mx-auto mt-4 w-full md:w-72">
                        <thead>
                            <tr class="bg-neutral-300">
                                <th class="w-1/2">{{ messages.brains.date }}</th>
                                <th class="w-1/2">{{ messages.brains.result }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="userRecord in userRecords" :key="userRecord.id"
                                class="border-b border-neutral-300">
                                <td>{{ dayjs(userRecord.created_at).format('YYYY/MM/DD') }}</td>
                                <td>
                                    <template v-if="userRecord.brain_discs > userRecord.user_discs">
                                        {{ messages.brains.win }}
                                    </template>
                                    <template v-else-if="userRecord.brain_discs === userRecord.user_discs">
                                        {{ messages.brains.draw }}
                                    </template>
                                    <template v-else>
                                        {{ messages.brains.lose }}
                                    </template>
                                    <span class="text-sm">({{ userRecord.brain_discs }}:{{ userRecord.user_discs
                                        }})</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ブレイン同士の対戦成績 -->
            <div v-for="(opponentBrain, i) in brains" :key="i"
                class="mb-4 bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm">
                <div @click="showBrainRecords(i)">
                    <p class="text-lg font-bold">vs {{ messages.lang === 'ja' ? opponentBrain.ja_name :
                        opponentBrain.en_name }}
                    </p>
                    <div v-if="messages.lang === 'ja'" v-html="nl2br(opponentBrain.ja_description)"></div>
                    <div v-else v-html="nl2br(opponentBrain.en_description)"></div>
                    <div class="flex justify-between items-center" v-if="brainResults[i].games > 0">
                        <p class="font-bold">{{ messages.brains.win_rate }} {{ brainResults[i].rate }}
                            <span class="block text-sm">{{ messages.brains.win }} {{ brainResults[i].win }} | {{
                                messages.brains.lose }} {{ brainResults[i].lose }} | {{ messages.brains.draw }} {{
                                    brainResults[i].draw }}</span>
                        </p>
                        <i class="fa-solid fa-angle-down text-lg text-emerald-500" v-if="!showBrainRecordsFlag[i]"></i>
                        <i class="fa-solid fa-angle-up text-lg text-emerald-500" v-else></i>
                    </div>
                    <p class="text-sm" v-else>
                        {{ messages.brains.no_record }}
                    </p>

                </div>
                <table class="text-center mx-auto w-full mt-4 md:w-72" v-if="showBrainRecordsFlag[i]">
                    <thead>
                        <tr class="bg-neutral-300">
                            <!-- <th>check</th> -->
                            <th class="w-1/2">{{ messages.brains.turn }}</th>
                            <th class="w-1/2">{{ messages.brains.result }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="brainRecord in brainRecords[i + 1]" :key="brainRecord.id"
                            class="border-b border-neutral-300">
                            <!-- <td>{{ brainRecord.brain_id }} vs {{ brainRecord.opponent_id }}</td> -->
                            <td>{{ brainRecord.is_first ? messages.brains.first_turn : messages.brains.second_turn }}
                            </td>
                            <td>
                                <template v-if="brainRecord.brain_discs > brainRecord.opponent_discs">
                                    {{ messages.brains.win }}
                                </template>
                                <template v-else-if="brainRecord.brain_discs === brainRecord.opponent_discs">
                                    {{ messages.brains.draw }}
                                </template>
                                <template v-else>
                                    {{ messages.brains.lose }}
                                </template>
                                <span class="text-sm">({{ brainRecord.brain_discs }}:{{
                                    brainRecord.opponent_discs }})</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </BasicLayout>
</template>

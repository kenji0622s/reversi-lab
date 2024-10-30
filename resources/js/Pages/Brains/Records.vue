<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { ref } from 'vue';
import { nl2br } from '@/common';

const props = defineProps({
    brain: Object,
    records: Object,
    other_brains: Object,
    userRecords: Object,
    messages: Object,
});

const brain = props.brain;
const records = props.records;
const other_brains = props.other_brains;
const userRecords = props.userRecords;
let humanResult;
let human_win = 0;
let human_draw = 0;
let human_lose = 0;
for (let i = 0; i < userRecords.length; i++) {
    console.log(userRecords[i])
    if (userRecords[i].result === 'win') {
        human_lose++;
    } else if (userRecords[i].result === 'draw') {
        human_draw++;
    } else {
        human_win++;
    }
}
humanResult = {
    'win': human_win,
    'draw': human_draw,
    'lose': human_lose,
    'rate': ((human_win / (human_win + human_draw + human_lose)) * 100).toFixed(2) + '%',
};
const show_human_records_flag = ref(false);

const result = [];
for (let i = 0; i < records.length; i++) {
    let win = 0;
    let draw = 0;
    let lose = 0;
    for (let j = 0; j < records[i].length; j++) {
        if (
            records[i][j].black_player === brain.name && records[i][j].count_black > records[i][j].count_white ||
            records[i][j].white_player === brain.name && records[i][j].count_white > records[i][j].count_black
        ) {
            win++;
        } else if (records[i][j].count_black === records[i][j].count_white) {
            draw++;
        } else {
            lose++;
        }
    }
    result.push({
        'win': win,
        'draw': draw,
        'lose': lose,
        'rate': ((win / (win + draw + lose)) * 100).toFixed(2) + '%',
    });
}

console.log(result);

const show_records_flag = ref(Array(other_brains.length).fill(false));
console.log(show_records_flag);
const show_records = (index) => {
    show_records_flag.value[index] = !show_records_flag.value[index];
}

</script>

<template>

    <Head :title="`${brain.name} Records`" />

    <BasicLayout :messages="messages">
        <template #title>
            {{ brain.name }} Records
        </template>
        <div class="w-4/5 mx-auto">

            <a :href="route('brains.index')" class="text-emerald-600 text-xs inline-block py-1 mt-2">
                <i class="fa-solid fa-angle-left"></i>
                {{ messages.common.back }}
            </a>

            <div class="mb-4">
                <div class="text-lg font-bold">{{ brain.name }}</div>

                <div v-if="messages.lang === 'ja'" v-html="nl2br(brain.description)"></div>
                <div v-else v-html="nl2br(brain.description_en)"></div>
            </div>

            <div class="mb-4 bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm">
                <div @click="show_human_records_flag = !show_human_records_flag">
                    <p class="text-lg font-bold">vs {{ messages.brains.human }}</p>
                    <div class="flex justify-between items-center">
                        <p class="font-bold">{{ messages.brains.win_rate }} {{ humanResult.rate }}
                            <span class="block text-sm">{{ messages.brains.win }} {{ humanResult.win }} | {{ messages.brains.lose }} {{ humanResult.lose }} | {{ messages.brains.draw }} {{ humanResult.draw }}</span>
                        </p>
                        <i class="fa-solid fa-angle-down text-lg text-emerald-500" v-if="!show_human_records_flag"></i>
                        <i class="fa-solid fa-angle-up text-lg text-emerald-500" v-else></i>
                    </div>
                </div>

                <div v-if="show_human_records_flag">
                    <table class="text-center mx-auto mt-4 w-full">
                        <thead>
                            <tr>
                                <th class="w-1/2">{{ messages.brains.date }}</th>
                                <th class="w-1/2">{{ messages.brains.result }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="userRecord in userRecords" :key="userRecord.id">
                                <td>{{ dayjs(userRecord.created_at).format('YYYY/MM/DD') }}</td>
                                <td>
                                    <template v-if="userRecord.result === 'win'">
                                        {{ messages.brains.lose }}
                                    </template>
                                    <template v-else-if="userRecord.result === 'draw'">
                                        {{ messages.brains.draw }}
                                    </template>
                                    <template v-else>
                                        {{ messages.brains.win }}
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-for="(other_brain, i) in other_brains" :key="i"
                class="mb-4 bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm">
                <div @click="show_records(i)">
                    <p class="text-lg font-bold">vs {{ other_brain.name }}</p>
                    <div v-if="messages.lang === 'ja'" v-html="nl2br(other_brain.description)"></div>
                    <div v-else v-html="nl2br(other_brain.description_en)"></div>
                    <div class="flex justify-between items-center">
                        <p class="font-bold">{{ messages.brains.win_rate }} {{ result[i].rate }}
                            <span class="block text-sm">{{ messages.brains.win }} {{ result[i].win }} | {{ messages.brains.lose }} {{ result[i].lose }} | {{ messages.brains.draw }} {{ result[i].draw }}</span>
                        </p>
                        <i class="fa-solid fa-angle-down text-lg text-emerald-500" v-if="!show_records_flag[i]"></i>
                        <i class="fa-solid fa-angle-up text-lg text-emerald-500" v-else></i>
                    </div>

                </div>
                <table class="text-center mx-auto w-full mt-4" v-if="show_records_flag[i]">
                    <thead>
                        <tr>
                            <!-- <th class="w-4">ID</th> -->
                            <th class="w-1/2">{{ messages.brains.turn }}</th>
                            <th class="w-1/2">{{ messages.brains.result }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in records[i]" :key="record.id">
                            <!-- <td>{{ record.id }}</td> -->
                            <td>
                                <template v-if="record.black_player === brain.name">
                                    {{ messages.brains.first_turn }}
                                </template>
                                <template v-else>
                                    {{ messages.brains.second_turn }}
                                </template>
                            </td>
                            <td>
                                <template
                                    v-if="record.black_player === brain.name && record.count_black > record.count_white || record.white_player === brain.name && record.count_white > record.count_black">
                                    {{ messages.brains.win }}
                                </template>
                                <template v-else-if="record.count_black === record.count_white">
                                    {{ messages.brains.draw }}
                                </template>
                                <template v-else>
                                    {{ messages.brains.lose }}
                                </template>
                                <template v-if="record.black_player === brain.name">
                                    (<span class="font-bold">{{ record.count_black }}</span>:{{ record.count_white }})
                                </template>
                                <template v-else>
                                    ({{ record.count_black }}:<span class="font-bold">{{ record.count_white }}</span>)
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </BasicLayout>
</template>

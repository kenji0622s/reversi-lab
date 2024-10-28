<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    brain: Object,
    records: Object,
    other_brains: Object,
});

const brain = props.brain;
const records = props.records;
const other_brains = props.other_brains;

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

    <BasicLayout>
        <template #title>
            {{ brain.name }} Records
        </template>
        <div class="w-4/5 mx-auto">

            <div class="my-4">
                <div class="text-lg font-bold">{{ brain.name }}の戦略</div>
                <div>{{ brain.description }}</div>
            </div>

            <div v-for="(other_brain, i) in other_brains" :key="i"
                class="mb-4 bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm">
                <div @click="show_records(i)">
                    <p class="text-lg font-bold">vs {{ other_brain.name }}</p>
                    <p class="mb-2">{{ other_brain.description }}</p>
                    <div class="flex justify-between items-center">
                        <p class="font-bold">勝率{{ result[i].rate }}（{{
                            result[i].win
                        }}勝 {{ result[i].draw }}分 {{ result[i].lose }}敗）
                        </p>
                        <i class="fa-solid fa-angle-down text-lg text-emerald-500" v-if="!show_records_flag[i]"></i>
                        <i class="fa-solid fa-angle-up text-lg text-emerald-500" v-else></i>
                    </div>

                </div>
                <table class="text-center mx-auto mt-4" v-if="show_records_flag[i]">
                    <thead>
                        <tr>
                            <th class="w-4">ID</th>
                            <th class="w-24">ターン</th>
                            <th class="w-32">結果</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in records[i]" :key="record.id">
                            <td>{{ record.id }}</td>
                            <td>
                                <template v-if="record.black_player === brain.name">
                                    先行
                                </template>
                                <template v-else>
                                    後攻
                                </template>
                            </td>
                            <td>
                                <template
                                    v-if="record.black_player === brain.name && record.count_black > record.count_white || record.white_player === brain.name && record.count_white > record.count_black">
                                    勝ち
                                </template>
                                <template v-else-if="record.count_black === record.count_white">
                                    引き分け
                                </template>
                                <template v-else>
                                    負け
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

<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
    userRecords: Object,
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
    <BasicLayout>
        <template #title>
            My Records
        </template>
        <div class="w-4/5 mx-auto">

            <div class="my-4">
                <div class="text-lg font-bold">My Records</div>
            </div>

            <div v-for="(group, brainId) in groupedRecords" :key="brainId"
                class="mb-4 bg-neutral-100 border-2 border-neutral-300 p-4 rounded-md shadow-sm">
                <div @click="show_records(brainId)">
                    <p class="text-lg font-bold">vs {{ group[0].brain.name }}</p>
                    <p class="mb-2">{{ group[0].brain.description }}</p>
                    <div class="flex justify-between items-center">
                        <!-- <p class="font-bold">勝率 10%（ 12 勝 12 分 12 敗）</p> -->
                        <p class="font-bold">勝率{{ groupedRecordsResult[brainId].rate }}（{{
                            groupedRecordsResult[brainId].win
                        }}勝 {{ groupedRecordsResult[brainId].draw }}分 {{ groupedRecordsResult[brainId].lose }}敗）
                        </p>
                        <i class="fa-solid fa-angle-down text-lg text-emerald-500"
                            v-if="!show_records_flag[brainId]"></i>
                        <i class="fa-solid fa-angle-up text-lg text-emerald-500" v-else></i>
                    </div>

                </div>
                <table class="text-center mx-auto mt-4" v-if="show_records_flag[brainId]">
                    <thead>
                        <tr>
                            <th class="w-24">日付</th>
                            <th class="w-24">結果</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in group" :key="record.id">
                            <td>{{ dayjs(record.created_at).format('YYYY/MM/DD') }}</td>
                            <td>
                                <template v-if="record.result === 'win'">
                                    勝ち
                                </template>
                                <template v-else-if="record.result === 'draw'">
                                    引き分け
                                </template>
                                <template v-else>
                                    負け
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="!$page.props.auth.user && !checked">
            <div class="w-full h-screen bg-neutral-300/90 absolute top-0 left-0">
                <div class="mt-24 p-8 w-4/5 mx-auto bg-white rounded-md">
                    <p class="mb-4 text-sm">
                        ログイン・登録するとBrainとの対戦成績を確認できます。
                    </p>
                    <div class="flex justify-center items-center gap-4">
                        <Link :href="route('login')" class="text-sm border-2 border-emerald-500 bg-emerald-500 text-white font-bold block mx-auto px-4 py-2 rounded-md w-1/2 text-center">
                            ログイン
                        </Link>
                        <Link :href="route('register')" class="text-sm border-2 border-emerald-500 text-emerald-500 font-bold block mx-auto px-4 py-2 rounded-md w-1/2 text-center">
                            新規登録
                        </Link>
                    </div>
                    <div class="mt-4 text-center">
                        <button class="text-emerald-600 text-xs font-bold" @click="checked = true">
                            未登録ユーザーの対戦成績を見る
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </BasicLayout>
</template>

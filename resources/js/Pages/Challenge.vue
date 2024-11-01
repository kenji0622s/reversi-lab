<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import getAllDirectionCells from '../utils/getAllDirectionCells';
import singleDirectionReverse from '../utils/singleDirectionReverse';
import { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells } from '../utils/updateAvailableCells';
import { nl2br } from '@/common';

// { brain_id: strategy }の形でbrain.jsから取得
import { strategies } from '../strategies/brains';

const props = defineProps({
    user: Object,
    brains: Object,
    debug: Boolean,
    messages: Object,
});

//未登録ユーザーの場合はuserId2(Guest)として処理
const user = props.user;
let userId;
if (user) {
    userId = user.id;
} else {
    userId = 2;
}

const brains = props.brains;
const brain = ref(brains.find(brain => brain.id === 1));
let strategy;

const turns = ['black', 'white'];
//現在のターンを管理
const turn = ref(turns[0]);

//ユーザーのターン
const yourTurn = ref(turns[0]);
//ブレインのターン
const brainTurn = ref(turns[0]);

// ゲーム開始前のBrain選択・ターン選択
const isReady = ref(false);
const readyGame = () => {
    if (yourTurn.value === turns[0]) {
        brainTurn.value = turns[1];
    }
    strategy = strategies[brain.value.id];
    isReady.value = true;
    if (brainTurn.value === turns[0]) {
        const blackAvailableCellLength = blackAvailableCells.value.length;
        const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
        selectCell(blackAvailableCells.value[randomIndex]);
    }
}

const blackCells = ref([[4, 5], [5, 4]]);
const whiteCells = ref([[4, 4], [5, 5]]);
const usedCells = ref([[4, 4], [5, 5], [4, 5], [5, 4]]);
const availableCells = ref([]);
const blackAvailableCells = ref([[3, 4], [4, 3], [5, 6], [6, 5]]);
const whiteAvailableCells = ref([]);
const selectedCell = ref(null);
const isGameEnd = ref(false);
const isGameEndMessage = ref(false);
const gameEndMessage = ref(null);

const INTERVAL = 250;

let user_discs;
let brain_discs;
let isFirst;

const selectCell = (cell) => {
    selectedCell.value = cell;
    if (!usedCells.value.some(usedCell => usedCell[0] === selectedCell.value[0] && usedCell[1] === selectedCell.value[1])) {
        if (turn.value === turns[0]) {
            if (blackAvailableCells.value.some(blackAvailableCell => blackAvailableCell[0] === selectedCell.value[0] && blackAvailableCell[1] === selectedCell.value[1])) {
                blackCells.value.push(selectedCell.value);
                usedCells.value.push(selectedCell.value);
                const allDirectionCells = getAllDirectionCells(selectedCell.value);
                for (let i = 0; i < allDirectionCells.length; i++) {
                    singleDirectionReverse(allDirectionCells[i], blackCells.value, whiteCells.value, turn.value, turns);
                }
                updateAvailableCells(availableCells, usedCells);
                updateWhiteAvailableCells(whiteAvailableCells, availableCells, blackCells, whiteCells);
                updateBlackAvailableCells(blackAvailableCells, availableCells, blackCells, whiteCells);
                if (whiteAvailableCells.value.length > 0) {
                    turn.value = turns[1];
                    if (brainTurn.value === turns[1]) {
                        setTimeout(() => {
                            const answerCell = strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                            selectCell(answerCell);
                        }, INTERVAL);
                    }
                }
            }
        } else {
            if (whiteAvailableCells.value.some(whiteAvailableCell => whiteAvailableCell[0] === selectedCell.value[0] && whiteAvailableCell[1] === selectedCell.value[1])) {
                whiteCells.value.push(selectedCell.value);
                usedCells.value.push(selectedCell.value);
                const allDirectionCells = getAllDirectionCells(selectedCell.value);
                for (let i = 0; i < allDirectionCells.length; i++) {
                    singleDirectionReverse(allDirectionCells[i], blackCells.value, whiteCells.value, turn.value, turns);
                }
                updateAvailableCells(availableCells, usedCells);
                updateBlackAvailableCells(blackAvailableCells, availableCells, blackCells, whiteCells);
                updateWhiteAvailableCells(whiteAvailableCells, availableCells, blackCells, whiteCells);
                if (blackAvailableCells.value.length > 0) {
                    turn.value = turns[0];
                    if (brainTurn.value === turns[0]) {
                        setTimeout(() => {
                            const answerCell = strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                            selectCell(answerCell);
                        }, INTERVAL);
                    }
                }
            }
        }
    }
    if (blackAvailableCells.value.length === 0 && whiteAvailableCells.value.length === 0 && usedCells.value.length > 4) {
        isGameEnd.value = true;
        isGameEndMessage.value = true;

        if (yourTurn.value === turns[0]) {
            user_discs = blackCells.value.length;
            brain_discs = whiteCells.value.length;
            isFirst = true;
        } else {
            user_discs = whiteCells.value.length;
            brain_discs = blackCells.value.length;
            isFirst = false;
        }

        if (user_discs > brain_discs) {
            gameEndMessage.value = props.messages.challenge.game_end_message_win;
        } else if (user_discs === brain_discs) {
            gameEndMessage.value = props.messages.challenge.game_end_message_draw;
        } else {
            gameEndMessage.value = props.messages.challenge.game_end_message_lose;
        }

        //データを保存
        try {
            router.post('/user-records', {
                user_id: userId,
                brain_id: brain.value.id,
                user_discs: user_discs,
                brain_discs: brain_discs,
                is_first: isFirst,
            });
        } catch (error) {
            console.error(error);
        }

    }
}



</script>

<template>

    <Head title="Challenge" />

    <BasicLayout :messages="messages">
        <template #title>
            Challenge<span class="text-sm ml-2" v-if="isReady">vs {{ messages.lang === 'ja' ? brain.ja_name :
                brain.en_name }}</span>
        </template>

        <!-- <div class="relative">
                <h2 class="text-center text-2xl font-bold bg-neutral-200 py-2 border-b-2 border-emerald-500">Play Mode</h2>
            <a href="/watch" class="absolute top-1/2 right-4 -translate-y-1/2 text-sm">Watch Mode</a>
        </div> -->

        <div class="text-center mt-4">
            <span class="text-xl font-bold">{{ (turn === turns[0] && yourTurn === turns[0]) || (turn === turns[1]
                &&
                yourTurn === turns[1]) ? messages.challenge.your_turn : messages.challenge.brain_turn }}</span>
        </div>

        <div class="text-center mb-2">
            {{ messages.common.black }}: {{ blackCells.length }} | {{ messages.common.white }}: {{ whiteCells.length }}
        </div>

        <div class="grid grid-cols-8 w-80 md:w-96 aspect-square border border-black bg-emerald-500 mx-auto">
            <template v-for="row in 8">
                <template v-for="column in 8">
                    <div :id="[row, column]" class="w-full h-full border border-gray-500 relative"
                        @click="(!isGameEnd && ((turn === yourTurn) || (brainTurn === turn))) && selectCell([row, column])">
                        <span v-if="whiteCells.some(cell => cell[0] === row && cell[1] === column)"
                            class="w-4/5 h-4/5 rounded-full bg-neutral-50 text-[10px] text-black flex justify-center items-center absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                            <!-- {{ row }},{{ column }} -->
                        </span>
                        <span v-else-if="blackCells.some(cell => cell[0] === row && cell[1] === column)"
                            class="w-4/5 h-4/5 rounded-full bg-neutral-950 text-[10px] text-white flex justify-center items-center absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                            <!-- {{ row }},{{ column }} -->
                        </span>
                        <span
                            v-else-if="whiteAvailableCells.some(whiteAvailableCell => whiteAvailableCell[0] === row && whiteAvailableCell[1] === column) && turn === 'white'"
                            :class="['w-4/5', 'h-4/5', 'text-[10px]', 'text-black', 'flex', 'justify-center', 'items-center', 'absolute', 'top-1/2', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', turn === 'white' ? 'bg-amber-200 opacity-70' : '']">
                            <!-- {{ row }},{{ column }} -->
                        </span>
                        <span
                            v-else-if="blackAvailableCells.some(blackAvailableCell => blackAvailableCell[0] === row && blackAvailableCell[1] === column) && turn === 'black'"
                            :class="['w-4/5', 'h-4/5', 'text-[10px]', 'text-black', 'flex', 'justify-center', 'items-center', 'absolute', 'top-1/2', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', turn === 'black' ? 'bg-amber-200 opacity-70' : '']">
                            <!-- {{ row }},{{ column }} -->
                        </span>
                        <span v-else class="w-full h-full text-[10px] text-black flex justify-center items-center">
                            <!-- {{ row }},{{ column }} -->
                        </span>
                    </div>
                </template>
            </template>
        </div>


        <div class="absolute top-40 left-0 w-full z-30 text-center" v-if="isGameEnd && isGameEndMessage">
            <div
                class="w-4/5 md:w-[32rem] mx-auto bg-neutral-100 border-2 border-neutral-400 shadow-md rounded-md pt-16 pb-12 relative text-neutral-900">
                <p class="text-center font-bold mb-4">{{ messages.challenge.you }} {{ user_discs }} :  AI {{ brain_discs }}</p>
                <p class="text-center font-bold mb-6" v-html="nl2br(gameEndMessage)"></p>
                <button @click="resetGame" onclick="window.location.reload()"
                    class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md font-bold">{{
                        messages.challenge.again }}</button>
                <i class="fa-solid fa-xmark absolute top-2 right-4 text-xl cursor-pointer" @click="isGameEndMessage = false"></i>
            </div>
        </div>

        <div class="text-center mt-8" v-if="isGameEnd && !isGameEndMessage">
    <button @click="resetGame" onclick="window.location.reload()"
                    class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md font-bold">{{
                        messages.challenge.again }}</button>
   </div>

        <div v-if="debug">
            <table class="text-left">
                <tr>
                    <th>turn</th>
                    <td>{{ turn }}</td>
                </tr>
                <tr>
                    <th>usedCells</th>
                    <td>{{ usedCells }}</td>
                </tr>
                <tr>
                    <th>availableCells</th>
                    <td>{{ availableCells }}</td>
                </tr>
                <tr>
                    <th>blackAvailableCells</th>
                    <td>{{ blackAvailableCells }}</td>
                </tr>
                <tr>
                    <th>whiteAvailableCells</th>
                    <td>{{ whiteAvailableCells }}</td>
                </tr>
            </table>
        </div>

        <div v-if="!isReady" class="w-full mt-16 h-[calc(100vh-4rem)] bg-neutral-100/95 absolute top-0 left-0">
            <div
                class="mt-16 p-8 w-4/5 md:w-96 mx-auto bg-neutral-100 border-2 border-neutral-400 shadow-md rounded-md">
                <div class="mb-4">
                    <label for="brain" class="block text-sm font-medium leading-6 text-gray-900">{{
                        messages.challenge.select_brain }}</label>
                    <select v-model="brain"
                        class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                        <option v-for="brain in brains" :value="brain">
                            {{ messages.lang === 'ja' ? brain.ja_name : brain.en_name }}
                        </option>
                    </select>
                    <div class="mt-2 bg-white py-2 px-4 rounded-md text-xs">
                        <p v-if="messages.lang === 'ja'" v-html="nl2br(brain.ja_description)"></p>
                        <p v-else v-html="nl2br(brain.en_description)"></p>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="yourTurn" class="block text-sm font-medium leading-6 text-gray-900">{{
                        messages.challenge.select_turn }}</label>
                    <select v-model="yourTurn"
                        class="text-sm block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                        <option v-for="turn in turns" :value="turn">{{ turn === 'black' ?
                            messages.challenge.select_turn_black :
                            messages.challenge.select_turn_white }}</option>
                    </select>
                </div>

                <button @click="readyGame"
                    class="bg-emerald-500 text-white font-bold block mx-auto px-4 py-2 rounded-md">{{
                        messages.challenge.game_start }}</button>
            </div>
        </div>

    </BasicLayout>
</template>

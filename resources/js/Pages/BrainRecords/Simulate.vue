<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import getAllDirectionCells from '@/utils/getAllDirectionCells';
import singleDirectionReverse from '@/utils/singleDirectionReverse';
import { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells } from '@/utils/updateAvailableCells';
import Board from '@/Components/Board.vue';
import { nl2br } from '@/common';
import { strategies } from '@/strategies/brains';

const props = defineProps({
    brains: Object,
    debug: Boolean,
    messages: Object,
});

const turns = ['black', 'white'];
const turn = ref(turns[0]);
const blackCells = ref([[4, 5], [5, 4]]);
const whiteCells = ref([[4, 4], [5, 5]]);
const usedCells = ref([[4, 4], [5, 5], [4, 5], [5, 4]]);
const availableCells = ref([]);
const blackAvailableCells = ref([[3, 4], [4, 3], [5, 6], [6, 5]]);
const whiteAvailableCells = ref([]);
const selectedCell = ref(null);
const isGameStart = ref(false);
const isGameEnd = ref(false);
const gameEndMessage = ref('');
;
const countGames = ref(0);
const MAX_GAMES = 10;
const INTERVAL = 1;

const brains = props.brains;

// function getBrain1() {
//     brain1.value = brain1.;
// }
// function getBrain2() {
//     brain2.value = brain2.value.id;
// }

const brain1 = ref(brains.find(brain => brain.id === 1));
const brain2 = ref(brains.find(brain => brain.id === 2));

function test() {
    console.log(brain1.value);
}

// const brain1Id = ref(1);
// const brain2Id = ref(2);
// const brain1 = ref(brains.find(brain => brain.id === brain1Id.value));
// const brain2 = ref(brains.find(brain => brain.id === brain2Id.value));

let brain1Strategy;
let brain2Strategy;

function startGame() {
    if (countGames.value === 0) {
        isGameStart.value = true;
    }
    countGames.value++;
    const blackAvailableCellLength = blackAvailableCells.value.length;
    const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
    selectCell(blackAvailableCells.value[randomIndex]);
}

function reStartGame() {
    if (countGames.value === MAX_GAMES) {
        return;
    }
    turn.value = turns[0];
    blackCells.value = [[4, 5], [5, 4]];
    whiteCells.value = [[4, 4], [5, 5]];
    usedCells.value = [[4, 4], [5, 5], [4, 5], [5, 4]];
    availableCells.value = [];
    blackAvailableCells.value = [[3, 4], [4, 3], [5, 6], [6, 5]];
    whiteAvailableCells.value = [];
    selectedCell.value = null;
    isGameEnd.value = false;
    gameEndMessage.value = '';
    startGame();
}


function storeRecords() {
    console.log(results);
    router.post('/brain-records', {
        results: results
    });
}
const isReady = ref(false);
const readyGame = () => {
    isReady.value = true;
}

const isCheckExplain = ref(false);
const checkExplain = () => {
    isCheckExplain.value = true;
    brain1Strategy = strategies[brain1.value.id];
    brain2Strategy = strategies[brain2.value.id];
    startGame();
}

const countBrain1Wins = ref(0);
const countBrain2Wins = ref(0);
const countDraws = ref(0)

const results = [];
const selectCell = (cell) => {
    if (blackAvailableCells.value.length === 0 && whiteAvailableCells.value.length === 0 && usedCells.value.length > 4) {
        if (blackCells.value.length > whiteCells.value.length) {
            countBrain1Wins.value++;
        } else if (blackCells.value.length < whiteCells.value.length) {
            countBrain2Wins.value++;
        } else {
            countDraws.value++;
        }
        const blackCellsLength = blackCells.value.length;
        const whiteCellsLength = whiteCells.value.length;
        results.push({ 'brain_id': brain1.value.id, 'opponent_id': brain2.value.id, 'brain_discs': blackCellsLength, 'opponent_discs': whiteCellsLength, 'is_first': true });
        isGameEnd.value = true;
        reStartGame();
        return;
    }
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
                updateWhiteAvailableCells(whiteAvailableCells, availableCells, blackCells, whiteCells, turn, turns);
                updateBlackAvailableCells(blackAvailableCells, availableCells, blackCells, whiteCells, turn, turns);
                setTimeout(() => {
                    if (whiteAvailableCells.value.length > 0) {
                        turn.value = turns[1];
                        const answerCell = brain1Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    } else {
                        const answerCell = brain2Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    }
                }, INTERVAL);
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
                updateBlackAvailableCells(blackAvailableCells, availableCells, blackCells, whiteCells, turn, turns);
                updateWhiteAvailableCells(whiteAvailableCells, availableCells, blackCells, whiteCells, turn, turns);
                setTimeout(() => {
                    if (blackAvailableCells.value.length > 0) {
                        turn.value = turns[0];
                        const answerCell = brain2Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    } else {
                        const answerCell = brain1Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    }
                }, INTERVAL);
            }
        }
    }
}

</script>

<template>

    <Head title="Simulation" />

    <BasicLayout :messages="messages">
        <template #title>
            Simulation
        </template>

        <div class="mt-4 mb-4">
          <p class="text-center text-lg font-bold">
              <span>{{ brain1.name }} 勝ち: {{ countBrain1Wins }}</span>
              <span> | </span>
              <span>{{ brain2.name }} 勝ち: {{ countBrain2Wins }}</span>
              <br>
              <span>引き分け: {{ countDraws }}</span>
            </p>
        </div>

        <!-- <div class="text-center mt-4 mb-4">
            <span class="font-bold">{{ messages.simulate.black_wins }}: {{ countBlackWins }} | {{
                messages.simulate.white_wins
                }}: {{ countWhiteWins }} | {{ messages.simulate.draws }}: {{ countDraws }}</span>
        </div> -->

        <Board :blackCells="blackCells" :whiteCells="whiteCells" :whiteAvailableCells="whiteAvailableCells"
            :blackAvailableCells="blackAvailableCells" :turn="turn" :debug="debug" />

        <div class="flex justify-center items-center gap-4 mt-6" v-if="countGames === 0">
            <button @click="startGame" class="bg-emerald-500 text-white px-4 py-2 rounded-md font-bold">{{
                messages.simulate.simulate_start }}</button>
        </div>
        <div class="flex justify-center items-center gap-4 mt-6" v-else-if="countGames === MAX_GAMES && isGameEnd">
            <button @click="storeRecords" class="bg-emerald-500 text-white px-4 py-2 rounded-md font-bold"
                v-if="$page.props.auth.user">{{ messages.simulate.store_records }}</button>
            <button @click="resetGame" onclick="window.location.reload()"
                class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md font-bold">{{
                    messages.simulate.simulate_reset }}</button>
        </div>
        <div class="text-center mt-4 mb-2 font-bold text-sm" v-else>
            <div class="mt-6 mb-4">{{ countGames }} {{ messages.simulate.games }} / {{ MAX_GAMES }} {{
                messages.simulate.games
                }}</div>
            <button @click="resetGame" onclick="window.location.reload()"
                class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md font-bold">{{
                    messages.simulate.simulate_stop }}</button>
        </div>

        <div v-if="!isReady || !isCheckExplain"
            class="w-full mt-16 h-[calc(100vh-4rem)] bg-neutral-100/95 absolute top-0 left-0">
            <div class="mt-12 p-8 w-4/5 md:w-96 mx-auto bg-neutral-100 border-2 border-neutral-400 shadow-md rounded-md">
                <div v-if="!isReady">
                    <div class="mb-4">
                        <label for="brain1" class="block text-sm font-medium leading-6 text-gray-900">{{
                            messages.simulate.select_black_brain }}</label>
                        <select v-model="brain1" @change="test"
                            class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                            <option v-for="brain in brains" :value="brain">{{ messages.lang === 'ja' ? brain.ja_name : brain.en_name }}</option>
                        </select>
                        <div class="mt-2 bg-white py-2 px-4 rounded-md text-xs">
                            <p v-if="messages.lang === 'ja'" v-html="nl2br(brain1.ja_description)"></p>
                            <p v-else v-html="nl2br(brain1.en_description)"></p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="brain2" class="block text-sm font-medium leading-6 text-gray-900">{{
                            messages.simulate.select_white_brain }}</label>
                        <select v-model="brain2" 
                            class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                            <option v-for="brain in brains" :value="brain">{{ messages.lang === 'ja' ? brain.ja_name : brain.en_name }}</option>
                        </select>
                        <div class="mt-2 bg-white py-2 px-4 rounded-md text-xs">
                            <p v-if="messages.lang === 'ja'" v-html="nl2br(brain2.ja_description)"></p>
                            <p v-else v-html="nl2br(brain2.en_description)"></p>
                        </div>
                    </div>

                    <button @click="readyGame"
                        class="bg-emerald-500 text-white font-bold block mx-auto px-4 py-2 rounded-md">{{
                            messages.simulate.ready_game }}</button>
                </div>
                <div v-if="!isCheckExplain && isReady">
                    <!-- <p class="mb-4 text-sm">{{ messages.simulate.check_explain }}</p> -->
                    <p class="mb-4 text-sm" v-html="nl2br(messages.simulate.check_explain)"></p>
                    <button @click="checkExplain"
                        class="bg-emerald-500 text-white font-bold block mx-auto px-4 py-2 rounded-md">{{
                            messages.simulate.simulate_start }}</button>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>

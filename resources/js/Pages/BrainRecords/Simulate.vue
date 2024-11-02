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
const MAX_GAMES = 300;
const INTERVAL = 1;

const brains = props.brains;

const brain1 = ref(brains.find(brain => brain.id === 1));
const brain2 = ref(brains.find(brain => brain.id === 2));

const brain1Turn = ref(turns[0]);
const brain2Turn = ref(turns[1]);

let brain1Strategy;
let brain2Strategy;

const isReady = ref(false);
const readyGame = () => {
    brain1Strategy = strategies[brain1.value.id];
    brain2Strategy = strategies[brain2.value.id];
    isReady.value = true;
}

const isCheckExplain = ref(false);
const checkExplain = () => {
    isCheckExplain.value = true;
    startGame();
}

function startGame() {
    if (countGames.value === 0) {
        isGameStart.value = true;
    }
    countGames.value++;
    console.log(countGames.value);
    const blackAvailableCellLength = blackAvailableCells.value.length;
    const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
    selectCell(blackAvailableCells.value[randomIndex]);
}

function reStartGame() {
    if (countGames.value === MAX_GAMES) {
        return;
    }
    turn.value = turns[0];
    if (brain1Turn.value === turns[0]) {
        brain1Turn.value = turns[1];
        brain2Turn.value = turns[0];
    } else {
        brain1Turn.value = turns[0];
        brain2Turn.value = turns[1];
    }
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
    router.post('/brain-records', {
        results: results
    });
}

const countBrain1Wins = ref(0);
const countBrain2Wins = ref(0);
const countDraws = ref(0)

const results = [];
const selectCell = (cell) => {
    if (blackAvailableCells.value.length === 0 && whiteAvailableCells.value.length === 0 && usedCells.value.length > 4) {
        let brain1Discs;
        let brain2Discs;
        if (brain1Turn.value === turns[0]) {
            brain1Discs = blackCells.value.length;
            brain2Discs = whiteCells.value.length;
        } else {
            brain1Discs = whiteCells.value.length;
            brain2Discs = blackCells.value.length;
        }
        if (brain1Discs > brain2Discs) {
            countBrain1Wins.value++;
        } else if (brain1Discs < brain2Discs) {
            countBrain2Wins.value++;
        } else {
            countDraws.value++;
        }
        if (brain1.value.id !== brain2.value.id) {
            results.push({ 'brain_id': brain1.value.id, 'opponent_id': brain2.value.id, 'brain_discs': brain1Discs, 'opponent_discs': brain2Discs, 'is_first': brain1Turn.value === turns[0] });
            results.push({ 'brain_id': brain2.value.id, 'opponent_id': brain1.value.id, 'brain_discs': brain2Discs, 'opponent_discs': brain1Discs, 'is_first': brain2Turn.value === turns[0] });
        } else {
            results.push({ 'brain_id': brain1.value.id, 'opponent_id': brain2.value.id, 'brain_discs': brain1Discs, 'opponent_discs': brain2Discs, 'is_first': brain1Turn.value === turns[0] });
        }
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
                        let answerCell;
                        if (brain1Turn.value === turns[1]) {
                            answerCell = brain1Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        } else {
                            answerCell = brain2Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        }
                        selectCell(answerCell);
                    } else {
                        let answerCell;
                        if (brain1Turn.value === turns[0]) {
                            answerCell = brain1Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        } else {
                            answerCell = brain2Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        }
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
                        let answerCell;
                        if (brain1Turn.value === turns[0]) {
                            answerCell = brain1Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        } else {
                            answerCell = brain2Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        }
                        selectCell(answerCell);
                    } else {
                        let answerCell;
                        if (brain1Turn.value === turns[1]) {
                            answerCell = brain1Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        } else {
                            answerCell = brain2Strategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        }
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
                <span>{{ messages.lang === 'ja' ? brain1.ja_name : brain1.en_name }} 勝ち: {{ countBrain1Wins }}</span>
                <span> | </span>
                <span>{{ messages.lang === 'ja' ? brain2.ja_name : brain2.en_name }} 勝ち: {{ countBrain2Wins }}</span>
                <br>
                <span>引き分け: {{ countDraws }}</span>
            </p>
        </div>

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
            <div
                class="mt-12 p-8 w-4/5 md:w-96 mx-auto bg-neutral-100 border-2 border-neutral-400 shadow-md rounded-md">
                <div v-if="!isReady">
                    <p class="mb-4 text-sm">{{ messages.simulate.select_brain }}</p>
                    <div>
                        <select v-model="brain1" @change="test"
                            class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                            <option v-for="brain in brains" :value="brain">{{ messages.lang === 'ja' ? brain.ja_name :
                                brain.en_name }}</option>
                        </select>
                        <div class="mt-2 bg-white py-2 px-4 rounded-md text-xs">
                            <p v-if="messages.lang === 'ja'" v-html="nl2br(brain1.ja_description)"></p>
                            <p v-else v-html="nl2br(brain1.en_description)"></p>
                        </div>
                    </div>
                    <div class="text-center text-lg font-extrabold my-4">vs</div>
                    <div class="mb-6">
                        <select v-model="brain2"
                            class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                            <option v-for="brain in brains" :value="brain">{{ messages.lang === 'ja' ? brain.ja_name :
                                brain.en_name }}</option>
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

        <div v-if="debug">
            <table class="text-left">
                <tbody>
                    <tr>
                        <th>turn</th>
                        <td>{{ turn }}</td>
                    </tr>
                    <tr>
                        <th>usedCells({{ usedCells.length }})</th>
                        <td>{{ usedCells }}</td>
                    </tr>
                    <tr>
                        <th>availableCells({{ availableCells.length }})</th>
                        <td>{{ availableCells }}</td>
                    </tr>
                    <tr>
                        <th>blackAvailableCells({{ blackAvailableCells.length }})</th>
                        <td>{{ blackAvailableCells }}</td>
                    </tr>
                    <tr>
                        <th>whiteAvailableCells({{ whiteAvailableCells.length }})</th>
                        <td>{{ whiteAvailableCells }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </BasicLayout>
</template>

<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import getAllDirectionCells from '@/utils/getAllDirectionCells';
import singleDirectionReverse from '@/utils/singleDirectionReverse';
import { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells } from '@/utils/updateAvailableCells';
import Board from '@/Components/Board.vue';

import { brains, strategies } from '@/strategies/brains';

const props = defineProps({
    brainsModels: Object,
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
const countBlackWins = ref(0);
const countWhiteWins = ref(0);
const countDraws = ref(0);
const countGames = ref(0);
const MAX_GAMES = 100;
const INTERVAL = 1;


const blackBrainModel = ref(props.brainsModels[0]);
const whiteBrainModel = ref(props.brainsModels[0]);
function getBlackBrainModel() {
    blackBrainModel.value = props.brainsModels[brains.indexOf(blackPlayer.value)];
}
function getWhiteBrainModel() {
    whiteBrainModel.value = props.brainsModels[brains.indexOf(whitePlayer.value)];
}

const blackPlayer = ref(brains[0]);
const whitePlayer = ref(brains[0]);
let blackPlayerStrategy;
let whitePlayerStrategy;

const results = [];
const selectCell = (cell) => {
    if (blackAvailableCells.value.length === 0 && whiteAvailableCells.value.length === 0 && usedCells.value.length > 4) {
        const blackCellsLength = blackCells.value.length;
        const whiteCellsLength = whiteCells.value.length;
        if (blackCellsLength > whiteCellsLength) {
            gameEndMessage.value = '黒の勝利';
            countBlackWins.value++;
        } else if (blackCellsLength < whiteCellsLength) {
            gameEndMessage.value = '白の勝利';
            countWhiteWins.value++;
        } else {
            gameEndMessage.value = '引き分け';
            countDraws.value++;
        }
        results.push({ 'black_player': blackPlayer.value, 'white_player': whitePlayer.value, 'count_black': blackCellsLength, 'count_white': whiteCellsLength });
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
                        const answerCell = whitePlayerStrategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    } else {
                        const answerCell = blackPlayerStrategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
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
                        const answerCell = blackPlayerStrategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    } else {
                        const answerCell = whitePlayerStrategy({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    }
                }, INTERVAL);
            }
        }
    }
}

function startGame() {
    if (countGames.value === 0) {
        isGameStart.value = true;
        blackPlayerStrategy = strategies[brains.indexOf(blackPlayer.value)];
        whitePlayerStrategy = strategies[brains.indexOf(whitePlayer.value)];
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
    router.post('/records', {
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
    startGame();
}
</script>

<template>

    <Head title="Simulation" />

    <BasicLayout :messages="messages">
        <template #title>
            Simulation
        </template>

        <div class="flex justify-center items-center gap-4 mt-4 w-4/5 mx-auto">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle"></i>
                <span>{{ blackPlayer }}</span>
            </div>
            <span class="text-xl">vs</span>
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-circle"></i>
                <span>{{ whitePlayer }}</span>
            </div>
        </div>

        <div class="text-center mt-4 mb-4">
            <span class="font-bold">{{ messages.simulate.black_wins }}: {{ countBlackWins }} | {{
                messages.simulate.white_wins
                }}: {{ countWhiteWins }} | {{ messages.simulate.draws }}: {{ countDraws }}</span>
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
            class="w-full mt-16 h-[calc(100vh-4rem)] bg-neutral-300/90 absolute top-0 left-0">
            <div class="mt-24 p-8 w-4/5 mx-auto bg-white rounded-md">
                <div v-if="!isReady">
                    <div class="mb-4">
                        <label for="blackBrain" class="block text-sm font-medium leading-6 text-gray-900">{{
                            messages.simulate.select_black_brain }}</label>
                        <select v-model="blackPlayer" @change="getBlackBrainModel"
                            class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                            <option v-for="brain in brains" :value="brain">{{ brain }}</option>
                        </select>
                        <div class="mt-2 bg-neutral-100 p-2 rounded-md text-xs">
                            <p v-if="messages.lang === 'ja'">{{ blackBrainModel.description }}</p>
                            <p v-else>{{ blackBrainModel.description_en }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="whiteBrain" class="block text-sm font-medium leading-6 text-gray-900">{{
                            messages.simulate.select_white_brain }}</label>
                        <select v-model="whitePlayer" @change="getWhiteBrainModel"
                            class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                            <option v-for="brain in brains" :value="brain">{{ brain }}</option>
                        </select>
                        <div class="mt-2 bg-neutral-100 p-2 rounded-md text-xs">
                            <p v-if="messages.lang === 'ja'">{{ whiteBrainModel.description }}</p>
                            <p v-else>{{ whiteBrainModel.description_en }}</p>
                        </div>
                    </div>

                    <button @click="readyGame"
                        class="bg-emerald-500 text-white font-bold block mx-auto px-4 py-2 rounded-md">{{
                            messages.simulate.ready_game }}</button>
                </div>
                <div v-if="!isCheckExplain && isReady">
                    <p class="mb-4 text-sm">{{ messages.simulate.check_explain }}</p>
                    <button @click="checkExplain"
                        class="bg-emerald-500 text-white font-bold block mx-auto px-4 py-2 rounded-md">{{
                            messages.simulate.simulate_start }}</button>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>

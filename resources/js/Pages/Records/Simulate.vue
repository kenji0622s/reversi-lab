<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import getAllDirectionCells from '@/utils/getAllDirectionCells';
import singleDirectionReverse from '@/utils/singleDirectionReverse';
import { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells } from '@/utils/updateAvailableCells';
import Board from '@/Components/Board.vue';

import { askBrain1 } from '@/strategies/brain1';
import { askBrain2 } from '@/strategies/brain2';

const players = ['black', 'white'];
const turn = ref(players[0]);
const blackCells = ref([[4, 5], [5, 4]]);
const whiteCells = ref([[4, 4], [5, 5]]);
const usedCells = ref([[4, 4], [5, 5], [4, 5], [5, 4]]);
const availableCells = ref([]);
const blackAvailableCells = ref([[3, 4], [4, 3], [5, 6], [6, 5]]);
const whiteAvailableCells = ref([]);
const selectedCell = ref(null);
const isGameEnd = ref(false);
const gameEndMessage = ref('');
const countBlackWins = ref(0);
const countWhiteWins = ref(0);
const countDraws = ref(0);
const countGames = ref(0);
const MAX_GAMES = 100;
const INTERVAL = 1;
const blackPlayer = 'Brain2';
const whitePlayer = 'Brain1';
const blackPlayerStrategy = askBrain2;
const whitePlayerStrategy = askBrain1;

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
        results.push({ 'black_player': blackPlayer, 'white_player': whitePlayer, 'count_black': blackCellsLength, 'count_white': whiteCellsLength });
        isGameEnd.value = true;
        reStartGame();
        return;
    }
    selectedCell.value = cell;
    if (!usedCells.value.some(usedCell => usedCell[0] === selectedCell.value[0] && usedCell[1] === selectedCell.value[1])) {
        if (turn.value === players[0]) {
            if (blackAvailableCells.value.some(blackAvailableCell => blackAvailableCell[0] === selectedCell.value[0] && blackAvailableCell[1] === selectedCell.value[1])) {
                blackCells.value.push(selectedCell.value);
                usedCells.value.push(selectedCell.value);
                const allDirectionCells = getAllDirectionCells(selectedCell.value);
                for (let i = 0; i < allDirectionCells.length; i++) {
                    singleDirectionReverse(allDirectionCells[i], blackCells.value, whiteCells.value, turn.value, players);
                }
                updateAvailableCells(availableCells, usedCells);
                updateWhiteAvailableCells(whiteAvailableCells, availableCells, blackCells, whiteCells, turn, players);
                updateBlackAvailableCells(blackAvailableCells, availableCells, blackCells, whiteCells, turn, players);
                setTimeout(() => {
                    if (whiteAvailableCells.value.length > 0) {
                        turn.value = players[1];
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
                    singleDirectionReverse(allDirectionCells[i], blackCells.value, whiteCells.value, turn.value, players);
                }
                updateAvailableCells(availableCells, usedCells);
                updateBlackAvailableCells(blackAvailableCells, availableCells, blackCells, whiteCells, turn, players);
                updateWhiteAvailableCells(whiteAvailableCells, availableCells, blackCells, whiteCells, turn, players);
                setTimeout(() => {
                    if (blackAvailableCells.value.length > 0) {
                        turn.value = players[0];
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
    countGames.value++;
    const blackAvailableCellLength = blackAvailableCells.value.length;
    const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
    selectCell(blackAvailableCells.value[randomIndex]);
}



function reStartGame() {
    if (countGames.value === MAX_GAMES) {
        return;
    }
    turn.value = players[0];
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
</script>

<template>

    <Head title="Simulation" />

    <BasicLayout>
        <template #title>
            Simulation
        </template>


        <div class="text-center mt-4 mb-4">
            <span class="font-bold">黒勝ち: {{ countBlackWins }} | 白勝ち: {{ countWhiteWins }} | 引き分け: {{ countDraws
                }}</span>
        </div>

        <Board :blackCells="blackCells" :whiteCells="whiteCells" :whiteAvailableCells="whiteAvailableCells"
            :blackAvailableCells="blackAvailableCells" :turn="turn" />

        <div class="flex justify-center items-center gap-4 mt-6" v-if="countGames === 0">
            <button @click="startGame" class="bg-emerald-500 text-white px-4 py-2 rounded-md font-bold">Start
                Simulation</button>
        </div>
        <div class="flex justify-center items-center gap-4 mt-6" v-else-if="countGames === MAX_GAMES && isGameEnd">
            <button @click="storeRecords" class="bg-emerald-500 text-white px-4 py-2 rounded-md font-bold">Store
                Records</button>
            <button @click="resetGame" onclick="window.location.reload()"
                class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md font-bold">Reset Game</button>
        </div>
        <div class="text-center mt-4 mb-2 font-bold text-sm" v-else>
            <div class="mt-6 mb-4">{{ countGames }}ゲーム / {{ MAX_GAMES }}ゲーム</div>
            <button @click="resetGame" onclick="window.location.reload()"
                class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md font-bold"> Stop
                Simulation</button>
        </div>
    </BasicLayout>
</template>

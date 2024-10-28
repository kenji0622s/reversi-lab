<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import getAllDirectionCells from '@/utils/getAllDirectionCells';
import singleDirectionReverse from '@/utils/singleDirectionReverse';
import { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells } from '@/utils/updateAvailableCells';

import { askBrain1 } from '@/strategies/brain1';
import { askBrain2 } from '@/strategies/brain2';

import Board from '@/Components/Board.vue';

defineProps({
    debug: Boolean,
});

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

const blackPlayerStrategy = askBrain2;
const whitePlayerStrategy = askBrain1;

const selectCell = (cell) => {
    if (blackAvailableCells.value.length === 0 && whiteAvailableCells.value.length === 0 && usedCells.value.length > 4) {
        const blackCellsLength = blackCells.value.length;
        const whiteCellsLength = whiteCells.value.length;
        if (blackCellsLength > whiteCellsLength) {
            gameEndMessage.value = '黒の勝利';
        } else if (blackCellsLength < whiteCellsLength) {
            gameEndMessage.value = '白の勝利';
        } else {
            gameEndMessage.value = '引き分け';
        }
        isGameEnd.value = true;
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
                }, 50);
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
                }, 50);
            }
        }
    }
}

function startGame() {
    const blackAvailableCellLength = blackAvailableCells.value.length;
    const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
    selectCell(blackAvailableCells.value[randomIndex]);
}
</script>

<template>

    <Head title="Watch" />

    <BasicLayout>
        <template #title>
            Watch
        </template>


        <div class="text-center mt-4">
            <span v-if="isGameEnd" class="text-xl font-bold">{{ gameEndMessage }}</span>
            <span v-else class="text-xl font-bold">{{ turn === players[0] ? '黒の番' : '白の番' }}</span>
        </div>

        <div class="text-center mb-4">
            黒: {{ blackCells.length }} | 白: {{ whiteCells.length }}
        </div>

        <Board :blackCells="blackCells" :whiteCells="whiteCells" :whiteAvailableCells="whiteAvailableCells"
            :blackAvailableCells="blackAvailableCells" :turn="turn" :debug="debug" />

        <div class="flex justify-center items-center gap-4 mt-6">
            <button @click="startGame" class="bg-emerald-500 text-white px-4 py-2 rounded-md">Start Game</button>
            <button @click="resetGame" onclick="window.location.reload()"
                class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md">Reset Game</button>
        </div>
    </BasicLayout>
</template>

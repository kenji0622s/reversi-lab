<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import getAllDirectionCells from '../utils/getAllDirectionCells';
import singleDirectionReverse from '../utils/singleDirectionReverse';
import { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells, checkSingleDirectionCells } from '../utils/updateAvailableCells';

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
                        const whiteAvailableCellLength = whiteAvailableCells.value.length;
                        const randomIndex = Math.floor(Math.random() * whiteAvailableCellLength);
                        selectCell(whiteAvailableCells.value[randomIndex]);
                    } else {
                        const blackAvailableCellLength = blackAvailableCells.value.length;
                        const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
                        selectCell(blackAvailableCells.value[randomIndex]);
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
                        const blackAvailableCellLength = blackAvailableCells.value.length;
                        const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
                        selectCell(blackAvailableCells.value[randomIndex]);
                    } else {
                        const whiteAvailableCellLength = whiteAvailableCells.value.length;
                        const randomIndex = Math.floor(Math.random() * whiteAvailableCellLength);
                        selectCell(whiteAvailableCells.value[randomIndex]);
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

    <Head title="Watch Mode" />

    <div class="relative">
        <h2 class="text-center text-2xl font-bold bg-neutral-200 py-2 border-b-2 border-emerald-500">Watch Mode</h2>
        <a href="/" class="absolute top-1/2 right-4 -translate-y-1/2 text-sm">Play Mode</a>
    </div>

    <div class="text-center mt-4 mb-2">
        <span v-if="isGameEnd" class="text-2xl font-bold">{{ gameEndMessage }}</span>
        <span v-else class="text-2xl font-bold">{{ turn === players[0] ? '黒の番' : '白の番' }}</span>
    </div>

    <div class="text-center mb-4">
        黒: {{ blackCells.length }} | 白: {{ whiteCells.length }}
    </div>

    <div class="grid grid-cols-8 w-80 aspect-square border border-black mx-auto bg-emerald-500">
        <template v-for="row in 8">
            <template v-for="column in 8">
                <div :id="[row, column]" class="w-full h-full border border-gray-500 relative">
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
                        :class="['w-4/5', 'h-4/5', 'text-[10px]', 'text-black', 'flex', 'justify-center', 'items-center', 'absolute', 'top-1/2', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', 'bg-amber-200', 'opacity-70']">
                        <!-- {{ row }},{{ column }} -->
                    </span>
                    <span
                        v-else-if="blackAvailableCells.some(blackAvailableCell => blackAvailableCell[0] === row && blackAvailableCell[1] === column) && turn === 'black'"
                        :class="['w-4/5', 'h-4/5', 'text-[10px]', 'text-black', 'flex', 'justify-center', 'items-center', 'absolute', 'top-1/2', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', 'bg-amber-200', 'opacity-70']">
                        <!-- {{ row }},{{ column }} -->
                    </span>
                    <span v-else class="w-full h-full text-[10px] text-black flex justify-center items-center">
                        <!-- {{ row }},{{ column }} -->
                    </span>
                </div>
            </template>
        </template>
    </div>
    <div class="flex justify-center items-center gap-4 mt-6">
        <button @click="startGame" class="bg-emerald-500 text-white px-4 py-2 rounded-md">Start Game</button>
        <button @click="resetGame" onclick="window.location.reload()"
            class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md">Reset Game</button>
    </div>
</template>
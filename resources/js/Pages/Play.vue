<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import getAllDirectionCells from '../utils/getAllDirectionCells';
import singleDirectionReverse from '../utils/singleDirectionReverse';
import { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells } from '../utils/updateAvailableCells';

const props = defineProps({
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
const isGameEnd = ref(false);
const gameEndMessage = ref('');
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
                }
            }
        }
    }
    if (blackAvailableCells.value.length === 0 && whiteAvailableCells.value.length === 0 && usedCells.value.length > 4) {
        const blackCellsLength = blackCells.value.length;
        const whiteCellsLength = whiteCells.value.length;
        if (blackCellsLength > whiteCellsLength) {
            gameEndMessage.value = props.messages.play.game_end_black_win;
        } else if (blackCellsLength < whiteCellsLength) {
            gameEndMessage.value = props.messages.play.game_end_white_win;
        } else {
            gameEndMessage.value = props.messages.play.game_end_draw;
        }
        isGameEnd.value = true;
    }
}
</script>

<template>

    <Head title="Play" />

    <BasicLayout :messages="messages">
        <template #title>
            Play Mode
        </template>
        <!-- <div class="relative">
            <h2 class="text-center text-2xl font-bold bg-neutral-200 py-2 border-b-2 border-emerald-500">Play Mode</h2>
            <a href="/watch" class="absolute top-1/2 right-4 -translate-y-1/2 text-sm">Watch Mode</a>
        </div> -->

        <div class="text-center mt-4">
            <span v-if="isGameEnd" class="text-xl font-bold">{{ gameEndMessage }}</span>
            <span v-else class="text-xl font-bold">{{ turn === turns[0] ? messages.play.black_run : messages.play.white_run }}</span>
        </div>

        <div class="text-center mb-4">
            {{ messages.common.black }}: {{ blackCells.length }} | {{ messages.common.white }}: {{ whiteCells.length }}
        </div>

        <div class="grid grid-cols-8 w-80 aspect-square border border-black bg-emerald-500 mx-auto">
            <template v-for="row in 8">
                <template v-for="column in 8">
                    <div :id="[row, column]" class="w-full h-full border border-gray-500 relative"
                        @click="selectCell([row, column])">
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

        <div class="flex justify-center items-center mt-6">
            <button @click="resetGame" onclick="window.location.reload()"
                class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md">{{ messages.play.reset_game }}</button>
        </div>
    </BasicLayout>
</template>
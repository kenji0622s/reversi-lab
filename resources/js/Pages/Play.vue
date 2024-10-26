<script setup>
import { ref } from 'vue';
import getAllDirectionCells from '../utils/getAllDirectionCells';
import directionReverse from '../utils/directionReverse';
const players = ['black', 'white'];
const turn = ref(players[0]);
const blackCells = ref([[4, 5], [5, 4]]);
const whiteCells = ref([[4, 4], [5, 5]]);
const selectedCell = ref(null);
const selectCell = (cell) => {
    selectedCell.value = cell;
    if (!usedCells.value.some(usedCell => usedCell[0] === selectedCell.value[0] && usedCell[1] === selectedCell.value[1])) {
        if (turn.value === players[0]) {
            if (blackAvailableCells.value.some(blackAvailableCell => blackAvailableCell[0] === selectedCell.value[0] && blackAvailableCell[1] === selectedCell.value[1])) {
                blackCells.value.push(selectedCell.value);
                usedCells.value.push(selectedCell.value);
                const allDirectionCells = getAllDirectionCells(selectedCell.value);
                for (let i = 0; i < allDirectionCells.length; i++) {
                    directionReverse(allDirectionCells[i], blackCells.value, whiteCells.value, turn.value, players);
                }
                updateAvailableCells();
                updateWhiteAvailableCells();
                console.log('whiteAvailableCells', whiteAvailableCells.value);
                turn.value = players[1];
            }
        } else {
            if (whiteAvailableCells.value.some(whiteAvailableCell => whiteAvailableCell[0] === selectedCell.value[0] && whiteAvailableCell[1] === selectedCell.value[1])) {
                whiteCells.value.push(selectedCell.value);
                usedCells.value.push(selectedCell.value);
                const allDirectionCells = getAllDirectionCells(selectedCell.value);
                for (let i = 0; i < allDirectionCells.length; i++) {
                    directionReverse(allDirectionCells[i], blackCells.value, whiteCells.value, turn.value, players);
                }
                updateAvailableCells();
                updateBlackAvailableCells();
                turn.value = players[0];
            }
        }
    }
}


const usedCells = ref([[4, 4], [5, 5], [4, 5], [5, 4]]);
const availableCells = ref([]);
function updateAvailableCells() {
    availableCells.value = [];
    for (let i = 1; i <= 8; i++) {
        for (let j = 1; j <= 8; j++) {
            if (!usedCells.value.some(usedCell => usedCell[0] === i && usedCell[1] === j)) {
                availableCells.value.push([i, j]);
            }
        }
    }
}



const blackAvailableCells = ref([[3, 4], [4, 3], [5, 6], [6, 5]]);
const whiteAvailableCells = ref([]);

function updateBlackAvailableCells() {
    blackAvailableCells.value = [];
    for (let i = 0; i < availableCells.value.length; i++) {
        const allDirectionCells = getAllDirectionCells(availableCells.value[i]);
        for (let j = 0; j < allDirectionCells.length; j++) {
            if (checkSingleDirectionCells(allDirectionCells[j])) {
                blackAvailableCells.value.push(availableCells.value[i]);
                break;
            }
        }
    }
}

function updateWhiteAvailableCells() {
    whiteAvailableCells.value = [];
    for (let i = 0; i < availableCells.value.length; i++) {
        const allDirectionCells = getAllDirectionCells(availableCells.value[i]);
        for (let j = 0; j < allDirectionCells.length; j++) {
            if (checkSingleDirectionCells(allDirectionCells[j])) {
                whiteAvailableCells.value.push(availableCells.value[i]);
                break;
            }
        }
    }
}

function checkSingleDirectionCells(singleDirectionCells) {
    const blackJudges = [];
    for (let i = 0; i < singleDirectionCells.length; i++) {
        blackJudges.push(blackCells.value.some(blackCell => blackCell[0] === singleDirectionCells[i][0] && blackCell[1] === singleDirectionCells[i][1]));
    }
    const whiteJudges = [];
    for (let i = 0; i < singleDirectionCells.length; i++) {
        whiteJudges.push(whiteCells.value.some(whiteCell => whiteCell[0] === singleDirectionCells[i][0] && whiteCell[1] === singleDirectionCells[i][1]));
    }
    if (turn.value === players[0]) {
        if (blackJudges[0] && whiteJudges[1]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && whiteJudges[2]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && whiteJudges[3]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && whiteJudges[4]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && blackJudges[4] && whiteJudges[5]) {
            return true;
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && blackJudges[3] && blackJudges[4] && blackJudges[5] && whiteJudges[6]) {
            return true;
        }
        return false;
    } else {
        if (whiteJudges[0] && blackJudges[1]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && blackJudges[2]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && blackJudges[3]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && blackJudges[4]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && whiteJudges[4] && blackJudges[5]) {
            return true;
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && whiteJudges[3] && whiteJudges[4] && whiteJudges[5] && blackJudges[6]) {
            return true;
        }
        return false;
    }
}
</script>

<template>
    <div class="text-center my-4">
        <span class="text-2xl font-bold">Turn: {{ turn }}</span>
    </div>
    <div class="grid grid-cols-8 w-80 aspect-square border border-black mx-auto bg-emerald-500">
        <template v-for="row in 8">
            <template v-for="column in 8">
                <div :id="[row, column]" class="aspect-square border border-gray-500 flex justify-center items-center"
                    @click="selectCell([row, column])">
                    <div v-if="whiteCells.some(cell => cell[0] === row && cell[1] === column)"
                        class="w-4/5 h-4/5 rounded-full bg-neutral-50 relative">
                        <span
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] text-black">
                            {{ row }},{{ column }}
                        </span>
                    </div>
                    <div v-else-if="blackCells.some(cell => cell[0] === row && cell[1] === column)"
                        class="w-4/5 h-4/5 rounded-full bg-neutral-950 relative">
                        <span
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] text-white">
                            {{ row }},{{ column }}
                        </span>
                    </div>
                    <div v-else-if="whiteAvailableCells.some(whiteAvailableCell => whiteAvailableCell[0] === row && whiteAvailableCell[1] === column)"
                        :class="['w-4/5', 'h-4/5', 'relative', turn === 'white' ? 'bg-amber-200 opacity-70' : '']">
                        <span
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] text-black">
                            {{ row }},{{ column }}
                        </span>
                    </div>
                    <div v-else-if="blackAvailableCells.some(blackAvailableCell => blackAvailableCell[0] === row && blackAvailableCell[1] === column)"
                        :class="['w-4/5', 'h-4/5', 'relative', turn === 'black' ? 'bg-amber-200 opacity-70' : '']">
                        <span
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] text-black">
                            {{ row }},{{ column }}
                        </span>
                    </div>
                    <div v-else class="relative w-full h-full">
                        <span
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] text-black">
                            {{ row }},{{ column }}
                        </span>
                    </div>
                </div>
            </template>
        </template>
    </div>
</template>
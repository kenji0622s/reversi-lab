<script setup>
import { ref } from 'vue';
const turn = ref(1);
const usedCells = ref([[4, 4], [5, 5], [4, 5], [5, 4]]);
const blackCells = ref([[4, 5], [5, 4]]);
const whiteCells = ref([[4, 4], [5, 5]]);
const selectedCell = ref(null);
const selectCell = (cell) => {
    selectedCell.value = cell;
    if (!usedCells.value.some(cell => cell[0] === selectedCell.value[0] && cell[1] === selectedCell.value[1])) {
        if (turn.value % 2 === 1) {
            blackCells.value.push(selectedCell.value);
            usedCells.value.push(selectedCell.value);
            turn.value++;
        } else {
            whiteCells.value.push(selectedCell.value);
            usedCells.value.push(selectedCell.value);
            turn.value++;
        }
        reverse(selectedCell.value);
    }
}

function reverse(selectedCell) {
    console.log('turn:' + turn.value);

    const direction = ['upperLeft', 'upper', 'upperRight', 'left', 'right', 'lowerLeft', 'lower', 'lowerRight'];

    const upperLeft = [selectedCell[0] - 1, selectedCell[1] - 1];
    const upper = [selectedCell[0] - 1, selectedCell[1]];
    const upperRight = [selectedCell[0] - 1, selectedCell[1] + 1];
    const left = [selectedCell[0], selectedCell[1] - 1];
    const right = [selectedCell[0], selectedCell[1] + 1];
    const lowerLeft = [selectedCell[0] + 1, selectedCell[1] - 1];
    const lower = [selectedCell[0] + 1, selectedCell[1]];
    const lowerRight = [selectedCell[0] + 1, selectedCell[1] + 1];
    const aroundCells = [upperLeft, upper, upperRight, left, right, lowerLeft, lower, lowerRight];

    const upperLeftNext = [upperLeft[0] - 1, upperLeft[1] - 1];
    const upperNext = [upper[0] - 1, upper[1]];
    const upperRightNext = [upperRight[0] - 1, upperRight[1] + 1];
    const leftNext = [left[0], left[1] - 1];
    const rightNext = [right[0], right[1] + 1];
    const lowerLeftNext = [lowerLeft[0] + 1, lowerLeft[1] - 1];
    const lowerNext = [lower[0] + 1, lower[1]];
    const lowerRightNext = [lowerRight[0] + 1, lowerRight[1] + 1];
    const aroundCellsNext = [upperLeftNext, upperNext, upperRightNext, leftNext, rightNext, lowerLeftNext, lowerNext, lowerRightNext];

    if (turn.value % 2 === 1) {
        for (let i = 0; i < aroundCells.length; i++) {
            const blackJudge = blackCells.value.some(cell => cell[0] === aroundCells[i][0] && cell[1] === aroundCells[i][1]);
            const whiteJudge = whiteCells.value.some(cell => cell[0] === aroundCellsNext[i][0] && cell[1] === aroundCellsNext[i][1]);
            if (blackJudge && whiteJudge) {
                blackCells.value.splice(blackCells.value.findIndex(cell => cell[0] === aroundCells[i][0] && cell[1] === aroundCells[i][1]), 1);
                whiteCells.value.push(aroundCells[i]);
            }
            console.log(direction[i], 'aroundCells[i]:' + aroundCells[i], 'aroundCellsNext[i]:' + aroundCellsNext[i], 'whiteJudge:' + whiteJudge, 'blackJudge:' + blackJudge);
        }
    } else {
        for (let i = 0; i < aroundCells.length; i++) {
            const whiteJudge = whiteCells.value.some(cell => cell[0] === aroundCells[i][0] && cell[1] === aroundCells[i][1]);
            const blackJudge = blackCells.value.some(cell => cell[0] === aroundCellsNext[i][0] && cell[1] === aroundCellsNext[i][1]);
            if (whiteJudge && blackJudge) {
                whiteCells.value.splice(whiteCells.value.findIndex(cell => cell[0] === aroundCells[i][0] && cell[1] === aroundCells[i][1]), 1);
                blackCells.value.push(aroundCells[i]);
            }
            console.log(direction[i], 'aroundCells[i]:' + aroundCells[i], 'aroundCellsNext[i]:' + aroundCellsNext[i], 'whiteJudge:' + whiteJudge, 'blackJudge:' + blackJudge);
        }
    }
}






</script>

<template>
    <div class="text-center my-4">
        <span class="text-2xl font-bold">Turn: {{ turn }}</span>
    </div>
    <div class="grid grid-cols-8 w-96 h-96 border border-black bg-green-600 mx-auto">
        <template v-for="row in 8">
            <template v-for="column in 8">
                <div :id="[row, column]" class="aspect-square border border-gray-500 flex justify-center items-center"
                    @click="selectCell([row, column])">
                    <div v-if="whiteCells.some(cell => cell[0] === row && cell[1] === column)"
                        class="w-4/5 aspect-square rounded-full bg-white relative">
                        <span
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] text-black">
                            {{ row }},{{ column }}
                        </span>
                    </div>
                    <div v-else-if="blackCells.some(cell => cell[0] === row && cell[1] === column)"
                        class="w-4/5 aspect-square rounded-full bg-black relative">
                        <span
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[10px] text-white">
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
    <div>
        黒: {{ blackCells }}
    </div>
    <div>
        白: {{ whiteCells }}
    </div>
    <div>
        済: {{ usedCells }}
    </div>



</template>

<script setup>
import { ref } from 'vue';
const players = ['black', 'white'];
const turn = ref(players[0]);
const usedCells = ref([[4, 4], [5, 5], [4, 5], [5, 4]]);
const blackCells = ref([[4, 5], [5, 4]]);
const whiteCells = ref([[4, 4], [5, 5]]);
const selectedCell = ref(null);
const selectCell = (cell) => {
    selectedCell.value = cell;
    if (!usedCells.value.some(usedCell => usedCell[0] === selectedCell.value[0] && usedCell[1] === selectedCell.value[1])) {
        if (turn.value === players[0]) {
            blackCells.value.push(selectedCell.value);
            usedCells.value.push(selectedCell.value);
            reverse(selectedCell.value);
            turn.value = players[1];
        } else {
            whiteCells.value.push(selectedCell.value);
            usedCells.value.push(selectedCell.value);
            reverse(selectedCell.value);
            turn.value = players[0];
        }
    }
}


function directionReverse(directionCells) {
    const blackJudges = [];
    for (let i = 0; i < directionCells.length; i++) {
        blackJudges.push(blackCells.value.some(blackCell => blackCell[0] === directionCells[i][0] && blackCell[1] === directionCells[i][1]));
    }
    const whiteJudges = [];
    for (let i = 0; i < directionCells.length; i++) {
        whiteJudges.push(whiteCells.value.some(whiteCell => whiteCell[0] === directionCells[i][0] && whiteCell[1] === directionCells[i][1]));
    }

    console.log('blackJudges:' + blackJudges);
    console.log('whiteJudges:' + whiteJudges);

    if (turn.value === players[0]) {
        if (whiteJudges[0] && blackJudges[1]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === directionCells[0][0] && whiteCell[1] === directionCells[0][1]), 1);
            blackCells.value.push(directionCells[0]);
        }
        if (whiteJudges[0] && whiteJudges[1] && blackJudges[2]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === directionCells[0][0] && whiteCell[1] === directionCells[0][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === directionCells[1][0] && whiteCell[1] === directionCells[1][1]), 1);
            blackCells.value.push(directionCells[0], directionCells[1]);
        }
        if (whiteJudges[0] && whiteJudges[1] && whiteJudges[2] && blackJudges[3]) {
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === directionCells[0][0] && whiteCell[1] === directionCells[0][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === directionCells[1][0] && whiteCell[1] === directionCells[1][1]), 1);
            whiteCells.value.splice(whiteCells.value.findIndex(whiteCell => whiteCell[0] === directionCells[2][0] && whiteCell[1] === directionCells[2][1]), 1);
            blackCells.value.push(directionCells[0], directionCells[1], directionCells[2]);
        }
    } else {
        if (blackJudges[0] && whiteJudges[1]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === directionCells[0][0] && blackCell[1] === directionCells[0][1]), 1);
            whiteCells.value.push(directionCells[0]);
        }
        if (blackJudges[0] && blackJudges[1] && whiteJudges[2]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === directionCells[0][0] && blackCell[1] === directionCells[0][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === directionCells[1][0] && blackCell[1] === directionCells[1][1]), 1);
            whiteCells.value.push(directionCells[0], directionCells[1]);
        }
        if (blackJudges[0] && blackJudges[1] && blackJudges[2] && whiteJudges[3]) {
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === directionCells[0][0] && blackCell[1] === directionCells[0][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === directionCells[1][0] && blackCell[1] === directionCells[1][1]), 1);
            blackCells.value.splice(blackCells.value.findIndex(blackCell => blackCell[0] === directionCells[2][0] && blackCell[1] === directionCells[2][1]), 1);
            whiteCells.value.push(directionCells[0], directionCells[1], directionCells[2]);
        }
    }
}
function reverse(selectedCell) {

    const row = selectedCell[0];
    const column = selectedCell[1];

    console.log('row:' + row, 'column:' + column);

    const upperLeftCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row - i > 0 && column - i > 0) {
            upperLeftCells.push([row - i, column - i]);
        }
    }

    const upperCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row - i > 0) {
            upperCells.push([row - i, column]);
        }
    }

    const upperRightCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row - i > 0 && column + i <= 8) {
            upperRightCells.push([row - i, column + i]);
        }
    }

    const leftCells = [];
    for (let i = 1; i <= 7; i++) {
        if (column - i > 0) {
            leftCells.push([row, column - i]);
        }
    }

    const rightCells = [];
    for (let i = 1; i <= 7; i++) {
        if (column + i <= 8) {
            rightCells.push([row, column + i]);
        }
    }

    const lowerLeftCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row + i <= 8 && column - i > 0) {
            lowerLeftCells.push([row + i, column - i]);
        }
    }

    const lowerCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row + i <= 8) {
            lowerCells.push([row + i, column]);
        }
    }

    const lowerRightCells = [];
    for (let i = 1; i <= 7; i++) {
        if (row + i <= 8 && column + i <= 8) {
            lowerRightCells.push([row + i, column + i]);
        }
    }

    const directionCells = [upperLeftCells, upperCells, upperRightCells, leftCells, rightCells, lowerLeftCells, lowerCells, lowerRightCells];
    for (let i = 0; i < directionCells.length; i++) {
        directionReverse(directionCells[i]);
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
    <div class="my-4">

        <div>
            黒: {{ blackCells }}
        </div>
        <div>
            白: {{ whiteCells }}
        </div>
        <div>
            済: {{ usedCells }}
        </div>
    </div>
        
        

</template>

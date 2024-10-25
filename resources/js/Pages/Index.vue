<script setup>
import { ref } from 'vue';
import getAllDirectionCells from '../utils/getAllDirectionCells';
import directionReverse from '../utils/directionReverse';
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
            const allDirectionCells = getAllDirectionCells(selectedCell.value);
            for (let i = 0; i < allDirectionCells.length; i++) {
                directionReverse(allDirectionCells[i], blackCells.value, whiteCells.value, turn.value);
            }
            turn.value = players[1];
        } else {
            whiteCells.value.push(selectedCell.value);
            usedCells.value.push(selectedCell.value);
            const allDirectionCells = getAllDirectionCells(selectedCell.value);
            for (let i = 0; i < allDirectionCells.length; i++) {
                directionReverse(allDirectionCells[i], blackCells.value, whiteCells.value, turn.value);
            }
            turn.value = players[0];
        }
    }
}

</script>

<template>
    <div class="text-center my-4">
        <span class="text-2xl font-bold">Turn: {{ turn }}</span>
    </div>
    <div class="grid grid-cols-8 w-80 aspect-square border border-black bg-green-600 mx-auto">
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

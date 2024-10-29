<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import getAllDirectionCells from '../utils/getAllDirectionCells';
import singleDirectionReverse from '../utils/singleDirectionReverse';
import { updateAvailableCells, updateBlackAvailableCells, updateWhiteAvailableCells } from '../utils/updateAvailableCells';

import { brains, strategies } from '../strategies/brains';

const props = defineProps({
    user: Object,
    brainsModels: Object,
    messages: Object,
});

const user = props.user;
if (user) {
    console.log(user.id);
}

const turns = ['black', 'white'];

const brain = ref(brains[0]);
const brainModel = ref(props.brainsModels[0]);
function getBrainModel() {
    brainModel.value = props.brainsModels[brains.indexOf(brain.value)];
}

const yourTurn = ref(turns[0]);
const brainTurn = ref(turns[0]);
const turn = ref(turns[0]);

const isReady = ref(false);

const blackCells = ref([[4, 5], [5, 4]]);
const whiteCells = ref([[4, 4], [5, 5]]);
const usedCells = ref([[4, 4], [5, 5], [4, 5], [5, 4]]);
const availableCells = ref([]);
const blackAvailableCells = ref([[3, 4], [4, 3], [5, 6], [6, 5]]);
const whiteAvailableCells = ref([]);
const selectedCell = ref(null);
const isGameEnd = ref(false);
const gameEndMessage = ref('');
let result;
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
                if (brainTurn.value === turns[1] && turn.value === turns[1]) {
                    setTimeout(() => {
                        const answerCell = strategies[brains.indexOf(brain.value)]({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    }, 300);
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
                if (brainTurn.value === turns[0] && turn.value === turns[0]) {
                    setTimeout(() => {
                        const answerCell = strategies[brains.indexOf(brain.value)]({ blackAvailableCells: blackAvailableCells.value, whiteAvailableCells: whiteAvailableCells.value, turn: turn.value });
                        selectCell(answerCell);
                    }, 300);
                }
            }
        }
    }
    if (blackAvailableCells.value.length === 0 && whiteAvailableCells.value.length === 0 && usedCells.value.length > 4) {
        const blackCellsLength = blackCells.value.length;
        const whiteCellsLength = whiteCells.value.length;
        if (blackCellsLength > whiteCellsLength && yourTurn.value === turns[0] || blackCellsLength < whiteCellsLength && yourTurn.value === turns[1]) {
            gameEndMessage.value = props.messages.challenge.game_end_win;
            result = 'win';
        } else if (blackCellsLength < whiteCellsLength && yourTurn.value === turns[0] || blackCellsLength > whiteCellsLength && yourTurn.value === turns[1]) {
            gameEndMessage.value = props.messages.challenge.game_end_lose;
            result = 'lose';
        } else {
            gameEndMessage.value = props.messages.challenge.game_end_draw;
            result = 'draw';
        }
        isGameEnd.value = true;
        if (user) {
            router.post('/user-records', {
                user_id: user.id,
                brain_id: brains.indexOf(brain.value) + 1,
                result: result,
            });
        } else {
            router.post('/user-records', {
                user_id: 0,
                brain_id: brains.indexOf(brain.value) + 1,
                result: result,
            });
        }
    }
}

const readyGame = () => {
    brainTurn.value = yourTurn.value === turns[0] ? turns[1] : turns[0];
    isReady.value = true;
    if (brainTurn.value === turns[0]) {
        const blackAvailableCellLength = blackAvailableCells.value.length;
        const randomIndex = Math.floor(Math.random() * blackAvailableCellLength);
        selectCell(blackAvailableCells.value[randomIndex]);
    }
}
</script>

<template>

    <Head title="Challenge" />

    <BasicLayout :messages="messages">
        <template #title>
            Challenge<span class="text-sm ml-2" v-if="isReady">vs {{ brain }}</span>
        </template>



        <!-- <div class="relative">
                <h2 class="text-center text-2xl font-bold bg-neutral-200 py-2 border-b-2 border-emerald-500">Play Mode</h2>
            <a href="/watch" class="absolute top-1/2 right-4 -translate-y-1/2 text-sm">Watch Mode</a>
        </div> -->

        <div class="text-center mt-4">
            <span v-if="isGameEnd" class="text-xl font-bold">{{ gameEndMessage }}</span>
            <span v-else class="text-xl font-bold">{{ (turn === turns[0] && yourTurn === turns[0]) || (turn === turns[1]
                &&
                yourTurn === turns[1]) ? messages.challenge.your_turn : messages.challenge.brain_turn }}</span>
        </div>

        <div class="text-center mb-4">
            {{ messages.common.black }}: {{ blackCells.length }} | {{ messages.common.white }}: {{ whiteCells.length }}
        </div>

        <div class="grid grid-cols-8 w-80 aspect-square border border-black bg-emerald-500 mx-auto">
            <template v-for="row in 8">
                <template v-for="column in 8">
                    <div :id="[row, column]" class="w-full h-full border border-gray-500 relative"
                        @click="(!isGameEnd && ((turn === yourTurn) || (brainTurn === turn))) && selectCell([row, column])">
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
                class="border-2 border-emerald-500 text-emerald-500 px-4 py-2 rounded-md font-bold">{{
                    messages.challenge.reset_game }}</button>
        </div>

        <div v-if="!isReady" class="w-full mt-16 h-[calc(100vh-4rem)] bg-neutral-300/90 absolute top-0 left-0">
            <div class="mt-24 p-8 w-4/5 mx-auto bg-white rounded-md">
                <div class="mb-4">
                    <label for="brain" class="block text-sm font-medium leading-6 text-gray-900">{{
                        messages.challenge.select_brain }}</label>
                    <select v-model="brain" @change="getBrainModel"
                        class="text-sm block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                        <option v-for="brain in brains" :value="brain">{{ brain }}</option>
                    </select>
                    <div class="mt-2 bg-neutral-100 p-2 rounded-md text-xs">
                        <p v-if="messages.lang === 'ja'">{{ brainModel.description }}</p>
                        <p v-else>{{ brainModel.description_en }}</p>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="yourTurn" class="block text-sm font-medium leading-6 text-gray-900">{{
                        messages.challenge.select_turn }}</label>
                    <select v-model="yourTurn"
                        class="text-sm block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-emerald-500 sm:text-sm sm:leading-6">
                        <option v-for="turn in turns" :value="turn">{{ turn === 'black' ?
                            messages.challenge.select_turn_black :
                            messages.challenge.select_turn_white }}</option>
                    </select>
                </div>

                <button @click="readyGame"
                    class="bg-emerald-500 text-white font-bold block mx-auto px-4 py-2 rounded-md">{{
                        messages.challenge.game_start }}</button>
            </div>
        </div>

    </BasicLayout>
</template>

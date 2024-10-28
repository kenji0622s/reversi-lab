<script setup>
defineProps({
    debug: Boolean,
    blackCells: Array,
    whiteCells: Array,
    whiteAvailableCells: Array,
    blackAvailableCells: Array,
    turn: String,
});
</script>

<template>
    <div class="grid grid-cols-8 w-80 aspect-square border border-black mx-auto bg-emerald-500">
        <template v-for="row in 8">
            <template v-for="column in 8">
                <div :id="[row, column]" class="w-full h-full border border-gray-500 relative">
                    <span v-if="whiteCells.some(cell => cell[0] === row && cell[1] === column)"
                        class="w-4/5 h-4/5 rounded-full bg-neutral-50 text-[10px] text-black flex justify-center items-center absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        <template v-if="debug">{{ row }},{{ column }}</template>
                    </span>
                    <span v-else-if="blackCells.some(cell => cell[0] === row && cell[1] === column)"
                        class="w-4/5 h-4/5 rounded-full bg-neutral-950 text-[10px] text-white flex justify-center items-center absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        <template v-if="debug">{{ row }},{{ column }}</template>
                    </span>
                    <span
                        v-else-if="whiteAvailableCells.some(whiteAvailableCell => whiteAvailableCell[0] === row && whiteAvailableCell[1] === column) && turn === 'white'"
                        :class="['w-4/5', 'h-4/5', 'text-[10px]', 'text-black', 'flex', 'justify-center', 'items-center', 'absolute', 'top-1/2', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', 'bg-amber-200', 'opacity-70']">
                        <template v-if="debug">{{ row }},{{ column }}</template>
                    </span>
                    <span
                        v-else-if="blackAvailableCells.some(blackAvailableCell => blackAvailableCell[0] === row && blackAvailableCell[1] === column) && turn === 'black'"
                        :class="['w-4/5', 'h-4/5', 'text-[10px]', 'text-black', 'flex', 'justify-center', 'items-center', 'absolute', 'top-1/2', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', 'bg-amber-200', 'opacity-70']">
                        <template v-if="debug">{{ row }},{{ column }}</template>
                    </span>
                    <span v-else class="w-full h-full text-[10px] text-black flex justify-center items-center">
                        <template v-if="debug">{{ row }},{{ column }}</template>
                    </span>
                </div>
            </template>
        </template>
    </div>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-emerald-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-400 focus:bg-emerald-400 active:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>

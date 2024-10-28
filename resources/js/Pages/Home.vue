<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Home" />

    <BasicLayout>
        <template #title>Home</template>
        <div class="flex flex-col gap-4 items-center mt-8">
            <Link :href="route('brains.index')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60">Brains</Link>
            <Link :href="route('watch')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60">
            Watch</Link>
            <Link :href="route('records.create')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60">Simulation</Link>
            <Link :href="route('records.index')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60">Records</Link>
            <Link :href="route('play')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60">Play
            </Link>
            <Link :href="route('dashboard')" v-if="$page.props.auth.user"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60">Dashboard</Link>
        </div>
    </BasicLayout>
</template>

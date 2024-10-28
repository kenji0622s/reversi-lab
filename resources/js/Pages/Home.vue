<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Home" />

    <BasicLayout>
        <template #title>Home</template>
        <div class="flex flex-col gap-4 items-center mt-8">
            <Link :href="route('challenge')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            Challenge<span class="text-sm ml-2">vs Brains</span>
            </Link>
            <Link :href="route('user-records.index')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            <template v-if="$page.props.auth.user">
                My Records
            </template>
            <template v-else>
                Player Records
            </template>
            </Link>
            <Link :href="route('brains.index')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            Brain List
            </Link>
            <!-- <Link :href="route('watch')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">Watch
            </Link> -->
            <Link :href="route('records.create')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">Simulation
            </Link>
            <Link :href="route('records.index')" v-if="$page.props.auth.user && $page.props.auth.user.is_admin"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">Records
            </Link>
            <Link :href="route('play')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">Play
            </Link>
            <div class="flex justify-center items-center gap-4 w-60" v-if="!$page.props.auth.user">
                <Link :href="route('login')"
                    class="border-2 border-emerald-500 text-lg font-bold text-center text-emerald-500 p-1 rounded-md shadow-md w-1/2">
                Login
                </Link>
                <Link :href="route('register')"
                    class="border-2 border-emerald-500 text-lg font-bold text-center text-emerald-500 p-1 rounded-md shadow-md w-1/2">
                Register
                </Link>
            </div>

        </div>
    </BasicLayout>
</template>

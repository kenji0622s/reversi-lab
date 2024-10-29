<script setup>
import BasicLayout from '@/Layouts/BasicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    messages: Object,
});

</script>

<template>

    <Head title="Home" />

    <BasicLayout :messages="messages">
        <template #title>Home</template>
        <div class="flex flex-col gap-4 items-center mt-8">
            <Link :href="route('challenge')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            {{ messages.menu.challenge }}<span class="text-sm ml-2">vs Brain</span>
            </Link>
            <Link :href="route('user-records.index')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            <template v-if="$page.props.auth.user">
                {{ messages.menu.my_records }}
            </template>
            <template v-else>
                {{ messages.menu.guest_records }}
            </template>
            </Link>
            <Link :href="route('brains.index')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            {{ messages.menu.brain_list }}
            </Link>
            <!-- <Link :href="route('watch')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">Watch
            </Link> -->
            <Link :href="route('records.create')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            {{ messages.menu.simulation }}
            </Link>
            <Link :href="route('records.index')" v-if="$page.props.auth.user && $page.props.auth.user.is_admin"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            {{ messages.menu.records }}
            </Link>
            <Link :href="route('play')"
                class="bg-emerald-500 text-lg font-bold text-center text-white p-2 rounded-md w-60 shadow-md">
            {{ messages.menu.play }}
            </Link>
            <div class="flex justify-center items-center gap-4 w-60" v-if="!$page.props.auth.user">
                <Link :href="route('login')"
                    class="border-2 border-emerald-500 text-lg font-bold text-center text-emerald-500 p-1 rounded-md shadow-md w-1/2">
                {{ messages.common.login }}
                </Link>
                <Link :href="route('register')"
                    class="border-2 border-emerald-500 text-lg font-bold text-center text-emerald-500 p-1 rounded-md shadow-md w-1/2">
                {{ messages.common.register }}
                </Link>
            </div>

        </div>
    </BasicLayout>
</template>

<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    messages: Object,
});

const showingNavigationDropdown = ref(false);
const isShowLanguage = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-neutral-50">
            <nav class="bg-neutral-200 border-b-2 border-emerald-500 fixed top-0 w-full h-16 z-50">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center mr-4">
                                <Link :href="route('home')">
                                <ApplicationLogo class="block" />
                                </Link>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">
                                    <slot name="title" />
                                </h2>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('challenge')" :active="route().current('challenge')">
                                    {{ messages.menu.challenge }} <span class="text-sm">vs Brain</span>
                                </NavLink>
                                <NavLink :href="route('user-records.index')"
                                    :active="route().current('user-records.index')">
                                    <template v-if="$page.props.auth.user">
                                        {{ messages.menu.my_records }}
                                    </template>
                                    <template v-else>
                                        {{ messages.menu.guest_records }}
                                    </template>
                                </NavLink>
                                <NavLink :href="route('brains.index')" :active="route().current('brains.index')">
                                    {{ messages.menu.brain_list }}
                                </NavLink>
                                <!-- <NavLink :href="route('watch')" :active="route().current('watch')">
                                    Watch
                                </NavLink> -->
                                <NavLink :href="route('records.create')" :active="route().current('records.create')">
                                    {{ messages.menu.simulation }}
                                </NavLink>
                                <NavLink :href="route('play')" :active="route().current('play')">
                                    {{ messages.menu.play }}
                                </NavLink>
                                <NavLink :href="route('profile.edit')" v-if="$page.props.auth.user">
                                    {{ messages.menu.profile }}
                                </NavLink>
                                <NavLink :href="route('logout')" method="post" as="button" v-if="$page.props.auth.user">
                                    {{ messages.common.logout }}
                                </NavLink>
                                <NavLink :href="route('records.index')" :active="route().current('records.index')"
                                    v-if="$page.props.auth.user && $page.props.auth.user.is_admin">
                                    {{ messages.menu.records }}
                                </NavLink>
                            </div>
                        </div>


                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden gap-2">
                            <button @click="isShowLanguage = !isShowLanguage">
                                <!-- <i class="fa-solid fa-globe text-lg text-gray-500"></i> -->
                                <i class="fa-solid fa-language text-lg text-gray-500"></i>
                            </button>
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="w-full mt-16 h-[calc(100vh-4rem)] bg-neutral-300/90 absolute top-0 left-0" v-if="isShowLanguage">
                    <div class="w-52 bg-neutral-50 rounded-md pt-10 pb-6 px-8 text-center mx-auto mt-12 shadow-md">
                        <div class="mb-6 text-center">
                            <a href="/switch-language/en"
                                class="p-2 font-bold border-2 border-emerald-600 text-emerald-600 rounded-md block shadow-sm">English</a>
                        </div>
                        <div class="mb-6 text-center">
                            <a href="/switch-language/ja"
                                class="p-2 font-bold border-2 border-emerald-600 text-emerald-600 rounded-md block shadow-sm">日本語</a>
                        </div>
                        <button @click="isShowLanguage = false"
                            class="text-emerald-600 px-4 py-2 rounded-md font-bold text-sm">{{
                                messages.common.close
                            }}</button>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('challenge')" :active="route().current('challenge')">
                            {{ messages.menu.challenge }} <span class="text-sm">vs Brain</span>
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('user-records.index')"
                            :active="route().current('user-records.index')">
                            <template v-if="$page.props.auth.user">
                                {{ messages.menu.my_records }}
                            </template>
                            <template v-else>
                                {{ messages.menu.guest_records }}
                            </template>
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('brains.index')" :active="route().current('brains.index')">
                            {{ messages.menu.brain_list }}
                        </ResponsiveNavLink>
                        <!-- <ResponsiveNavLink :href="route('watch')" :active="route().current('watch')">
                            Watch
                        </ResponsiveNavLink> -->
                        <ResponsiveNavLink :href="route('records.create')" :active="route().current('records.create')">
                            {{ messages.menu.simulation }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('play')" :active="route().current('play')">
                            {{ messages.menu.play }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('profile.edit')" v-if="$page.props.auth.user">
                            {{ messages.menu.profile }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button"
                        v-if="$page.props.auth.user">
                        {{ messages.common.logout }}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('records.index')" :active="route().current('records.index')"
                        v-if="$page.props.auth.user && $page.props.auth.user.is_admin">
                        {{ messages.menu.records }}
                    </ResponsiveNavLink>
                        <!-- Responsive Settings Options -->
                        <!-- <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="px-4">
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                      test
                                </div>
                                <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                                <div class="font-medium text-sm text-gray-500">test</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                                <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </div>
                        </div> -->
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="pt-16" v-show="!showingNavigationDropdown">
                <slot />
            </main>
        </div>
    </div>
</template>

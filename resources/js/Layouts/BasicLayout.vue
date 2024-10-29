<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
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
                                    Challenge
                                </NavLink>
                                <NavLink :href="route('user-records.index')" :active="route().current('user-records.index')">
                                    <template v-if="$page.props.auth.user">
                                        My Records
                                    </template>
                                    <template v-else>
                                        Guest Records
                                    </template>
                                </NavLink>
                                <NavLink :href="route('brains.index')" :active="route().current('brains.index')">
                                    Brain List
                                </NavLink>
                                <!-- <NavLink :href="route('watch')" :active="route().current('watch')">
                                    Watch
                                </NavLink> -->
                                <NavLink :href="route('records.create')" :active="route().current('records.create')">
                                    Simulation
                                </NavLink>
                                <NavLink :href="route('records.index')" :active="route().current('records.index')"
                                    v-if="$page.props.auth.user && $page.props.auth.user.is_admin">
                                    Records
                                </NavLink>
                                <NavLink :href="route('play')" :active="route().current('play')">
                                    Play
                                </NavLink>
                                <NavLink :href="route('profile.edit')" v-if="$page.props.auth.user"> Profile
                                </NavLink>
                                <NavLink :href="route('logout')" method="post" as="button" v-if="$page.props.auth.user">
                                    Log Out
                                </NavLink>
                            </div>

                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('challenge')" :active="route().current('challenge')">
                            Challenge
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('user-records.index')" :active="route().current('user-records.index')">
                            <template v-if="$page.props.auth.user">
                                My Records
                            </template>
                            <template v-else>
                                Guest Records
                            </template>
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('brains.index')" :active="route().current('brains.index')">
                            Brain List
                        </ResponsiveNavLink>
                        <!-- <ResponsiveNavLink :href="route('watch')" :active="route().current('watch')">
                            Watch
                        </ResponsiveNavLink> -->
                        <ResponsiveNavLink :href="route('records.create')" :active="route().current('records.create')">
                            Simulation
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('records.index')" :active="route().current('records.index')"
                            v-if="$page.props.auth.user && $page.props.auth.user.is_admin">
                            Records
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('play')" :active="route().current('play')">
                            Play
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('profile.edit')" v-if="$page.props.auth.user"> Profile
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button"
                            v-if="$page.props.auth.user">
                            Log Out
                        </ResponsiveNavLink>
                        <a href="/switch-language/ja">日本語</a>
                        <a href="/switch-language/en">English</a>
                    </div>

                    <!-- Responsive Settings Options -->
                    <!-- <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div> -->
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

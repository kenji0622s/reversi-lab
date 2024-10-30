<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import BasicLayout from '@/Layouts/BasicLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
    messages: Object,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <BasicLayout :messages="messages">

        <Head title="Log in" />

        <template #title>Log in</template>

        <div class="w-4/5 md:w-96 mx-auto mt-8 border border-neutral-300 py-6 px-4 rounded-md shadow-md">
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" :value="messages.login.email" />

                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                        autocomplete="username" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" :value="messages.login.password" />

                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                        autocomplete="current-password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ messages.login.remember_me }}</span>
                    </label>
                </div>
                <div class="text-center mt-4">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ messages.common.login }}
                    </PrimaryButton>
                </div>

                <div class="text-center mt-4">
                    <Link v-if="canResetPassword" :href="route('password.request')"
                    class="underline text-xs text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    {{ messages.login.forgot_password }}
                    </Link>
                </div>
                <div class="text-center mt-2">
                    <Link :href="route('register')"
                        class="underline text-xs text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        {{ messages.login.not_registered }}
                    </Link>
                </div>


            </form>
        </div>
    </BasicLayout>
</template>

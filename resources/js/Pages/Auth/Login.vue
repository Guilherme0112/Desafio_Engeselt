<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Header from '@/components/Header.vue';
import "../../../css/Forms.css";

defineProps({
    auth: Object,
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
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

    <Header :auth="auth"/>

    <GuestLayout>

        <Head title="Entrar" />

        <form @submit.prevent="submit">
    
            <div>

                <h1>Entrar</h1>

                <!-- Input Email -->
                <div>
                    <InputLabel for="email" value="Email:" />

                    <TextInput id="email" type="email" v-model="form.email" required autofocus
                        autocomplete="username" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <!-- Fim input email -->

                <!-- Input Password -->
                <div>
                    <InputLabel for="password" value="Password:" />

                    <TextInput id="password" type="password" v-model="form.password" required
                        autocomplete="current-password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <!-- Fim input Password -->

                <!-- Container do button -->
                <div style="display: flex; justify-content: end;">

                    <div>
                        <Link href="/register">Não tem conta? Crie aqui</Link>
                    </div>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Entrar
                    </PrimaryButton>
                </div>

            </div>
        </form>
    </GuestLayout>
</template>

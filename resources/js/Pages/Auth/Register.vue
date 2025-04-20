<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
import "../../../css/Forms.css";

defineProps({
    auth: Object
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

document.title = "Criar Conta";

</script>

<template>

    <Header :auth="auth"/>

    <GuestLayout>


        <form @submit.prevent="submit">

            <div>

                <h1>Criar Conta</h1>

                <div>
                    <InputLabel for="name" value="Nome:" />

                    <TextInput id="name" type="text" v-model="form.name" required autofocus
                        autocomplete="name" />

                    <InputError :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email:" />

                    <TextInput id="email" type="email" v-model="form.email" required
                        autocomplete="username" />

                    <InputError :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Senha:" />

                    <TextInput id="password" type="password" v-model="form.password" required
                        autocomplete="new-password" />

                    <InputError :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirmar Senha:" />

                    <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" 
                                required autocomplete="new-password" />

                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <!-- Container do button -->
                <div style="display: flex; justify-content: space-around;">

                    <div>
                        <Link href="/login">Já tem conta? Entre por aqui</Link>
                    </div>

                    <PrimaryButton :disabled="form.processing">
                        Criar Conta
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>

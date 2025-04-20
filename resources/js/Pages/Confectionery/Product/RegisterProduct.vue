<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Header from '../../components/Header.vue';
import { Link, useForm } from '@inertiajs/vue3';
import "../../../css/Forms.css";

export default {
    name: 'Home',
    props: {
        auth: Object
    },
    components: {
        AuthenticatedLayout,
        Header,
        InputLabel,
        InputError,
        PrimaryButton,
        TextInput,
        Link
    },

    setup() {

        // Inicializando o form com useForm
        const form = useForm({
            confectionery: '',
            phone: '',
            latitude: '',
            longitude: '',
            cep: '',
            city: '',
            state: '',
            neighborhood: '',
            road: ''
        });

        // Função de envio do formulário
        function submit() {
            form.post('', {
                onSuccess: () => {
                    console.log('Formulário enviado com sucesso!');
                    console.log(form);
                },
            });
        }

        return { form, submit };
    }
};
</script>

<template>

    <!-- Header -->
    <Header :auth="auth" />
    <slot />

    <AuthenticatedLayout>

        <!-- Formulário -->
        <form @submit.prevent="submit">
            <div>
                <h1>Criar Confeitaria</h1>

                <!-- Nome do Produto -->
                <div>
                    <InputLabel for="product" value="Nome do Produto" />
                    <TextInput id="product" type="text" v-model="form.product" required autofocus
                        autocomplete="product" />
                    <InputError :message="form.errors.product" />
                </div>
                <!-- Fim - Nome do Produto -->

                <!-- TValor -->
                <div>
                    <InputLabel for="valor" value="Valor:" />
                    <TextInput id="valor" type="text" v-model="form.valor" required autofocus autocomplete="valor" />
                    <InputError :message="form.errors.valor" />
                </div>
                <!-- Fim - Valor -->

                <!-- Latitudade -->
                <div>
                    <InputLabel for="latitude" value="Latitude:" />
                    <TextInput id="latitude" type="text" v-model="form.latitude" required autocomplete="latitude" />
                    <InputError :message="form.errors.latitude" />
                </div>
                <!-- Fim - Latitude -->

                <!-- Longitude -->
                <div>
                    <InputLabel for="longitude" value="Longitude:" />
                    <TextInput id="longitude" type="text" v-model="form.longitude" required autocomplete="longitude" />
                    <InputError :message="form.errors.longitude" />
                </div>
                <!-- Fim - Longitude -->

                <div>

                    <!-- CEP -->
                    <div>
                        <InputLabel for="cep" value="CEP:" />
                        <TextInput id="cep" type="text" v-model="form.cep" required autocomplete="cep" />
                        <InputError :message="form.errors.cep" />
                    </div>
                    <!-- Fim - CEP -->

                    <!-- Estado -->
                    <div>
                        <InputLabel for="state" value="Estado:" />
                        <TextInput id="state" type="text" v-model="form.state" required autocomplete="state" />
                        <InputError :message="form.errors.state" />
                    </div>
                    <!-- Fim - Estado -->

                    <!-- Cidade -->
                    <div>
                        <InputLabel for="city" value="Cidade:" />
                        <TextInput id="city" type="text" v-model="form.city" required autocomplete="city" />
                        <InputError :message="form.errors.city" />
                    </div>
                    <!-- Fim - Cidade -->

                    <!-- Bairro -->
                    <div>
                        <InputLabel for="neighborhood" value="Bairro:" />
                        <TextInput id="neighborhood" type="text" v-model="form.neighborhood" required
                            autocomplete="neighborhood" />
                        <InputError :message="form.errors.neighborhood" />
                    </div>
                    <!-- Fim - Bairro -->

                    <!-- Rua -->
                    <div>
                        <InputLabel for="road" value="Rua:" />
                        <TextInput id="road" type="text" v-model="form.road" required autocomplete="road" />
                        <InputError :message="form.errors.road" />
                    </div>
                    <!-- Fim - Rua -->
                     
                </div>

                <!-- Container do button -->
                <div style="display: flex; justify-content: space-around;">
                    <div>

                    </div>

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Criar Confeitaria
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

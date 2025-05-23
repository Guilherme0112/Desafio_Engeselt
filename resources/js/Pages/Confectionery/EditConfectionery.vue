<script setup>

import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Header from '@/Components/Header.vue';
import { ref, onMounted, watch } from 'vue';
import { useCepAddress } from '@/Scripts/autoCompleteAddress';
import { editConfectionery } from '@/Scripts/Confectionery/editConfectionery';
import "../../../css/Forms.css";
import "../../../css/Confectionery.css";

// cria a referência
// Ao clicar nos botões ele altera a parte do formulario (Endereço e Dados gerais)
let part2Form = ref(false);
function toggleParts() {
    part2Form.value = !part2Form.value;
}


// Props vindas do Inertia
const props = defineProps({
    auth: Object,
    confectionery: Object
});


// Dados do formulário inicializada
const form = useForm({
    id: props.confectionery.id || '',
    confectionery: props.confectionery.confectionery || '',
    phone: props.confectionery.phone || '',
    latitude: props.confectionery.latitude || '',
    longitude: props.confectionery.longitude || '',
    cep: props.confectionery.cep || '',
    city: props.confectionery.city || '',
    state: props.confectionery.state || '',
    neighborhood: props.confectionery.neighborhood || '',
    road: props.confectionery.road || '',
    number: props.confectionery.number || ''
});


// Usando a função para habilitar e desabilitar os campos
const {
    fetchAddressFromCep,
    fieldRoad,
    fieldCity,
    fieldState,
    fieldNeighborhood,
} = useCepAddress(form);

// Acompanhar mudanças no campo de CEP e preencher os dados automaticamente
watch(() => form.cep, async (newCep) => {
    await fetchAddressFromCep(newCep);
});


// Configura o título da aba
onMounted(() => {
    document.title = "Registrar Confeitaria";
});

// Envia formulário (Caso tenha sucesso, o backend faz o redirect)
const edit = () => {
    part2Form = editConfectionery(form);
}

</script>


<template>

    <!-- Header -->
    <Header :auth="auth" />

    <AuthenticatedLayout>

        <!-- Formulário -->
        <form @submit.prevent="edit">
            <div>

                <h1>Editar Confeitaria</h1>

                <!-- Primeira div -->
                <div class="part_1" :class="{ 'fadeIn': part2Form, 'fadeOut': !part2Form }">

                    <!-- Nome da confeitaria -->
                    <div>
                        <InputLabel for="confectionery" value="Nome da Confeitaria:" />
                        <TextInput id="confectionery" type="text" v-model="form.confectionery" required autofocus
                            autocomplete="confectionery" />
                        <InputError :message="form.errors.confectionery" />
                    </div>
                    <!-- Fim - Nome da confeitaria -->

                    <!-- Telefone -->
                    <div>
                        <InputLabel for="phone" value="Telefone:" />
                        <TextInput id="phone" type="text" v-model="form.phone" required autofocus autocomplete="phone"
                            maxlength="11" />
                        <InputError :message="form.errors.phone" />
                    </div>
                    <!-- Fim - Telefone -->

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
                        <TextInput id="longitude" type="text" v-model="form.longitude" required
                            autocomplete="longitude" />
                        <InputError :message="form.errors.longitude" />
                    </div>
                    <!-- Fim - Longitude -->

                    <div style="display: flex; justify-content: space-around;">
                        <div></div>
                        <button class="primary_button" type="button" @click="toggleParts">Próximo</button>
                    </div>

                </div>
                <!-- Fim da primeira div -->

                <!-- Segunda div -->
                <div class="part_2" :class="{ 'fadeOut': part2Form, 'fadeIn': !part2Form }">

                    <!-- CEP -->
                    <div>
                        <InputLabel for="cep" value="CEP:" />
                        <TextInput id="cep" type="text" v-model="form.cep" required autocomplete="cep" maxlength="8" />
                        <InputError :message="form.errors.cep" />
                    </div>
                    <!-- Fim - CEP -->

                    <!-- Estado -->
                    <div>
                        <InputLabel for="state" value="Estado:" />
                        <TextInput :disabled="fieldState" id="state" type="text" v-model="form.state" required autocomplete="state" />
                        <InputError :message="form.errors.state" />
                    </div>
                    <!-- Fim - Estado -->

                    <!-- Cidade -->
                    <div>
                        <InputLabel for="city" value="Cidade:" />
                        <TextInput :disabled="fieldCity" id="city" type="text" v-model="form.city" required autocomplete="city" />
                        <InputError :message="form.errors.city" />
                    </div>
                    <!-- Fim - Cidade -->

                    <!-- Bairro -->
                    <div>
                        <InputLabel for="neighborhood" value="Bairro:" />
                        <TextInput :disabled="fieldNeighborhood" id="neighborhood" type="text" v-model="form.neighborhood" required
                            autocomplete="neighborhood" />
                        <InputError :message="form.errors.neighborhood" />
                    </div>
                    <!-- Fim - Bairro -->

                    <!-- Rua -->
                    <div>
                        <InputLabel for="road" value="Rua:" />
                        <TextInput :disabled="fieldRoad" id="road" type="text" v-model="form.road" required autocomplete="road" />
                        <InputError :message="form.errors.road" />
                    </div>
                    <!-- Fim - Rua -->

                    <!-- Rua -->
                    <div>
                        <InputLabel for="number" value="Número:" />
                        <TextInput id="number" type="text" v-model="form.number" required autocomplete="number" />
                        <InputError :message="form.errors.number" />
                    </div>
                    <!-- Fim - Rua -->

                </div>
                <!-- Fim da segunda div -->

                <!-- Container do button -->
                <div :class="{ 'flex': part2Form, 'fadeIn': !part2Form }"
                    style="justify-content: space-around; padding: 0 20px;">

                    <!-- Volta para a primeira parte do formulário-->
                    <div>
                        <button type="button" class="secundary_button" @click="toggleParts">Voltar</button>
                    </div>

                    <!-- Faz a requisição para a atualização da confeitaria -->
                    <PrimaryButton :disabled="form.processing">
                        Editar Confeitaria
                    </PrimaryButton>
                </div>
                <!-- Fim do container button -->
            </div>

        </form>

    </AuthenticatedLayout>
    
</template>

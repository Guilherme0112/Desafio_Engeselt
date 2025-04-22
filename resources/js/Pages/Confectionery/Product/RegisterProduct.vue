<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Header from '@/Components/Header.vue';
import { useForm } from '@inertiajs/vue3';
import "../../../../css/Forms.css";
import { onMounted } from "vue";

const props = defineProps({
    auth: Object,
    nameConfectionery: String
});


// Inicializando o form com useForm
const form = useForm({
    product: '',
    price: '',
    description: '',
    file: '',

});


// Função de envio do formulário
function submit() {
    form.post('', {
        onError: (err) => {
            console.log(err);
        },
    });
}


// Title da página
onMounted(() => {
    document.title = props.nameConfectionery;
})
</script>

<template>

    <!-- Header -->
    <Header :auth="auth" />
    <slot />

    <AuthenticatedLayout>

        <!-- Formulário -->
        <form @submit.prevent="submit">
            <div>
                <h1>Criar Produto para    {{ props.nameConfectionery }}</h1>

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
                    <InputLabel for="price" value="Valor:" />
                    <TextInput id="price" type="text" v-model="form.price" required autofocus autocomplete="price" />
                    <InputError :message="form.errors.price" />
                </div>
                <!-- Fim - Valor -->

                <!-- Latitudade -->
                <div>
                    <InputLabel for="description" value="Descrição:" />
                    <TextInput id="description" type="text" v-model="form.description" required
                        autocomplete="description" />
                    <InputError :message="form.errors.description" />
                </div>
                <!-- Fim - Latitude -->

                <!-- Longitude -->
                <div>
                    <InputLabel for="file" value="Imagens:" />
                    <TextInput id="file" type="file" v-model="form.file" required autocomplete="file" />
                    <InputError :message="form.errors.file" />
                </div>
                <!-- Fim - Longitude -->


                <!-- Container do button -->
                <div style="display: flex; justify-content: space-around;">
                    <div>

                    </div>

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Criar Produto
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

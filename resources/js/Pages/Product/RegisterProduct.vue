<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Header from '@/Components/Header.vue';
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from "vue";
import "../../../css/Forms.css";
import "../../../css/Product.css";
import { registerProduct } from "@/Scripts/Product/registerProduct";
import { handleFile } from "@/Scripts/imagesPreview";
import { price } from "@/Scripts/formatFields";

const props = defineProps({
    auth: Object,
    confectionery: Object
});


// Inicializando o form com useForm
const form = useForm({
    product: '',
    price: '',
    description: '',
    images: [],
});

// Função de envio do formulário
const submit = () => {
    registerProduct(form, files.value, props.confectionery.id);
}

// Title da página
onMounted(() => {
    document.title = props.confectionery.name;
})

const previews = ref([])
const files = ref([])


const formatPrice = (priceField) => {
    form.price = price(priceField);
}

// Função para renderizar as imagens na preview
function handlerFilesChange(event) {
    handleFile(event, previews, files);
}

// Remove as imagens da preview
function removeImage(index) {
    previews.value.splice(index, 1)
    files.value.splice(index, 1)
}

</script>

<template>

    <!-- Header -->
    <Header :auth="auth" />

    <AuthenticatedLayout>

        <!-- Formulário -->
        <form @submit.prevent="submit">
            <div>
                <h1>Criar Produto</h1>


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
                    <div style="padding: 0;">
                        <span style="position: absolute; font-size: 18px;">R$</span>
                        <TextInput style="padding-left: 20px;" id="price" type="text" v-model="form.price" @input="formatPrice(form.price)" required autofocus autocomplete="price" />
                    </div>
                    <InputError :message="form.errors.price" />
                </div>
                <!-- Fim - Valor -->

                <!-- Descrição -->
                <div>
                    <InputLabel for="description" value="Descrição:" />
                    <TextInput id="description" type="text" v-model="form.description" required
                        autocomplete="description" />
                    <InputError :message="form.errors.description" />
                </div>
                <!-- Fim Descrição -->

                <!-- Imagens -->
                <div>
                    <div>
                        <InputLabel for="description" value="Imagens:" />

                        <input type="file" multiple @change="handlerFilesChange" accept="image/*"
                            :disabled="previews.length >= 2" />

                        <InputError :message="form.errors.images" />
                        <span>*É possível enviar até 2 imagens</span>

                    </div>
                </div>
                <!-- Fim - imagens -->


                <!-- Container do button -->
                <div style="display: flex; justify-content: space-around;">
                    <div>

                    </div>

                    <PrimaryButton :disabled="form.processing">
                        Criar Produto
                    </PrimaryButton>
                </div>

                <!-- Preview das imagens -->
                <div>
                    <div class="container_preview">
                        <h1>Preview</h1>
                        <div v-for="(img, index) in previews" :key="index">
                            <img :src="img" alt="Preview" class="img_preview" />
                            <button type="button" @click="removeImage(index)" class="removeImg">✕</button>
                        </div>
                    </div>
                </div>
                <!-- Fim - Preview das imagens -->

            </div>
        </form>
    </AuthenticatedLayout>
</template>

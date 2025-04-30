<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Header from '@/Components/Header.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, onMounted, ref } from "vue";
import { editProduct } from "@/Scripts/Product/editProduct";
import "../../../css/Forms.css";
import "../../../css/Product.css";
import { handleFile } from "@/Scripts/imagesPreview";
import { price } from "@/Scripts/formatFields";

// Props vindo do inertia
const props = defineProps({
    auth: Object,
    product: Object
});

// Função que transforma URL de imagem em File
async function fetchImageAsFile(url, filename) {
    const response = await fetch(url);
    const blob = await response.blob();
    return new File([blob], filename, { type: blob.type });
}

// Title da página
onMounted(() => {
    document.title = props.product.product;
});

// Formulário
const form = useForm({
    product: props.product.product || '',
    price: price(String(props.product.price)) || '',
    description: props.product.description || '',
    images: []
});

// Inicializando as variáveis de preview e das imagens 
// que serão enviadas ao backend
const previews = ref([]);
const files = ref([]);

// Carrega imagens já existentes como arquivos
onMounted(async () => {
    try {

        // Converte as imagens que estavam como string para JSON
        const parsed = JSON.parse(props.product.images || '[]');

        // Todas as imagens do json vão para a preview
        for (let img of parsed) {
            const file = await fetchImageAsFile(`/storage/${img}`, img);
            files.value.push(file);
            previews.value.push(URL.createObjectURL(file));
        }

    } catch (e) {
        console.error("Erro ao carregar imagens existentes:", e);
    }
});

// Envia o form com todas as imagens como File
const submit = () => {
    editProduct(form, files.value, props.product.id)
}

// Formata o preço do produto
const formatPrice = (priceField) => {
    form.price = price(priceField);
}

// Validação e renderização das imagens
function handlerFilesChange(event) {
    handleFile(event, previews, files);
}

// Remove a imagem da preview e da array de imagens que irão para o backend
function removeImage(index) {
    previews.value.splice(index, 1);
    files.value.splice(index, 1);
}
</script>


<template>

    <!-- Header -->
    <Header :auth="auth" />

    <AuthenticatedLayout>

        <!-- Formulário -->
        <form @submit.prevent="submit">
            <div>

                <h1>Editar produto</h1>

                <!-- Nome do Produto -->
                <div>
                    <InputLabel for="product" value="Nome do Produto" />
                    <TextInput id="product" type="text" v-model="form.product" required autofocus
                        autocomplete="product" />
                    <InputError :message="form.errors.product" />
                </div>
                <!-- Fim - Nome do Produto -->

                <!-- Valor -->
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
                            :disabled="previews?.length >= 2" />

                        <InputError :message="form.errors.images" />
                        <span>*É possível enviar até 2 imagens</span>

                    </div>
                </div>
                <!-- Fim - imagens -->


                <!-- Container do button -->
                <div style="display: flex; justify-content: space-around;">
                    <div>

                    </div>

                    <!-- Botão para o submit do editar produto -->
                    <PrimaryButton :disabled="form.processing">
                        Editar Produto
                    </PrimaryButton>
                </div>
                <!-- Fim do container button -->

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

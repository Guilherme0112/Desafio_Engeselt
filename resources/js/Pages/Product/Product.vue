<script setup>
import { onMounted, ref } from 'vue';
import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import "../../../css/Product.css";
import { currency, phone } from "@/Scripts/formatFields";

const props = defineProps({
    auth: Object,
    product: Object,
    confectionery: Object
})

// Título da página
onMounted(() => {
    document.title = props.product.product
})

// Converte as imagens de JSON para array
const images = JSON.parse(props.product.images);

// Status para saber qual imagem deve estar na principal
let statusImg = 0;

// Variável para salvar a posição das imagens
const currentImage = ref(images[0]);
const secundaryImage = ref(images[1])

// Verifica se existe a segunda imagem, caso não exista ele oculta a imagem secundária
let existSecundaryImage = false;
if(images[1] != null) existSecundaryImage = true;

// Função para alternar a imagem primaria e secundária
function setMainImage() {

    // Se quando acionado, o status for igual a 0, ele altera a imagem pricipal 
    // para o índice 1 e coloca imagem que estava na principal para a secundária
    if(statusImg === 0){

        currentImage.value = images[1];
        secundaryImage.value = images[0];
        statusImg = 1;
    } else {
        // Já, se o status for igual a 1, logo a imagem do índice 0 que deverá ser a principal
        
        currentImage.value = images[0];
        secundaryImage.value = images[1];
        statusImg = 0
    }


}
</script>

<template>
    <Header :auth="auth" />

    <div class="container_pai_product">

        <!-- Imagem principal, agora usa currentImage -->
        <img :src="'/storage/' + currentImage" alt="Produto" class="main-image" />

        <div class="image-thumbnails" v-if="existSecundaryImage">
            <!-- Imagem pequena lateral, agora usa setMainImage ao clicar -->
            <img :src="'/storage/' + secundaryImage" alt="Imagem secundária" class="thumbnail"
                @click="setMainImage()" />
        </div>

        <div class="details">
            <h1 class="product-title">{{ props.product.product }}</h1>
            <div class="price">
                <span class="currency">R$</span>
                <span class="amount">{{ currency(props.product.price) }}</span>
            </div>
            <div class="description">
                {{ props.product.description }}
            </div>
            <div style="display: flex;">
                <a class="primary_button"
                    :href="`https://wa.me/${props.confectionery.phone}?text=Olá!%20Tenho%20interesse%20em%20um%20dos%20seus%20produtos`"
                    target="_blank">
                    Entrar em Contato via WhatsApp
                </a>

                <p style="margin-left: 20px;">Visite a loja <Link class="store-link" :href="`/confectionery/${props.confectionery.id}`">
                        {{ props.confectionery.confectionery }}</Link></p>
            </div>
            <div class="store-info">
                <p><strong>Telefone:</strong> {{ phone(props.confectionery.phone) }}</p>
                <p><strong>CEP:</strong> {{ props.confectionery.cep }}</p>
                <p><strong>Cidade:</strong> {{ props.confectionery.city }}</p>
                <p><strong>Estado:</strong> {{ props.confectionery.state }}</p>
            </div>
        </div>
    </div>

</template>
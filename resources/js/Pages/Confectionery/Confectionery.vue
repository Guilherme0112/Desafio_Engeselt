<script setup>

import Header from '@/Components/Header.vue';
import { onMounted } from 'vue';
import "../../../css/Confectionery.css";

// Props vindo do inertia
const props = defineProps({
    auth: Object,
    confectionery: Object
})

// Title da página
onMounted(() => {
    document.title = props.confectionery.confectionery;
})


</script>

<template>

    <!-- Header -->
    <Header :auth="auth" />

    <main>

        <!-- Nome da confeitaria -->
        <div class="title">
            <h1>{{ props.confectionery.confectionery }}</h1>
        </div>

        <!-- Informações gerais da confeitaria -->
        <section class="info_section">
            <div class="info_card"><strong>Nome</strong>{{ props.confectionery.confectionery }}</div>
            <div class="info_card"><strong>Telefone</strong>{{ props.confectionery.phone }}</div>
            <div class="info_card"><strong>CEP</strong>{{ props.confectionery.cep }}</div>
            <div class="info_card"><strong>Cidade</strong>{{ props.confectionery.city }}</div>
            <div class="info_card"><strong>Estado</strong>{{ props.confectionery.state }}</div>
            <div class="info_card"><strong>Bairro</strong>{{ props.confectionery.neighborhood }}</div>
            <div class="info_card"><strong>Rua</strong>{{ props.confectionery.road }}</div>
            <div class="info_card"><strong>Número</strong>{{ props.confectionery.number }}</div>
        </section>

        <section class="products_section">
            <h2>Produtos</h2>

            <!-- Será exibido quando não há produtos -->
            <div>


            </div>

            <!-- Template para produtos -->
            <div class="product_card">
                <div class="product_image">
                    <img src="" alt="Nome do Produto">
                </div>
                <div class="product_info">
                    <h2 class="product_name">Nome do Produto</h2>
                    <p class="product_description">Descrição detalhada e irresistível do produto, destacando o sabor e a
                        qualidade.</p>
                    <span class="product_price">R$ 19,90</span>
                </div>
            </div>
        </section>

    </main>

</template>

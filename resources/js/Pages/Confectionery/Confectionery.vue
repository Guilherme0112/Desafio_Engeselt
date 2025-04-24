<script setup>

import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { currency } from '@/Scripts/formatFields';
import "../../../css/Confectionery.css";
import "../../../css/Product.css";

// Props vindo do inertia
const props = defineProps({
    auth: Object,
    confectionery: Object,
    products: Object
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
            <div style="margin: 40px 0; display: flex; justify-content: space-between; flex-wrap: wrap;">
                <h2>Produtos</h2>
                <Link :href="`/confectionery/${props.confectionery.id}/product/create`" class="primary_button">Criar
                Produto para esta confeitaria</Link>
            </div>

            <!-- Será exibido quando não há produtos -->
            <div v-if="props.products.length < 1">

                <h1>Não há produtos registrados</h1>

            </div>

            <div v-else class="container_show_products">
                <!-- Template para produtos -->
                <div class="product_card" v-for="product in products" :key="product.id">
                    <Link :href="`/confectionery/${product.id_confectionery}/product/${product.id}`">
                        <div class="product_image">
                            <img v-if="product.images && product.images.length > 0"
                                :src="`/storage/${JSON.parse(product.images)[0]}`" :alt="product.product">
                        </div>

                        <div class="product_info">

                            <h2 class="product_name">{{ product.product }}</h2>
                            <p class="product_description">{{ product.description }}</p>
                            <span class="product_price">R$ <span style="font-size: 30px;">{{ currency(product.price) }}</span></span>

                        </div>
                    </Link>
                </div>
            </div>
        </section>

    </main>

</template>

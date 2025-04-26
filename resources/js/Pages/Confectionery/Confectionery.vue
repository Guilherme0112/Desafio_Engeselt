<script setup>

import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted } from 'vue';
import { currency, phone } from '@/Scripts/formatFields';
import { useMenuDropdown } from "@/Scripts/useMenuDropdown";
import { deleteProduct } from '@/Scripts/Product/deleteRegister';
import 'leaflet/dist/leaflet.css';
import "../../../css/Confectionery.css";
import "../../../css/Product.css";
import { renderMap } from '@/Scripts/leaflet';

const { activeMenu, toggleMenu, setMenuRef, handleClickOutside } = useMenuDropdown();

// Props vindo do inertia
const props = defineProps({
    auth: Object,
    confectionery: Object,
    products: Object
})

// Função para deletar o produto
function deleteItem(id) {
    deleteProduct(id);
}

onMounted(() => {

    // Função que renderiza a confeitaria no mapa
    renderMap(props.confectionery.longitude, 
              props.confectionery.latitude, 
              `Confeitaria ${props.confectionery.confectionery}! <br/> Entre em contato ${phone(props.confectionery.phone)}`
    );

    // Título da página
    document.title = props.confectionery.confectionery;

    // Ativa o evento para exibir as opções no botão de opções
    document.addEventListener('click', handleClickOutside)
});

// Remove o event listener que deixa o botão de opções com as opções exibidas
onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
});

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
            <div class="info_card"><strong>Telefone</strong>{{ phone(props.confectionery.phone) }}</div>
            <div class="info_card"><strong>CEP</strong>{{ props.confectionery.cep }}</div>
            <div class="info_card"><strong>Cidade</strong>{{ props.confectionery.city }}</div>
            <div class="info_card"><strong>Estado</strong>{{ props.confectionery.state }}</div>
            <div class="info_card"><strong>Bairro</strong>{{ props.confectionery.neighborhood }}</div>
            <div class="info_card"><strong>Rua</strong>{{ props.confectionery.road }}</div>
            <div class="info_card"><strong>Número</strong>{{ props.confectionery.number }}</div>
        </section>
        <!-- Fim das informações gerais -->

        <!-- Mapa onde mostra a localização da confeitaria -->
        <section style="display: flex; justify-content: center; margin: 80px 0;">
            <div id="map" style="height: 400px; width: 80%;"></div>
        </section>
        <!-- fIM do mapa onde mostra a localização da confeitaria -->

        <!-- Produtos -->
        <section class="products_section">

            <!-- Título e botão de criar produto -->
            <div style="margin: 40px 0; display: flex; justify-content: space-between; flex-wrap: wrap;">
                <h2>Produtos</h2>
                <Link :href="`/confectionery/${props.confectionery.id}/product/create`" class="primary_button">Criar
                Produto para esta confeitaria</Link>
            </div>
            <!-- Fim do título e botão de criar produto -->

            <!-- Será exibido quando não há produtos -->
            <div v-if="props.products.length < 1">
                <h1>Não há produtos registrados</h1>
            </div>

            <!-- Renderização dos produtos (Caso existam) -->
            <div v-else class="container_show_products">

                <!-- Template para produtos -->
                <div class="product_card" v-for="product in products" :key="product.id">

                    <!-- Botão de opções -->
                    <div class="menu-wrapper" v-if="auth.user">

                        <button @click.stop="toggleMenu(product.id)" class="menu-button">⋮</button>

                        <div class="dropdown" v-show="activeMenu === product.id" :ref="setMenuRef(product.id)">

                            <div class="dropdown-content" style="display: grid;">

                                <Link :href="`/confectionery/product/update/${product.id}`">Editar</Link>
                                <button @click="deleteItem(product.id)">Deletar</button>

                            </div>
                        </div>

                    </div>
                    <!-- Fim do botão de opções -->

                    <Link :href="`/confectionery/${product.id_confectionery}/product/details/${product.id}`">

                        <!-- Imagem do produto -->
                        <div class="product_image">
                            <img v-if="product.images && product.images.length > 0"
                                :src="`/storage/${JSON.parse(product.images)[0]}`" :alt="product.product">
                        </div>
                        <!-- Fim da imagem do produto -->

                        <!-- Informações do produto -->
                        <div class="product_info">

                            <h2 class="product_name">{{ product.product }}</h2>
                            <p class="product_description">{{ product.description }}</p>
                            <span class="product_price">R$ <span style="font-size: 30px;">
                                    {{ currency(product.price) }}
                                </span></span>

                        </div>
                    <!-- Fim das informações do produto -->

                    </Link>
                </div>
                <!-- Fim do template para produtos -->

            </div>

            <!-- Fim da renderização dos produtos -->
        </section>

    </main>

</template>

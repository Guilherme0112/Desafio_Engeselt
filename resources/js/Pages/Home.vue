<script setup>

import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import '../../css/Home.css';
import { onMounted } from 'vue';
import { renderMap } from '@/Scripts/leaflet';
import { router } from "@inertiajs/vue3"

// Recebe props do inertia
defineProps({
    auth: Object
})

// Renderiza o mapa (Como não é passado parametros ele vai exibir a posição do usuário caso ele permita)
onMounted(() => {
    renderMap();
})

// Título da página
document.title = "Início"

</script>
<template>

    <!-- Header -->
    <Header :auth="auth" />

    <!-- Container principal -->
    <div style="margin-top: 100px; width: 100%;">


        <!-- Container 1 -->
        <section class="container container_1">

            <!-- Texto -->
            <div>
                <h1>Sua plataforma para conectar e organizar o mundo da confeitaria!</h1>
                <p>
                    Aqui, você encontra um ambiente completo e intuitivo pensado para confeiteiros locais que desejam
                    divulgar
                    seus produtos, cadastrar suas lojas e gerenciar seus negócios de forma prática e eficiente.
                </p>
            </div>

            <!-- Imagem -->
            <div>
                <img src="../../assets/bolo1.webp" class="img_container">
            </div>

        </section>
        <!-- Fim do container 1 -->

        <!-- Container 2 -->
        <section class="container container_2">

            <!-- Imagem -->
            <div>
                <img src="../../assets/bolo2.png" class="img_container">
            </div>

            <!-- Texto -->
            <div>
                <h1>Unindo Confeiteiros, Encantando Clientes</h1>
                <p>
                    Conectar confeiteiros é muito mais do que trocar receitas — é criar uma rede de colaboração que
                    eleva a
                    qualidade e a criatividade na confeitaria. Quando profissionais
                    compartilham experiências, técnicas e ideias, o resultado é um produto final mais inovador,
                    personalizado e
                    saboroso.
                </p>
            </div>

        </section>
        <!-- Fim do container 2 -->

        <!-- Container de mapa -->
        <section style="display: flex; justify-content: center; flex-wrap: wrap;">
            <h1>Encontre confeitarias perto de você</h1>
            <div id="map" style="height: 400px; width: 80%; margin: 60px 0;"></div>
        </section>
        <!-- Fim do container de mapa -->

        <!-- Footer -->
        <Footer />

    </div>
    <!-- Fim do container principal -->

</template>

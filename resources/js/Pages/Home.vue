<script setup>

import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import '../../css/Home.css'; 
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
import { onMounted } from 'vue';

defineProps({
  auth: Object
})

onMounted(() => {
  let map = L.map('map').setView([43.543450, 56.432420], 7);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)
})

document.title = "Início"

</script>
<template>
    

    <Header :auth="auth"/>
    <slot />

    <div style="margin-top: 100px; width: 100%;">


      <!-- Container 1 -->
      <section class="container container_1">  
          <div>
            <h1>Sua plataforma para conectar e organizar o mundo da confeitaria!</h1>
            <p>
              Aqui, você encontra um ambiente completo e intuitivo pensado para confeiteiros locais que desejam divulgar 
              seus produtos, cadastrar suas lojas e gerenciar seus negócios de forma prática e eficiente.
            </p>
          </div>

          <div>
            <img src="../../assets/bolo1.webp" class="img_container">
          </div>
        </section>
        <!-- Fim do container 1 -->
        
        <!-- Container 2 -->
        <section class="container container_2">
          <div>
            <img src="../../assets/bolo2.png" class="img_container">
          </div>

          <div>
            <h1>Unindo Confeiteiros, Encantando Clientes</h1>
            <p>
              Conectar confeiteiros é muito mais do que trocar receitas — é criar uma rede de colaboração que eleva a qualidade e a criatividade na confeitaria. Quando profissionais 
              compartilham experiências, técnicas e ideias, o resultado é um produto final mais inovador, personalizado e saboroso. 
            </p>
          </div>
        </section>
        <!-- Fim do container 2 -->

        <!-- Container 3 -->
        <section class="container container_3">

          <h1>Encontre confeitarias perto de você</h1>

          <div>
            
          </div>
        </section>
        <!-- Fim do container 3 -->

        <section>
          <div id="map" style="height: 400px;"></div>
        </section>

        <Footer />

    </div>
</template>


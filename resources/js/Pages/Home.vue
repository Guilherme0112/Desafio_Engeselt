<script>

import Header from '../components/Header.vue';
import '../../css/Home.css'; 

export default {
  name: 'Home',
  props: {
    auth: Object
  },
  components: {
    Header
  }
};
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



    </div>
</template>


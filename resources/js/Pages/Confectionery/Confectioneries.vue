<script>

import Header from '@/Components/Header.vue';
import "../../../css/Confectionery.css";
import "../../../css/Forms.css";

export default {
  name: 'Marketplace',
  props: {
    auth: Object
  },
  components: {
    Header
  }
};

document.title = "Marketplace";

</script>
<template>
    
    <Header :auth="auth"/>
    <slot />

    
    <div class="container_search">
      <span>Nome da empresa:</span>
      <input type="search" name="" id="">
    </div>

   <section>

      <div class="container_confectionery">
        <span>Nome da empresa</span>
        <p>(00) 00000-0000</p>
        <p>João Pessoa - PB</p>
      </div>
   </section>
</template>


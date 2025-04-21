<script setup>

import Header from '@/Components/Header.vue';
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import "../../../css/Confectionery.css";
import "../../../css/Forms.css";
import { useMenuDropdown } from "@/Scripts/useMenuDropdown";
import { deleteConfectionery } from '@/Scripts/Confectionery/deleteConfectionery';

const { activeMenu, toggleMenu, setMenuRef, handleClickOutside } = useMenuDropdown();

// Props do inertia
const props = defineProps({
	auth: Object,
	confectioneries: Object
});


// Config para o carregamento das confeitarias
const page = ref(props.confectioneries.current_page)
const loading = ref(false)
const allConfectioneries = ref([...props.confectioneries.data])

// Evento que gera a busca de mais dados
const handleScroll = () => {
	const bottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 100
	if (bottom && !loading.value && page.value < props.confectioneries.last_page) {
		fetchMore();
	}
}

// Requisição que busca mais dados
const fetchMore = () => {
	loading.value = true
	page.value++

	// Faz a requisição para a rota
	router.get(route('confectionies.index'), { page: page.value }, {

		preserveScroll: true,
		preserveState: true,
		only: ['confectioneries'],

		onSuccess: (page) => {
			allConfectioneries.value.push(...page.props.confectioneries.data)
			loading.value = false
		}
	});
}

// Deleta confeitaria
function deleteItem(id) {
	deleteConfectionery(id);
}


onMounted(() => {
	window.addEventListener('scroll', handleScroll);
	document.addEventListener('click', handleClickOutside)
});

onBeforeUnmount(() => {
	window.removeEventListener('scroll', handleScroll);
	document.removeEventListener('click', handleClickOutside)
});

document.title = "Marketplace";

</script>

<template>

	<!-- Header da página -->
	<Header :auth="auth" />

	<!-- Campo de busca pelo nome da empresa  -->
	<div class="container_search">
		<span>Nome da empresa:</span>
		<input type="search">
	</div>

	<section class="container_show_confectioneries">

		<!-- Template que renderiza as informações da confeitaria -->
		<div class="container_confectionery" v-for="confectionery in confectioneries.data" :key="confectionery.id">

			<Link :href="`/confectionery/${confectionery.id}`" class="link_container">
			<!-- Nome da confeitaria -->
			<h2>{{ confectionery.confectionery }}</h2>

			<!-- Informações básicas -->
			<div>
				<p><strong>Telefone:</strong> {{ confectionery.phone }}</p>
				<p><strong>CEP:</strong> {{ confectionery.cep }}</p>
				<p><strong>Cidade:</strong> {{ confectionery.city }}</p>
				<p><strong>Estado:</strong> {{ confectionery.state }}</p>
			</div>
			</Link>

			<!-- Botão de 3 pontos -->
			<div class="menu-wrapper">

				<button @click.stop="toggleMenu(confectionery.id)" class="menu-button">⋮</button>

				<!-- Correção no ref: -->
				<div class="dropdown" v-show="activeMenu === confectionery.id" :ref="setMenuRef(confectionery.id)">
					<div class="dropdown-content">
						<Link :href="`/confectionery/update/${confectionery.id}`">Editar</Link>
						<button @click="deleteItem(confectionery.id)">Deletar</button>
					</div>
				</div>

			</div>

		</div>

		<div v-if="loading">Carregando...</div>

	</section>
</template>

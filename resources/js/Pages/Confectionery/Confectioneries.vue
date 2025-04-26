<script setup>

import Header from '@/Components/Header.vue';
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { useMenuDropdown } from "@/Scripts/useMenuDropdown";
import { deleteConfectionery } from '@/Scripts/Confectionery/deleteConfectionery';
import { phone } from '@/Scripts/formatFields';
import "../../../css/Confectionery.css";
import "../../../css/Forms.css";

const { activeMenu, toggleMenu, setMenuRef, handleClickOutside } = useMenuDropdown();

// Props do inertia
const props = defineProps({
	auth: Object,
	confectioneries: Object
});


const allConfectioneries = ref([])
allConfectioneries.value = props.confectioneries.data


// Evento que gera a busca de mais dados
const handleScroll = () => {
	const bottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 100
	if (bottom && page.value < props.confectioneries.last_page) {
		fetchMore();
	}
}

// Config para o carregamento das confeitarias
const page = ref(1)
const searchTerm = ref('')

const fetchMore = () => {

	// Sempre reseta a página na primeira busca (útil para digitar algo novo)
	page.value = 1

	router.get(route('confectionery.index'), {
		page: page.value,
		search: searchTerm.value
	}, {
		preserveScroll: true,
		preserveState: true,
		only: ['confectioneries'],
		onSuccess: (page) => {
			// Substitui os dados anteriores pelos novos
			allConfectioneries.value = page.props.confectioneries.data
		}
	})
}
// Deleta confeitaria
function deleteItem(id) {
	deleteConfectionery(id);
}

// Ouvinte do scroll para chamar mais dados quando o usuário chegar no final da página
// Acionamento do evento que pode ativar o botão de opções
onMounted(() => {
	window.addEventListener('scroll', handleScroll);
	document.addEventListener('click', handleClickOutside)
});

// Remove os ouvintes
onBeforeUnmount(() => {
	window.removeEventListener('scroll', handleScroll);
	document.removeEventListener('click', handleClickOutside)
});

// Título da página
document.title = "Marketplace";

</script>

<template>

	<!-- Header da página -->
	<Header :auth="auth" />

	<!-- Campo de busca pelo nome da empresa  -->
	<div class="container_search">
		<span>Nome da empresa:</span>
		<input type="search" v-model="searchTerm">
		<button @click="fetchMore" class="primary_button" style="margin: 20px 0 0 0;">Buscar</button>
	</div>


	<section class="container_show_confectioneries">

		<!-- Caso não haja produtos -->
		<div v-if="allConfectioneries.length === 0">
			<h1>Não há confeitarias cadastradas</h1>
		</div>


		<!-- Template que renderiza as informações da confeitaria -->
		<div class="container_confectionery" v-for="confectionery in allConfectioneries" :key="confectionery.id" v-else>



			<!-- Botão de 3 pontos -->
			<div class="menu-wrapper" v-if="auth.user">

				<button @click.stop="toggleMenu(confectionery.id)" class="menu-button">⋮</button>

				<div class="dropdown" v-show="activeMenu === confectionery.id" :ref="setMenuRef(confectionery.id)">
					<div class="dropdown-content">
						<Link :href="`/confectionery/update/${confectionery.id}`">Editar</Link>
						<button @click="deleteItem(confectionery.id)">Deletar</button>
					</div>
				</div>

			</div>
			<!-- Fim do botão de 3 opções -->

			<!-- Confeitaria -->
			<Link :href="`/confectionery/details/${confectionery.id}`" class="link_container">

			<!-- Nome da confeitaria -->
			<h2>{{ confectionery.confectionery }}</h2>

			<!-- Informações básicas -->
			<div>
				<p><strong>Telefone:</strong> {{ phone(confectionery.phone) }}</p>
				<p><strong>CEP:</strong> {{ confectionery.cep }}</p>
				<p><strong>Cidade:</strong> {{ confectionery.city }}</p>
				<p><strong>Estado:</strong> {{ confectionery.state }}</p>
			</div>
			<!-- Fim das informações -->

			</Link>
			<!-- Fim da confeitaria -->


		</div>

	</section>
</template>

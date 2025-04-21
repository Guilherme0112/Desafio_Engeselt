import { ref } from 'vue'

/** Função para o mini menu dos 3 pontinhos do marketplace
 * 
 * @returns 
 */
export function useMenuDropdown() {

  // Inicializa as variaveis
  const activeMenu = ref(null);
  const menuRefs = ref({});

  // Função para alternar o menu ativo
  // Se o id clicado já estiver ativo, ele fecha (seta como null), senão abre o novo
  const toggleMenu = (id) => {
    activeMenu.value = activeMenu.value === id ? null : id
  }

  // Função que registra o elemento de referência (ref) do menu baseado no id
  // Usado para verificar se o clique ocorreu fora do menu depois
  const setMenuRef = (id) => {
    return (el) => {
      if (el) menuRefs.value[id] = el
    }
  }

  // Função que fecha o menu caso o clique tenha ocorrido fora de qualquer dropdown visível
  // Verifica se o clique ocorreu dentro de algum menu armazenado em menuRefs
  const handleClickOutside = (event) => {
    const clickedInside = Object.values(menuRefs.value).some(el => el?.contains(event.target))
    if (!clickedInside) {
      activeMenu.value = null
    }
  }

  // Exporta os dados e funções para serem usados no componente Vue
  return {
    activeMenu,
    toggleMenu,
    setMenuRef,
    handleClickOutside,
    menuRefs
  }
}
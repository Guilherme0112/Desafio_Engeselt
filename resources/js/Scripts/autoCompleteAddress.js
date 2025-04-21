import { ref } from 'vue';

/** Faz a requisição para buscar os dados do CEP
 * 
 * @param {*} cep CEP sem caracteres especiais
 * @returns Array com os dados do CEP
 */
export async function autoCompleteAddress(cep) {
    try {

        // Verifica se o CEP tem a largura certa
        if (!cep || cep.length < 8) {
            throw new Error("O cep é inválido");
        }

        // Faz a requisição
        const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`, {
            method: "GET"
        });

        // Verifica se há erros
        if (!res.ok) {
            throw new Error("Ocorreu algum erro. Tente novamente mais tarde");
        }

        // Retorna a resposta
        return await res.json();

    } catch (error) {
        throw error;
    }
}

/** Função para habilitar e desabilitar os campos
 * que foram preenchidos automaticamente
 * 
 * @param {*} form Dados do formulário
 * @returns 
 */
export function useCepAddress(form) {

    // Inicializa as variaveis
    let fieldNeighborhood = ref(false);
    let fieldState = ref(false);
    let fieldCity = ref(false);
    let fieldRoad = ref(false);

    // Função para atualizar os estados de habilitação
    // O !! compacta o valor para boolean (se a string for vazia é false e se 
    // tiver alguma coisa é true)
    function updateFieldState(address) {
        fieldRoad.value = !!address.logradouro;
        fieldCity.value = !!address.localidade;
        fieldState.value = !!address.estado;
        fieldNeighborhood.value = !!address.bairro;
    }

    // Função que busca o endereço com base no CEP
    async function fetchAddressFromCep(newCep) {

        // Se não houver CEP`, não desabilita nada
        if (!newCep) {
            fieldRoad.value = false;
            fieldCity.value = false;
            fieldState.value = false;
            fieldNeighborhood.value = false;
            return;
        }

        // Se houver el  faz a requisição para buscar os dados
        try {

            // Chama a função que busca os dados
            const address = await autoCompleteAddress(newCep);

            // Se houver resposta, ele atualiza os dados de acordo com os campos retornados
            if (address) {

                form.road = address.logradouro || "";
                form.city = address.localidade || "";
                form.state = address.estado || "";
                form.neighborhood = address.bairro || "";

                // Habilita/Desabilita de acordo com os dados retprnados
                updateFieldState(address);
            }
        } catch (error) {
            console.error("Erro ao buscar endereço:", error);
        }
    }

    return {
        fetchAddressFromCep,
        fieldRoad,
        fieldCity,
        fieldState,
        fieldNeighborhood,
    };
}

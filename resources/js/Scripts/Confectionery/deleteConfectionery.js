import { router } from '@inertiajs/vue3'

/** Função que deleta registros de confeitarias
 * 
 * @param {*} id Id da confeitaria
 */
export function deleteConfectionery(id){

	// Confirma que o usuário deseja deletar a confeitaria
    if (confirm("Tem certeza que deseja deletar esta confeitaria?")) {

		// Faz a requisição caso o usuário confirme
		router.delete(route('confectionery.destroy', id), {
			onError: (err) => {
				console.error("Erro ao deletar a confeitaria: " + err);
			}
		});
	}
}

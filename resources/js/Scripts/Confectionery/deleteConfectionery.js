import { router } from '@inertiajs/vue3'

/** Função que deleta registros de confeitarias
 * 
 * @param {*} id Id da confeitaria
 * @returns Promise que resolve se a exclusão for bem-sucedida
 */
export function deleteConfectionery(id) {

	// Confirma que o usuário deseja deletar a confeitaria
	return new Promise((resolve, reject) => {
		if (confirm("Tem certeza que deseja deletar esta confeitaria?")) {

			// Faz a requisição caso o usuário confirme
			router.delete(route('confectionery.destroy', id), {
				onSuccess: () => resolve(), // Resolve a promessa após a exclusão
				onError: (err) => {
					console.error("Erro ao deletar a confeitaria: " + err);
					reject(err); // Rejeita em caso de erro
				}
			});
			
		} else {
			// Caso o usuário cancele a confirmação
			reject('Cancelado pelo usuário');
		}
	});
}

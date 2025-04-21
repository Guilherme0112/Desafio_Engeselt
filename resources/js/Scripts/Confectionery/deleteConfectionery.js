import { router } from '@inertiajs/vue3'

/** Função que deleta registros de confeitarias
 * 
 * @param {*} id Id da confeitaria
 */
export function deleteConfectionery(id){

    if (confirm("Tem certeza que deseja deletar esta confeitaria?")) {

		router.delete(route('confectionery.destroy', id), {

			onError: (err) => {
				console.error("Erro ao deletar a confeitaria: " + err);
			}
		});
	}
}

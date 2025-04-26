import { router } from '@inertiajs/vue3';

/** Método que tenta fazer o delete de um produto
 * 
 * @param {*} productId Id do produto que será deletado
 */
export function deleteProduct(productId) {

    // Confirmação antes de deleter o produto
    if (confirm("Tem certeza que deseja deletar esta confeitaria?")) {

        // Requisição para tentar deletar o produto
        router.delete(route('product.destroy', productId), {
            onError: (err) => {
                console.error("Erro ao deletar a confeitaria: " + err);
            }
        });
    }
}
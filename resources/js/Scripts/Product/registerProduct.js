
/** Método que registra um produto no banco de dados
 * 
 * @param {*} form Dados do formulário
 * @param {*} photos Fotos do produto
 * @param {*} confectioneryId Id da confeitaria que receberá o produto
 */
export function registerProduct(form, photos, confectioneryId){

    // Coloca as imagens na array do formulário
    form.images = photos;

    // Faz a requisição para o registro
    form.post(route('product.store', confectioneryId), {
        forceFormData: true,
        onError: (err) => {
            console.log(err)
        },
    });
}
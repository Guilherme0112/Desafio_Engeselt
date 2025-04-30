import { price } from "../formatFields";

/** Método que faz a requisição para atualizar o produto
 * 
 * @param {*} form Dados do formulário
 * @param {*} photos Imagens do produto
 * @param {*} productId Id do produto
 */
export function editProduct(form, photos, productId){

    // Retira as formatações do preço
    form.price = form.price.replace(/\./g, "")  
                           .replace(",", ".")  
                           .trim()

    // Coloca as imagens na array do formulário
    form.images = photos;

    // Faz a requisição para a atualização
    form.post(route('product.update', productId), {
        forceFormData: true,
        onError: (err) => {
            console.log(err);
        },
    });

    // Adiciona a formatação de novo
    form.price = price(form.price)
}
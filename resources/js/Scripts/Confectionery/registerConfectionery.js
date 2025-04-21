
/** Função que faz a requisição para criar uma confeitaria
 * 
 * @param {*} form Array do formulário com os dados
 */
export function registerConfectionery(form) {

    // Requisição POST para a rota
    form.post(route('confectionery.store'), {
        onError: (err) => {
            console.log(err)
            return false
        },
    });
}
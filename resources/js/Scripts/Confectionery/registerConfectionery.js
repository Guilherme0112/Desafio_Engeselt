
/** Função que faz a requisição para criar uma confeitaria
 * 
 * @param {*} form Array do formulário com os dados
 */
export function registerConfectionery(form) {

    // Remove a formatação dos campos
    form.cep = form.cep.replace(/\D/g, '');
    form.phone = form.phone.replace(/\D/g, '');

    // Requisição POST para a rota
    form.post(route('confectionery.store'), {
        onError: (err) => {
            console.log(err)
            return false
        },
    });
}

/** Método que faz a requisição para atualizar os dados de um
 * registro
 * 
 * @param {*} form Array do formulário com os dados
 */
export function editConfectionery(form) {
    form.patch(route('confectionery.update', form.id), {
        onError: () => {
            return false;
        },
    });
}
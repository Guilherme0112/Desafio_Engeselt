
/** Método responsavel por renderizar e validar as imagens no frontend
 * 
 * @param {*} event Conteém informações sobre o evento
 * @param {*} previews Dados para a renderização das imagens
 * @param {*} files Os arquivos das imagens
 */
export function handleFile(event, previews, files) {

    // Imagens recebidas do evento
    const selectedFiles = Array.from(event.target.files)

    // Verifica se ao adicionar os novos arquivos vai passar de 2
    if (previews.value.length + selectedFiles.length > 2) {
        alert("Você só pode adicionar no máximo 2 imagens.")
        return
    }

    // Renderiza todas as imagens da array
    selectedFiles.forEach(file => {
        const reader = new FileReader()
        reader.onload = e => {
            previews.value.push(e.target.result)
            files.value.push(file)
        }
        reader.readAsDataURL(file)
    })
}


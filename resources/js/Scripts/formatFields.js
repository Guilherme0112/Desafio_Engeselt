/** Formata números para nossa conversão local (Troca os pontos por vírgulas)
 * Coloquei para formatar somente o valor e não retornar com o R$ pq queria poder estilizar
 * o tamanho do R$ e do preço
 * 
 * @param {*} price Valor que será formatado (ex: 29.99)
 * @returns Valor formatado (29,99)
 */
export function currency(price) {


    return new Intl.NumberFormat("pt-BR", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    }).format(price);
  }
  
  /** Formata os números de celulares (Deve ter 11 caracteres)
   * 
   * @param {*} number Número de celular
   * @returns Número formatado
   */
  export function phone(number) {

    // Remove caracteres que não são dígitos
    const cleaned = number.replace(/\D/g, '');

    // Transforma a string em uma array
    const match = cleaned.match(/(\d{2})(\d{5})(\d{4})/);
  
    // Se ocorrer tudo certo, ele retorna o número formatado
    if (match) return `(${match[1]}) ${match[2]}-${match[3]}`;

    // Em caso de erro ele so retorna o número sem formatação
    return number;
  }

  /** Formata os números de celulares (Deve ter 11 caracteres)
   * 
   * @param {*} number Número de celular
   * @returns Número formatado
   */
  export function cep(cep) {

    // Remove caracteres que não são dígitos
    const cleaned = cep.replace(/\D/g, '');

    // Transforma a string em uma array
    const match = cleaned.match(/(\d{5})(\d{3})/);
  
    // Se ocorrer tudo certo, ele retorna o número formatado
    if (match) return `${match[2]}-${match[3]}`;

    // Em caso de erro ele so retorna o número sem formatação
    return number;
  }
  
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
import { phone } from './formatFields';

/** Método que renderiza o mapa
 * 
 * @param {*} longitude Longitude (Opcional)
 * @param {*} latitude Latitude (Opcional)
 * @param {*} description Descrição (Opcional)
 * 
 * @returns Pode retornar a localização do usuário caso não haja parametros, pode retornar a lcoalização
 * passada nos parametros (Todos deve ser preenchidos para funcionar), ou renderizar uma localização padrão caso o 
 * navegador não permita a localização
 */
export async function renderMap(longitude, latitude, description) {

    // Coloca uma posição padrão e renderiza o mapa na tela
    let map = L.map('map').setView([43.543450, 56.432420], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // Se houver paramentros, ele renderiza a dos parametros
    if (longitude && latitude && description) {

        // Atualiza o mapa para a localização do usuário
        map.setView([latitude, longitude], 15);

        // Adiciona um marcador no local do usuário
        return L.marker([latitude, longitude]).addTo(map)
            .bindPopup(description)
            .openPopup();

    } else if (navigator.geolocation) {

        // Se não houver paramentros, ele renderiza a posição atual do usuário (Caso ele permita)
        return navigator.geolocation.getCurrentPosition(

            async function (position) {

                // Cordenadas do usuário
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Busca as confeitarias em um raio de 10km
                const response = await axios.get('/location', {
                    params: {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    }
                })

                // Se houver, ele as adiciona no mapa
                if (response.data) {

                    // Adiciona cada confeitaria no mapa home, inserindo também o nome
                    // e telefone da confeitaria
                    response.data.forEach(confeitaria => {
                        L.marker([confeitaria.latitude, confeitaria.longitude])
                            .addTo(map)
                            .bindPopup(`${confeitaria.confectionery} - entre em contato ${phone(confeitaria.phone)}`);
                    });
                }


                // Atualiza o mapa para a localização do usuário
                map.setView([lat, lng], 15);

                // Adiciona um marcador no local do usuário
                L.marker([lat, lng]).addTo(map)
                    .bindPopup('Você está aqui!')
                    .openPopup();
            },
        )
    }
}
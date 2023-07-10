const RUTA_GLOBAL = "http://localhost/botanero-ventas/api/"

const HttpService = {
    async registrar(datos, ruta){
        const respuesta = await fetch(RUTA_GLOBAL + ruta, {
            method: "post",
            body: JSON.stringify(datos),
        });
        let resultado = await respuesta.json()
        return resultado
    },

    async obtenerConDatos(datos, ruta){
        const respuesta = await fetch(RUTA_GLOBAL + ruta, {
            method: "post",
            body: JSON.stringify(datos),
        });
        let resultado = await respuesta.json()
        return resultado
    },


    async obtener(ruta){
        let respuesta = await fetch(RUTA_GLOBAL + ruta)
        let datos = await respuesta.json()
        return datos
    },

    async get(ruta) {
        let respuesta = await fetch(RUTA_GLOBAL + ruta);
        let datos = await respuesta.json();
        return datos;
    },   
    
    async post(ruta, data) {
        const respuesta = await fetch(RUTA_GLOBAL + ruta, {
          method: 'POST',
          body: data,
        });
        let resultado = await respuesta.json();
        return resultado;
    },

    async eliminar(ruta, id) {
        const respuesta = await fetch(RUTA_GLOBAL + ruta, {
            method: "post",
            body: JSON.stringify(id),
        });
        let resultado = await respuesta.json()
        return resultado
    }

}

export default  HttpService;
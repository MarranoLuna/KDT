import Swal from 'sweetalert2';

add_buttons_events_start();

async function add_buttons_events_start() {
    add_buttons_event("see_docs_button", see_docs_function);
    //add_buttons_event("see_vehicles_button", see_vehicles_function);
    add_buttons_event("validate_button", validate_courier);
    add_buttons_event("unvalidate_button", reject_courier);
}

async function see_docs_function(dataset) {
    console.log("Función ver documentos");
    const datos = JSON.parse(dataset.docs);
    try {
        const url_dorso = await getDniImageAsUrl(datos.dni_dorso_path.slice(11)); /// si es null no va a poder
        const url_frente = await getDniImageAsUrl(datos.dni_frente_path.slice(11));

        const result = await Swal.fire({
            allowOutsideClick: false,
            title: "Documentación de " + datos.user.firstname + " " + datos.user.lastname,
            html: `<span class="detalles">DNI: ${datos.dni}</span><br>
                <img src="${url_dorso}" alt="avatar" class="dni_img"><br>
                <img src="${url_frente}" alt="DNI Frente" class="dni_img">
            `,
            confirmButtonColor: "orange",
            confirmButtonText: "Aceptar",
            didOpen: () => {
                //función para abrir las imagenes en otra pestaña.
                const imagenes = document.querySelectorAll(".dni_img");
                imagenes.forEach(img => {
                    img.addEventListener('click', event => {
                        window.open(img.src, '_blank');
                    });
                });
            }
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            html: "No se encontraron las imágenes del DNI del cadete",
            timer: 1500,
            showConfirmButton: false
        })
        console.log(error);
    }

}



function add_buttons_event(class_name, event_function) {
    const buttons_list = document.querySelectorAll("." + class_name);
    if (buttons_list.length > 0) {
        buttons_list.forEach(button => {
            button.addEventListener('click', async event => {
                const dataset = button.dataset;
                button.disabled = true;
                await event_function(dataset);
                button.disabled = false;
            });
        });
    }
}


async function see_vehicles_function(dataset) {
    console.log("Función ver Vehículos");
    console.log(dataset)
    ///const datos = JSON.parse(dataset.docs);
    //// obtener link de imagenes del vehículos y mostrarlas
    /// falta el enviar las imagenes del vehículo
}

async function validate_courier(dataset) {
    console.log("Función de VALIDAR CADETE");
    console.log(dataset)
    const datos = await JSON.parse(dataset.courier);
    console.log(datos.user)
    const result = await Swal.fire({
        title: "Habilitar cadete",
        html: datos.user.firstname + " " + datos.user.lastname + " podrá ofertar solicitudes de clientes y completar pedidos",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "orange",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    });
    if (result.isConfirmed) {
        try {
            const response = await fetch(`api/courier/validate`, {
                method: 'post',
                credentials: 'include',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    id: datos.id
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || "Error desconocido");
            } else {
                ///Agregar: enviar notificación a usuario que está habilitado
                const data = await response.json();
                console.log("respuesta", data);

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message,
                    timer: 1000,
                    willClose:()=>{
                        location.reload();
                    }
                });
            }

        } catch (error) {

            console.error("Error al habilitar cadete:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message,
                timer: 1000
            });
        }
    } else {
        console.log("CANCELADO");
    }

}

async function reject_courier(dataset) {
    console.log("Función de RECHAZAR CADETE");
    console.log(dataset)
    ///const datos = JSON.parse(dataset.docs);
    
    const datos = await JSON.parse(dataset.courier);
    const result = await Swal.fire({
        title: "Rechazar cadete",
        html: datos.user.firstname + " " + datos.user.lastname + " Deberá enviar registrarse nuevamente como cadete",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "orange",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    });
    if (result.isConfirmed) {
        try {
            const response = await fetch(`api/courier/reject`, {
                method: 'post',
                credentials: 'include',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    id: datos.id
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || "Error desconocido");
            } else {
                ///Agregar: enviar notificación a usuario que fue rechazado
                const data = await response.json();
                console.log("respuesta", data);

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message,
                    timer: 1000,
                    showConfirmButton:false,
                    willClose:()=>{
                        location.reload();
                    }
                });
            }

        } catch (error) {

            console.error("Error al rechazar cadete:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message,
                showConfirmButton:false,
                timer: 1000
            });
        }
    } else {
        console.log("CANCELADO");
    }
}

async function getDniImageAsUrl(fileName) {
    const response = await fetch(`api/dni/${fileName}`, { method: 'GET', credentials: 'include' });
    const blob = await response.blob();
    const url = URL.createObjectURL(blob);
    return url;
}
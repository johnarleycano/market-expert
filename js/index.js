activarOpciones = (activar) => {
    $(`#${activar}`).addClass('active')
}

cargarInterfaz = (vista = 'index', contenedor = 'contenedor_principal', datos = null, tipo = null) => {
    $(`#${contenedor}`).load(`${$("#site_url").val()}interfaces`, {tipo: tipo, vista: vista, datos: datos}, (respuesta, estado, xhr) => {
        if(estado == 'error') console.error(xhr)
        // if(estado == 'success') console.log('exito')

        if(datos) {
            // Título de la página
            if(datos.titulo) $(document).attr('title', datos.titulo)

            // Encabezado de la interfaz
            if(datos.titulo) $('#titulo_modulo').text(datos.titulo)
            if(datos.subtitulo) $('#subtitulo_modulo').text(datos.subtitulo)
            if(datos.descripcion) $('#descripcion_modulo').text(datos.descripcion)
        } 
    })
}

cargarMasDatos = (vista, contenedor = 'datos') => {
    // Se aumenta el contador
    localStorage.pesv_contador = (localStorage.pesv_contador)
    ? parseInt(localStorage.pesv_contador) + parseInt($('#cantidad_datos').val())
    : 0

    let datos = {
        vista: vista,
        contador: parseInt(localStorage.pesv_contador),
        busqueda: $("#buscar").val(),
    }

    switch (vista) {
        case 'a/b':
            datos.id_a = $('#id_a').val()
        break
    }

    $.ajax({
        url: `${$('#site_url').val()}interfaces/cargar_mas_datos`,
        data: {datos: datos},
        type: "POST",
        beforeSend: () => $('#cargando').show()
    })
    .done(data => {
        $(`#${contenedor}`).append(data)

        $('#cargando').hide()
    })
    .fail((jqXHR, ajaxOptions, thrownError) => console.error('El servidor no responde.'))
}

cerrarModal = () => $('.modal').modal('hide')

confirmar = (tipo, mensaje) => {
    let respuesta = Swal.fire({
        text: mensaje,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: `Si, ${tipo}`,
        cancelButtonText: 'Cancelar'

    }).then((resultado) => {
        return resultado.isConfirmed
    })

    return respuesta
}

consulta = (tipo, datos, notificacion = true) => {
    let accion = tipo.split('/')[1]
    let respuesta = promesa(`${$('#site_url').val()}${tipo}`, datos)
        .then(resultado => {
            switch (accion) {
                case "actualizar":
                    if (notificacion) mostrarNotificacion('exito', 'Se actualizaron los datos')
                    return resultado
                break

                case "crear":
                    if (notificacion) mostrarNotificacion('exito', 'Se almacenaron los datos')
                    return resultado
                break

                case "eliminar":
                    if (notificacion) mostrarNotificacion('exito', 'Se eliminaron los datos')
                    return resultado
                break

                case "obtener":
                    return resultado
                break

                default:
                    return resultado
                break
            }

        }).catch(error => console.error(error))

    return respuesta
}

convertirFecha = (fecha, hora = false) => {
    let anio = fecha.getFullYear()
    let mes = ('0' + (fecha.getMonth() + 1)).slice(-2)
    let dia = ('0' + fecha.getDate()).slice(-2)
    let nuevaHora = fecha.toLocaleString('es-CO', {
        hour: '2-digit',
        minute: '2-digit'
    })  

    if (hora) return`${anio}-${mes}-${dia} ${nuevaHora}`
    return `${anio}-${mes}-${dia}`
}

generarReporte = (tipo, datos) => {
    switch (tipo) {
        case 'x/x':
            location.assign(`${$('#base_url').val()}reportes/${tipo}/${fechaInicial}/${fechaFinal}/${busqueda}`)
        break;
    }
}

mostrarNotificacion = (tipo, mensaje, tiempo = 2000) => {
    switch (tipo) {
        case 'exito':
            titulo = 'Éxito'
            icono = 'success'
        break;

        case 'error':
            titulo = 'Error'
            icono = 'error'
        break;

        case 'alerta':
            titulo = 'Alerta'
            icono = 'warning'
        break;

        case 'info':
            titulo = 'Información'
            icono = 'info'
        break;

        case 'pregunta':
            titulo = 'Pregunta'
            icono = 'question'
        break;
    }

    Swal.fire({
        confirmButtonText: 'Aceptar',
        icon: icono,
        // position: 'top-end',
        text: mensaje,
        timer: tiempo,
        title: titulo,
        confirmButtonColor: '#3085d6'
    })
}

const promesa = (url, opciones) => {
    return new Promise((resolve, reject) => {
        // Datos a enviar
        var datos = new FormData()
        datos.append('datos', JSON.stringify(opciones))

        // Creación de solicitud http
        const xhttp = new XMLHttpRequest()
        xhttp.open(`POST`, url, true)

        // Cuando cambie el estado
        xhttp.onreadystatechange = (() => {
            if(xhttp.readyState === 4) {
                // Si el estado es exitoso
                (xhttp.status === 200)
                    ? resolve(JSON.parse(xhttp.responseText)) // Envía el string del peso
                    : reject(new Error('Error', url)) // Envía el error
            }
        })

        // Se envía la solicitud
        xhttp.send(datos)
    })
}

validarCamposObligatorios = campos => {
    let validacionesExitosas = campos.length
    let exito = true

    //Recorrido para validar cada campo
    for (var i = 0; i < campos.length; i++){
        // Se remueve la validación a todos los campos
        $(`.invalid-feedback`).remove()
        campos[i].removeClass(`is-invalid`)

        // Si el campo está vacío
        if($.trim(campos[i].val()) == "") {
            // Se resta el campo al total de validaciones exitosas
            validacionesExitosas--

            // Se marcan los campos en rojo con un mensaje
            campos[i].addClass(`is-invalid`)
            //campos[i].after(`<div class="invalid-feedback">Este campo no puede estar vacío</div>`)
        }
    }

    // Si los exitosos son todos
    if(validacionesExitosas != campos.length) {
        mostrarNotificacion('alerta', 'Hay campos obligatorios por diligenciar')

        // No es exitoso
        exito = false
    }

    return exito
}
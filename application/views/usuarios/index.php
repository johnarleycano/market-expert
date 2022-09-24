<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <div>
            <div class="btn-wrapper">
                <a href="#" class="btn btn-success text-white me-0" onClick="javascript:cargarInterfaz('usuarios/detalle', 'contenedor_modal', null, 'modal')">
                    <i class="icon-plus"></i> Crear
                </a>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <input type="text" class="form-control" id="buscar" placeholder="Buscar">
    </div>
</div>

<div id="contenedor_usuarios" class="contenedor_registros"></div>

<script type="text/javascript">
    guardarUsuario = async() => {
        let usuarioId = $('#usuario_id').val()
        password = "0";

        let camposObligatorios = [
            $('#nombres'),
            $('#apellidos'),
            $('#documento'),
            $('#email'),
            $('#login'),
            $('#estado')
        ]

        // Si digitaron algo en la clave 1
        if ($.trim($('#clave1').val()).length > 0 || $.trim($('#clave2').val()).length > 0) {
            // Si las claves no coinciden
            if ($('#clave1').val() !== $('#clave2').val()) {
                mostrarNotificacion('alerta', 'No se puede crear el usuario todavía, Las claves no coinciden. Verifíquelas nuevamente.', 10000)
                
                return false
            }
            
            password = $('#clave1').val()
        }

        if (!validarCamposObligatorios(camposObligatorios)) return false

        let datos = {
            tipo: 'usuarios',
            nombres: $('#nombres').val(),
            apellidos: $('#apellidos').val(),
            documento_numero: $('#documento').val(),
            email: $('#email').val(),
            login: $('#login').val(),
            clave: password,
            activo: $('#estado').val()
        }

        if(!usuarioId) {
            await consulta('crear', datos)
        } else {
            datos.id = usuarioId
            await consulta('actualizar', datos)
        }

        cerrarModal()
        listarUsuarios()
    }

    listarUsuarios = () => {
        if($('#buscar').val() == "" && localStorage.marketExperts_buscarUsuario) $('#buscar').val(localStorage.marketExperts_buscarUsuario)

        localStorage.marketExperts_contador = 0

        let datos = {
            contador: localStorage.marketExperts_contador,
            busqueda: $('#buscar').val(),
            titulo: 'Usuarios',
            subtitulo: 'Gestión',
            descripcion: 'Gestión de usuarios',
        }

        cargarInterfaz('usuarios/listar', 'contenedor_usuarios', datos)
    }

    $().ready(() => {
        listarUsuarios()

        $('#buscar').keyup(() => {
            localStorage.marketExperts_buscarUsuario = $('#buscar').val()

            listarUsuarios()
        })

    })
</script>

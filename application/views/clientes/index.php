<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <!-- <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" onClick="javascript:listarVehiculos('usuario')">
                <a class="nav-link ps-0" id="usuario" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">
                    Mis vehículos
                </a>
            </li>

            <?php // if(verificar_roles($jwt, [Roles::VER_TODOS_LOS_VEHICULOS])) { ?>
                <li class="nav-item" onClick="javascript:listarVehiculos('todos')">
                    <a class="nav-link" id="todos" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">
                        Todos
                    </a>
                </li>
            <?php // } ?>
        </ul> -->

        <div>
            <div class="btn-wrapper">
                <!-- Si es administrador -->
                <?php if($this->session->userdata('administrador') == '1') { ?>
                    <a href="#" class="btn btn-success text-white me-0" onClick="javascript:cargarInterfaz('clientes/detalle', 'contenedor_modal', null, 'modal')">
                        <i class="icon-plus"></i> Crear
                    </a>

                    <a href="#" class="btn btn-success text-white me-0" onClick="javascript:cargarInterfaz('clientes/adicional', 'contenedor_modal', null, 'modal')">
                        <i class="mdi mdi-repeat"></i> Clasificación masiva
                    </a>
                <?php } ?>

                <?php 
                // if (verificar_roles($jwt, [Roles::ADMINISTRADOR])) {
                //     echo "
                //         <button type='button' class='btn btn-success text-white dropdown-toggle me-0' id='reportes_vehiculos' data-bs-toggle='dropdown'>
                //             <i class='ti-export'></i> Exportar
                //         </button>

                //         <div class='dropdown-menu' aria-labelledby='reportes_vehiculos'>
                //             <a class='dropdown-item puntero' onClick='javascript:generarReporte(`excel/vehiculos`)'><i class='mdi mdi-file-excel verde_excel'></i> Vehículos</a>
                //         </div>
                //     ";
                // }
                ?>
            </div>
        </div>
        <!-- Clasificaciones -->
        <div id="cont_clasificaciones" class="col-lg-3 col-md-4 col-sm-13">
            <div class="form-group">
                <select id="clasificacion_filtro" class="form-control" style="width: 100%;">
                    <option value="">Todas las clasificaciones</option>
                                
                    <?php foreach ($this->configuracion_model->obtener('clientes_bitacora_clasificaciones') as $clasificacion) { ?>
                        <option value="<?php echo $clasificacion->id; ?>"><?php echo $clasificacion->nombre; ?></option>
                    <?php } ?>  
                </select>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <input type="text" class="form-control" id="buscar" placeholder="Buscar">
    </div>
</div>

<div id="contenedor_clientes" class="contenedor_registros"></div>

<script type="text/javascript">
    guardarCliente = async() => {
        let clienteId = $('#cliente_id').val()

        let camposObligatorios = [
            $('#nombres'),
            $('#pais'),
            $('#telefono'),
            $('#email')
        ]

        if (!validarCamposObligatorios(camposObligatorios)) return false
        
        let datos = {
            tipo: 'clientes',
            nombres: $('#nombres').val(),
            pais_id: $('#pais').val(),
            telefono: $('#telefono').val(),
            email: $('#email').val(),
        }

        if($('#usuario_asignado')) datos.usuario_asignado_id = $('#usuario_asignado').val()

        if(!clienteId) {
            await consulta('crear', datos)
        } else {
            datos.id = clienteId
            await consulta('actualizar', datos)
        }

        cerrarModal()
        listarClientes()
    }

    listarClientes = () => {
        if($('#buscar').val() == "" && localStorage.marketExperts_buscarCliente) $('#buscar').val(localStorage.marketExperts_buscarCliente)

        // Si tiene una clasificación seleccionada, se pone
        if(localStorage.filtro_clasificaciones) $("#clasificacion_filtro").val(localStorage.filtro_clasificaciones)

        localStorage.marketExperts_contador = 0

        let datos = {
            contador: localStorage.marketExperts_contador,
            busqueda: $('#buscar').val(),
            id_clasificacion: localStorage.filtro_clasificaciones,
            titulo: 'Clientes',
            subtitulo: 'Gestión',
            descripcion: 'Gestión de clientes',
        }

        cargarInterfaz('clientes/listar', 'contenedor_clientes', datos)
    }

    $().ready(() => {
        listarClientes()

        $('#buscar').keyup(() => {
            localStorage.marketExperts_buscarCliente = $('#buscar').val()

            listarClientes()
        })

        $("#clasificacion_filtro").change(() => {
            if($("#clasificacion_filtro").val() != '') {
                localStorage.filtro_clasificaciones = $("#clasificacion_filtro").val()
            } else {
                localStorage.removeItem('filtro_clasificaciones')
            }

            listarClientes()
        })
    })
</script>
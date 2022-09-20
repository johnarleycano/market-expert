<?php $cliente = $this->clientes_model->obtener('clientes', ['id' => $datos['cliente_id']]); ?>

<div class="home-tab">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link puntero" id="profile-tab" data-bs-toggle="tab" role="tab" aria-selected="false" onClick="javascript:cargarInterfaz('clientes/index')">
                    <i class="mdi mdi-arrow-left"></i> Atrás
                </a>
            </li>
        </ul>

        <div>
            <div class="btn-wrapper">
                <a href="#" class="btn btn-success text-white me-0" onClick="javascript:cargarInterfaz('clientes/bitacora/detalle', 'contenedor_modal', null, 'modal')">
                    <i class="icon-plus"></i> Crear
                </a>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <input type="text" class="form-control" id="buscar" placeholder="Buscar">
    </div>
</div>

<div id="contenedor_bitacora" class="contenedor_registros"></div>

<script type="text/javascript">
    guardarBitacora = async() => {
        let camposObligatorios = [
            $('#clasificacion'),
        ]

        if (!validarCamposObligatorios(camposObligatorios)) return false
        
        let datos = {
            tipo: 'clientes_bitacora',
            cliente_id: <?php echo $datos['cliente_id']; ?>,
            descripcion: $('#descripcion').val(),
            cliente_bitacora_clasificacion_id: $('#clasificacion').val(),
        }

        await consulta('crear', datos)

        cerrarModal()
        listarBitacora()
    }

    listarBitacora = () => {
        if($('#buscar').val() == "" && localStorage.marketExperts_buscarBitacora) $('#buscar').val(localStorage.marketExperts_buscarBitacora)

        localStorage.marketExperts_contador = 0

        let datos = {
            contador: localStorage.marketExperts_contador,
            busqueda: $('#buscar').val(),
            titulo: '<?php echo $cliente->nombres; ?>',
            subtitulo: 'Bitácora',
            descripcion: 'Registros en bitácora del cliente',
            cliente_id: <?php echo $cliente->id; ?>
        }

        cargarInterfaz('clientes/bitacora/listar', 'contenedor_bitacora', datos)
    }

    $().ready(() => {
        listarBitacora()

        $('#buscar').keyup(() => {
            localStorage.marketExperts_buscarBitacora = $('#buscar').val()

            listarBitacora()
        })
    })
</script>
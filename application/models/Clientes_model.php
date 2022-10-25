<?php
Class Clientes_model extends CI_Model{
    function actualizar($tabla, $id, $datos){
        switch ($tabla) {
            case 'asignar_usuarios_clientes':
                return $this->db->update_batch('clientes', $datos, $id);
            break;

            default:
                return $this->db->where('id', $id)->update($tabla, $datos);
            break;
        }
    }

    function crear($tipo, $datos){
        switch ($tipo) {
            case 'clientes':
                $this->db->insert($tipo, $datos);
                return $this->db->insert_id();
            break;

            case 'clientes_bitacora':
                $this->db->insert($tipo, $datos);
                return $this->db->insert_id();
            break;

            case 'clientes_bitacoras_clasificaciones':
                return $this->db->insert_batch('clientes_bitacora', $datos);
            break;
        }
    }

    function obtener($tipo, $datos = null)
	{
        switch($tipo) {
            case 'cliente_bitacora':
                $contador = (isset($datos['contador'])) ? "LIMIT {$datos['contador']}, 20" : '' ;
                $filtros_where = "WHERE cb.cliente_id = {$datos['cliente_id']} ";
                $filtros_having = "";

                if (isset($datos['busqueda'])) {
                    $palabras = explode(' ', trim($datos['busqueda']));

                    $filtros_having .= "HAVING";

                    for ($i=0; $i < count($palabras); $i++) {
                        $filtros_having .= " (";
                        $filtros_having .= " cb.id LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR cb.descripcion LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= ") ";

                        if(($i + 1) < count($palabras)) $filtros_having .= " AND ";
                    }
                }

                if(isset($datos['id'])) $filtros_where .= " AND cb.id = {$datos['id']} ";

                $sql = 
                "SELECT
                    cb.id,
                    cb.fecha_creacion,
                    cb.descripcion,
                    CONCAT(u.nombres, ' ', u.apellidos) usuario,
                    cbc.nombre clasificacion
                FROM
                    clientes_bitacora AS cb
                    INNER JOIN clientes AS c ON cb.cliente_id = c.id
                    INNER JOIN usuarios AS u ON cb.usuario_id = u.id
                    LEFT JOIN clientes_bitacora_clasificaciones AS cbc ON cb.cliente_bitacora_clasificacion_id = cbc.id
                $filtros_where
                $filtros_having
                ORDER BY
                    fecha_creacion DESC
                $contador
                ";

                if (isset($datos['id'])) {
                    return $this->db->query($sql)->row();
                } else {
                    return $this->db->query($sql)->result();
                }
            break;

            case 'clientes':
                $contador = (isset($datos['contador'])) ? "LIMIT {$datos['contador']}, 20" : '' ;
                $filtros_where = "WHERE c.id";
                $filtros_having = "HAVING c.id";

                if (isset($datos['busqueda'])) {
                    $palabras = explode(' ', trim($datos['busqueda']));

                    $filtros_having .= " AND ";

                    for ($i=0; $i < count($palabras); $i++) {
                        $filtros_having .= " (";
                        $filtros_having .= " c.nombres LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR c.email LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR pais LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR c.telefono LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR ultima_clasificacion LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR descripcion_ultima_clasificacion LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= ") ";

                        if(($i + 1) < count($palabras)) $filtros_having .= " AND ";
                    }
                }

                if(isset($datos['id'])) $filtros_where .= " AND c.id = {$datos['id']} ";
                if(isset($datos["id_clasificacion"])) $filtros_having .= " AND id_ultima_clasificacion = '{$datos["id_clasificacion"]}' ";

                // Si no es administrador, podrá ver los clientes asignados al sistema y a él mismo
                if($this->session->userdata('administrador') == '0') $filtros_where .= " AND (c.usuario_asignado_id = 1 OR c.usuario_asignado_id = {$this->session->userdata('usuario_id')})";

                $sql = 
                "SELECT
                    c.*,
                    p.nombre AS pais,
                    (SELECT COUNT(id) FROM clientes_bitacora WHERE cliente_id = c.id) bitacoras,
                    (
                        SELECT cbc.nombre
                        FROM clientes_bitacora AS cb
                        INNER JOIN clientes_bitacora_clasificaciones AS cbc ON cb.cliente_bitacora_clasificacion_id = cbc.id
	                    WHERE cb.cliente_id = c.id
	                    ORDER BY cb.fecha_creacion DESC
                        LIMIT 0, 1
	                ) ultima_clasificacion,
                    (
                        SELECT cbc.id
                        FROM clientes_bitacora AS cb
                        INNER JOIN clientes_bitacora_clasificaciones AS cbc ON cb.cliente_bitacora_clasificacion_id = cbc.id
                        WHERE cb.cliente_id = c.id
                        ORDER BY cb.fecha_creacion DESC
                        LIMIT 0, 1
                    ) id_ultima_clasificacion,
                    (
                        SELECT cb.descripcion
                        FROM clientes_bitacora AS cb
                        INNER JOIN clientes_bitacora_clasificaciones AS cbc ON cb.cliente_bitacora_clasificacion_id = cbc.id
                        WHERE cb.cliente_id = c.id
                        ORDER BY cb.fecha_creacion DESC
                        LIMIT 0, 1
                    ) descripcion_ultima_clasificacion,
                    (
                    SELECT
                        cb.fecha_creacion 
                    FROM
                        clientes_bitacora AS cb
                        INNER JOIN clientes_bitacora_clasificaciones AS cbc ON cb.cliente_bitacora_clasificacion_id = cbc.id 
                    WHERE
                        cb.cliente_id = c.id 
                    ORDER BY
                        cb.fecha_creacion DESC 
                        LIMIT 0,
                        1 
                    ) fecha_ultima_clasificacion,
                    CONCAT_WS(' ',ua.nombres, ua.apellidos) usuario_asignado
                FROM clientes AS c
                    INNER JOIN paises AS p ON c.pais_id = p.id
                    LEFT JOIN usuarios AS ua ON c.usuario_asignado_id = ua.id
                $filtros_where
                $filtros_having
                ORDER BY
                    fecha_ultima_clasificacion,
                    c.nombres
                $contador
                ";

                if (isset($datos['id'])) {
                    return $this->db->query($sql)->row();
                } else {
                    return $this->db->query($sql)->result();
                }
            break;
        }
    }
}
/* Fin del archivo Clientes_model.php */
/* Ubicación: ./application/models/Clientes_model.php */
<?php
Class Clientes_model extends CI_Model{
    function actualizar($tabla, $id, $datos){
        return $this->db->where('id', $id)->update($tabla, $datos);
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
                    cb.descripcion
                FROM
                    clientes_bitacora AS cb
                    INNER JOIN clientes AS c ON cb.cliente_id = c.id 
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
                $filtros_having = "";

                if (isset($datos['busqueda'])) {
                    $palabras = explode(' ', trim($datos['busqueda']));

                    $filtros_having .= "HAVING";

                    for ($i=0; $i < count($palabras); $i++) {
                        $filtros_having .= " (";
                        $filtros_having .= " c.nombres LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR c.email LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR pais LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR c.telefono LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= ") ";

                        if(($i + 1) < count($palabras)) $filtros_having .= " AND ";
                    }
                }

                if(isset($datos['id'])) $filtros_where .= " AND c.id = {$datos['id']} ";

                $sql = 
                "SELECT
                c.*,
                p.nombre AS pais,
                (SELECT COUNT(id) FROM clientes_bitacora WHERE cliente_id = c.id) bitacoras
                FROM
                    clientes AS c
                INNER JOIN paises AS p ON c.pais_id = p.id
                $filtros_where
                $filtros_having
                ORDER BY
                    nombres
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
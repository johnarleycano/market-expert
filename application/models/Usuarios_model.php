<?php
Class Usuarios_model extends CI_Model{
    function actualizar($tabla, $id, $datos){
        return $this->db->where('id', $id)->update($tabla, $datos);
    }
    
    function crear($tipo, $datos){
        switch ($tipo) {
            case 'usuarios':
                $this->db->insert($tipo, $datos);
                return $this->db->insert_id();
            break;
        }
    }

    function obtener($tipo, $datos = null)
    {
        switch($tipo) {
            case 'usuarios':
                $contador = (isset($datos['contador'])) ? "LIMIT {$datos['contador']}, 20" : '' ;
                $filtros_where = "WHERE u.id";
                $filtros_having = "";

                if (isset($datos['busqueda'])) {
                    $palabras = explode(' ', trim($datos['busqueda']));

                    $filtros_having .= "HAVING";

                    for ($i=0; $i < count($palabras); $i++) {
                        $filtros_having .= " (";
                        $filtros_having .= " u.nombres LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR u.apellidos LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= " OR u.email LIKE '%{$palabras[$i]}%'";
                        $filtros_having .= ") ";

                        if(($i + 1) < count($palabras)) $filtros_having .= " AND ";
                    }
                }

                if(isset($datos['id'])) $filtros_where .= " AND u.id = {$datos['id']} ";

                $sql = 
                "SELECT
                u.*
                FROM
                    usuarios AS u
                $filtros_where
                $filtros_having
                ORDER BY
                    nombres ASC
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
/* Fin del archivo Usuarios_model.php */
/* Ubicación: ./application/models/Usuarios_model.php */


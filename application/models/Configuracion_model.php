<?php
Class Configuracion_model extends CI_Model{
    function obtener($tipo, $datos = null)
	{
        switch($tipo) {
            case 'clientes_bitacora_clasificaciones':
                return $this->db
                    ->order_by('nombre')
                    ->get($tipo)
                    ->result()
                ;
            break;

            case 'paises':
                return $this->db
                    ->get($tipo)
                    ->result()
                ;
            break;

            case 'usuario':
                return $this->db
                    ->where($datos)
                    ->get('usuarios')
                    ->row()
                ;
            break;
        }
    }
}
/* Fin del archivo Configuracion_model.php */
/* Ubicación: ./application/models/Configuracion_model.php */
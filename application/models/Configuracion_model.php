<?php
Class Configuracion_model extends CI_Model{
    function obtener($tipo, $datos = null)
	{
        switch($tipo) {
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
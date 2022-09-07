<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * @author:     John Arley Cano
 * Fecha:       22 de marzo de 2022
 * Programa:    Market Experts | MY Controller
 * Email:       johnarleycano@hotmail.com
 */
class MY_Controller extends CI_Controller {
    function gestionar_clave($tipo, $nombre_usuario, $clave)
    {
        // Se toma la cadena original
        $cadena = $nombre_usuario.$clave;
                
        // Método de encriptación
        $metodo = "AES-128-CTR";
        
        // Uso del método de encriptación OpenSSl
        $tamanio_iv = openssl_cipher_iv_length($metodo);
        $opciones = 0;

        // Almacenar la clave de encriptación
        $clave_encriptacion = $nombre_usuario;

        // Inicialización del vector para el encriptado
        $encriptacion_iv = 'a1b2c3d4e5f6g7h8';
        
        // Usar función openssl_encrypt() para encriptar el string
        $encriptado = openssl_encrypt($cadena, $metodo, $clave_encriptacion, $opciones, $encriptacion_iv);
        
        // Vector de inicialización "Non-NULL" para desencriptación
        $desencriptacion_iv = 'a1b2c3d4e5f6g7h8';
        
        // Usar función openssl_decrypt() para desencriptar el string
        $desencriptado = openssl_decrypt ($encriptado, $metodo, $clave_encriptacion, $opciones, $desencriptacion_iv);

        // Se retorna el resultado
        if($tipo == 'encriptacion') return $encriptado;
        if($tipo == 'desencriptacion') return $desencriptado;
    }

    function detectar_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
        return $_SERVER['REMOTE_ADDR'];
    }

    function verificar_permisos()
    {
        return $this->configuracion_model->obtener('permisos');
    }
}
/* Fin del archivo MY_Controller.php */
/* Ubicación: ./application/controllers/MY_Controller.php */
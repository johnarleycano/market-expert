<?php
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('El acceso directo a este archivo no está permitido');

/**
 * Verifica los roles del token
 * El token debe contener al menos uno de los roles requeridos
 * 
 * @param array $decrypt_jwt [Token desencriptado]
 * @param array $roles_requeridos [Lista de roles requeridos]
 */
function verificar_roles(array $decrypt_jwt, array $roles_requeridos){
    $cliente_id = get_instance()->config->item('keycloak')['clientId'];

    if (isset($decrypt_jwt["resource_access"][$cliente_id]["roles"])){
        $token_roles = $decrypt_jwt["resource_access"][$cliente_id]["roles"];
        $interseccion = array_intersect($roles_requeridos, $token_roles);

        return count($interseccion) > 0;
    }
    return false;
}
?>
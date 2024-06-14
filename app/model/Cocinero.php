<?php

class Cocinero extends Usuario {
    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct2($nombre, $clave) {
        $NOMBRE_TIPO_USUARIO = "Cocinero";
        parent::__construct($nombre, $clave, $NOMBRE_TIPO_USUARIO);
    }    
}
<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

session_start();

require_once('controller/UsuarioController.php');
require_once('view/TwigView.php');
require_once('view/Home.php');
require_once('view/IniciarSesionUsuario.php');

if(isset($_GET["action"]) && $_GET["action"] == 'iniciarsesionusuario'){
     UsuarioController::getInstance()->iniciarsesionusuario();
     
}
else if(isset($_GET["action"]) && $_GET["action"] == 'verificarDatosUsuario'){
     UsuarioController::getInstance()->verificarDatosUsuario();
}

else{
	if(!isset($_SESSION['usuario']))
		UsuarioController::getInstance()->home(null);
    else
	    UsuarioController::getInstance()->home($_SESSION['usuario']);
}




<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

session_start();

require_once('controller/UsuarioController.php');
require_once('view/TwigView.php');
require_once('view/Home.php');
require_once('view/IniciarSesion.php');

if(isset($_GET["action"]) && $_GET["action"] == 'iniciarsesionusuario'){
     Controller::getInstance()->vistaIniciarSesion();
     
}
else if(isset($_GET["action"]) && $_GET["action"] == 'verificarDatosUsuario'){
     UsuarioController::getInstance()->verificarDatos();
}
else if(isset($_GET["action"]) && $_GET["action"] == 'cerrarSesion'){
     Controller::getInstance()->cerrarSesion();
}     
else{
	if(!isset($_SESSION['usuario']))
		Controller::getInstance()->vistaHome(null);
    else
	    Controller::getInstance()->vistaHome($_SESSION['usuario']);
}




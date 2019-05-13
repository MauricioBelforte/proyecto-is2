<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

session_start();

require_once('controller/UsuarioController.php');
require_once('controller/ResidenciaController.php');
require_once('controller/AdministradorController.php');
require_once('view/TwigView.php');
require_once('view/Home.php');
require_once('view/IniciarSesion.php');
require_once('view/Exito.php');
require_once('view/Semana.php');
require_once('view/CargarResidencia.php');
require_once('view/MostrarResidencia.php');
require_once('model/PDORepository.php');
require_once('model/PDOResidencia.php');
require_once('model/PDOSubasta.php');
require_once('model/Subasta.php');
require_once('model/PDOResidenciaSemana.php');
require_once('model/ResidenciaSemana.php');
require_once('model/Residencia.php');

if(isset($_GET["action"]) && $_GET["action"] == 'iniciarsesion'){
     Controller::getInstance()->vistaIniciarSesion(null);   
}
else if(isset($_GET["action"]) && $_GET["action"] == 'verificarDatosUsuario'){
     UsuarioController::getInstance()->verificarDatos();
}
else if(isset($_GET["action"]) && $_GET["action"] == 'verificarDatosAdministrador'){
     AdministradorController::getInstance()->verificarDatos();
}
else if(isset($_GET["action"]) && $_GET["action"] == 'cerrarSesion'){
     Controller::getInstance()->cerrarSesion();
}
else if(isset($_GET["action"]) && $_GET["action"] == 'cargarResidencia'){
     ResidenciaController::getInstance()->cargarResidencia(null);
}
else if(isset($_GET["action"]) && $_GET["action"] == 'verificarDatosResidencia'){
     ResidenciaController::getInstance()->verificarDatosResidencia();
}
else if(isset($_GET["action"]) && $_GET["action"] == 'mostrarResidencia' && !empty($_GET['id'])){
     ResidenciaController::getInstance()->mostrarResidencia($_GET['id']);
}
else if(isset($_GET["action"]) && $_GET["action"] == 'verSemana' && !empty($_POST['idRS'])){
     ResidenciaController::getInstance()->verSemana($_POST['idRS']);
}
else if(isset($_GET["action"]) && $_GET["action"] == 'pujarSubasta' && !empty($_GET['idSubasta'])){
     ResidenciaController::getInstance()->verificarDatosPuja($_GET['idSubasta'],$_POST['puja']);
}            
else{
	if(!isset($_SESSION['usuario']))
		Controller::getInstance()->vistaHome(null);
    else
	    Controller::getInstance()->vistaHome(array('user' => $_SESSION['usuario'], 'tipousuario' => $_SESSION['tipo']));
}




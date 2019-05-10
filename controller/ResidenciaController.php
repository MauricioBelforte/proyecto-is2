<?php

require_once('controller/Controller.php');

class ResidenciaController extends Controller {

	private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function cargarResidencia($datos){
    	$view = new CargarResidencia();
    	$view->show(array('user' => $_SESSION['usuario'], 'datos' => $datos));


    }

    public function verificarDatosResidencia(){

        if(empty($_POST['titulo']) || empty($_POST['idProvincia']) || empty($_POST['idPartido']) || empty($_POST['idLocalidad']) || empty($_POST['direccion'] ) ||  empty($_POST['descripcion'])){
            $this->cargarResidencia(array('mensaje' => "Ups hubo un error. Intente de nuevo y llene TODOS los campos"));
            return false;
        }
        PDOResidencia::getInstance()->insertarResidencia();
        $this->vistaExito(array('mensaje' =>"¡¡¡La residencia fue cargada exitosamente!!!", 'user' => $_SESSION['usuario']));


        return true;

    }

    public function mostrarResidencia($idResidencia){
        $view= new MostrarResidencia();
        if(!isset($_SESSION['usuario']) ||  empty($_SESSION['usuario']))
           $view->show(array('user' => null,'residencia' => PDOResidencia::getInstance()->traerResidencia($idResidencia), 'residenciasemanasubastas'=> PDOResidenciaSemana::getInstance()->traerResidenciaSemanasSubastas($idResidencia)));

        else

           $view->show(array('user' => $_SESSION['usuario'], 'residencia' => PDOResidencia::getInstance()->traerResidencia($idResidencia), 'residenciasemanasubastas'=> PDOResidenciaSemana::getInstance()->traerResidenciaSemanasSubastas($idResidencia)));
    }




}
    
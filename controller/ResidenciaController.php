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
        if(empty($_SESSION['usuario']) && empty($_SESSION['tipo'])){

            return false;


        }
        if($_SESSION['tipo'] == "administrador"){
    	     $view = new CargarResidencia();
    	     $view->show(array('user' => $_SESSION['usuario'], 'datos' => $datos));
        }

    }

    public function verificarDatosResidencia(){

        if(!isset($_SESSION['tipo']) ||  $_SESSION['tipo'] != "administrador" ){

            // mensaje de error (no tiene autorizacion)
            return false;


        }

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
           $view->show(array('user' => null,'tipousuario' => null,'residencia' => PDOResidencia::getInstance()->traerResidencia($idResidencia), 'residenciasemanasubastas'=> PDOResidenciaSemana::getInstance()->traerResidenciaSemanasSubastas($idResidencia)));

        else

           $view->show(array('user' => $_SESSION['usuario'],'tipousuario' => $_SESSION['tipo'], 'residencia' => PDOResidencia::getInstance()->traerResidencia($idResidencia), 'residenciasemanasubastas'=> PDOResidenciaSemana::getInstance()->traerResidenciaSemanasSubastas($idResidencia)));
    }

    public function vistaSemana($datos){

        $view = new Semana();
        $view->show($datos);

    }


    public function verSemana($idRS){
        //idRS = identificador de residencia semana... Esto es solo para las subastas
        $subasta = PDOSubasta::getInstance()->subastaInfo($idRS);
        if(empty($subasta) ||  empty($_SESSION['usuario'])){
            //No inicio sesion o no hay subastas (ERROR);
            return false;
        }

         //indexo la subasta (recordar que me manda un arreglo y siempre va a ser un solo elemento)

         $datos= array('user' => $_SESSION['usuario'],'tipousuario' => $_SESSION['tipo'],'base' => $subasta[0]->getBase(),'idSubasta' => $subasta[0]->getIdSubasta(), 'puja' => PDOSubasta::getInstance()->pujaMaximaSubasta($subasta[0]->getIdSubasta()));

         $this->vistaSemana($datos);

     }


     public function verificarDatosPuja($idSubasta, $puja){
        //falta mandar vista de errores y de exito
        if (PDOSubasta::getInstance()->esMayorPuja($idSubasta, $puja)) {

    PDOSubasta::getInstance()->insertarParticipanteSubasta($_SESSION['id'], $idSubasta, $puja);
            return true;
        }

       return false;
      
     }




}
    
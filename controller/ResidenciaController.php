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

    public function procesarAltaResidencia(){

      if ($this->verificarDatosResidencia()){
          $this->altaResidencia();
          return true;
      }

      $this->cargarResidencia(array('mensaje' => "Ups hubo un error. Intente de nuevo y llene TODOS los campos"));
      return false;

    }

    public function verificarDatosResidencia(){

        if(!isset($_SESSION['tipo']) ||  $_SESSION['tipo'] != "administrador" ){
            // mensaje de error (no tiene autorizacion)
            return false;

        }
        if(empty($_POST['titulo']) || empty($_POST['idProvincia']) || empty($_POST['idPartido']) || empty($_POST['idLocalidad']) || empty($_POST['direccion'] ) ||  empty($_POST['descripcion'])){
           
            return false;
        }

        return true;

    }


    public function altaResidencia(){
      // Inserta la residencia
       PDOResidencia::getInstance()->insertarResidencia();
        $this->vistaExito(array('mensaje' =>"¡¡¡La residencia fue cargada exitosamente!!!", 'user' => $_SESSION['usuario']));
        return true;
       
    }

    public function mostrarResidencia($datos){
        $view= new MostrarResidencia();
        if(!isset($_SESSION['usuario']) ||  empty($_SESSION['usuario']))
           $view->show(array('user' => null,'tipousuario' => null,'residencia' => PDOResidencia::getInstance()->traerResidencia($datos['id']), 'residenciasemanasubastas'=> PDOResidenciaSemana::getInstance()->traerResidenciaSemanasSubastas($datos['id'])));

        else
          //PDOResidenciaSemana::getInstance()->traerResidenciaSemanasSubastas($datos['id']),'datos' => $datos)
        $view->show(array('user' => $_SESSION['usuario'],'tipousuario' => $_SESSION['tipo'], 'residencia' => PDOResidencia::getInstance()->traerResidencia($datos['id']), 'residenciasemanasubastas' => AuctionsController::getInstance()->listadoSubastasHabilitadas($datos['id']),'datos' => $datos ));
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

         if(PDOSubasta::getInstance()->idUsuarioPujaMaximaSubasta($subasta[0]->getIdSubasta()) == $_SESSION['id'])
             $datos['boton']=false;
         else
            $datos['boton']=true;


         $this->vistaSemana($datos);

     }


     public function verificarDatosPuja($idSubasta, $puja){
        //falta mandar vista de errores y de exito

        $creditos=1; // esto existe por que no se hacen consultas de primera movida (despues se saca)
        if($_SESSION['tipo'] == "administrador"){
               $this->vistaExito(array('mensaje' =>"No tiene permisos para hacer esta accion", 'user' => $_SESSION['usuario']));
               return false;

        }
        if (PDOSubasta::getInstance()->esMayorPuja($idSubasta, $puja) && $creditos > 0) {

          PDOSubasta::getInstance()->insertarParticipanteSubasta($_SESSION['id'], $idSubasta, $puja);
          $this->vistaExito(array('mensaje' =>"¡¡¡La Puja fue registrada!!!", 'user' => $_SESSION['usuario']));
            return true;
        }
        if($creditos == 0){

          $this->vistaExito(array('mensaje' =>"Creditos Insuficientes", 'user' => $_SESSION['usuario']));
        
        }
       return false;
      
     }

   public function editarResidencia($idResidencia){
       // se puede editar una residencia si NO hay partipantes en las semanas correspondiente a la misma
    if(!PDOResidencia::getInstance()->existenParticipantes($idResidencia)){
       $residencia= PDOResidencia::getInstance()->traerResidencia($idResidencia);
       $view= new CargarResidencia();
       $view->editarResidencia(array('user' => $_SESSION['usuario'],'datos' => $residencia[0]));
       return true;
     }

     $this->vistaExito(array('mensaje' =>"No puede editarse.Ya existen Participantes", 'user' => $_SESSION['usuario']));
     return false;

   }

   public function procesarEdicionResidencia($idResidencia){

    if ($this->verificarDatosResidencia()){
         PDOResidencia::getInstance()->actualizarResidencia($idResidencia);
         $this->mostrarResidencia(array('id' => $idResidencia, 'mensaje' => 'La residencia fue actualizada con exito', 'exito' => true));
         return true;
    }

    $this->mostrarResidencia(array('id' => $idResidencia, 'mensaje' => 'La publicacion no fue editada', 'exito' => false));
      return false;

   }


   public function cancelarEdicion($idResidencia){

      $this->mostrarResidencia(array('id' => $idResidencia, 'mensaje' => '¡¡Edicion Cancelada!!', 'exito' => true));
       return true;
   }



   public function eliminarResidencia($idResidencia){
     
      if(empty($_SESSION['usuario']) && empty($_SESSION['tipo'])){

            $this->vistaExito(array('mensaje' =>"No tiene permisos para hacer esta accion", 'user' => $_SESSION['usuario']));
               return false;
        }

      else{
    
   //     if($_SESSION['tipo'] == "administrador"){
           if (!PDOResidencia::getInstance()->existenParticipantes($idResidencia)){      

              PDOResidencia::getInstance()->borrarResidencia($idResidencia);

              $this->vistaExito(array('mensaje' =>"La residencia se elimino satisfactoriamente", 'user' => $_SESSION['usuario']));  
               }

           else{
              $this->vistaExito(array('mensaje' =>"La Residencia no pudo ser eliminada, debido a que se encuentra reservada ", 'user' => $_SESSION['usuario']));
               return false;
               }
           }
     }

        


}
    
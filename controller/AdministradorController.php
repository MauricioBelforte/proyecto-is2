<?php
require_once('controller/Controller.php');

class AdministradorController extends Controller {

	private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    private function verificar_datos(){

         if(empty($_POST['username']) || empty($_POST['password'])){
              $this->vistaIniciarSesion(array('mensaje' => "Hay Campos Vacios"));
             return false;
        }

        if($_POST['username'] == "usuario" && $_POST['password'] == 1234){
             $this->alta_sesion($_POST['username'], 1); // el id es ficticio para esta entrega
             $this->vistaHome($_POST['username']);
        }else{           
             $this->vistaIniciarSesion(array('mensaje' => "Email o contraseña incorrecta"));
             return false;
        }


    }


   public function verificarDatos(){
        $this->verificar_datos();
   }



}
<?php
require_once('controller/Controller.php');

class UsuarioController extends Controller {
    
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

         if(empty($_POST['email']) || empty($_POST['password'])){
            //falta agregar aviso a la vista de campos vacios
             $this->vistaIniciarSesion();
             return false;
        }

        if($_POST['email'] == "guille@guille.com" && $_POST['password'] == 1234){
             $this->alta_sesion($_POST['email'], 1); // el id es ficticio para esta entrega
             $this->vistaHome($_POST['email']);
        }else{           

        //falta agregar aviso a la vista de datos incorrectos
             $this->vistaIniciarSesion();
             return false;
        }


    }


   public function verificarDatos(){
        $this->verificar_datos();
   }


}

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
             $this->vistaIniciarSesion(array('mensaje' => "Hay Campos Vacios"));
             return false;
        }

        if($_POST['email'] == "usuario@usuario.com" && $_POST['password'] == 1234){

             $this->alta_sesion($_POST['email'], 1, "usuario"); // el id es ficticio para esta entrega
             $datos= array('user' => $_POST['email'], 'tipousuario'=> $_SESSION['tipo']);
             $this->vistaHome($datos);
        }else{           
             $this->vistaIniciarSesion(array('mensaje' => "Usuario o contraseña incorrecta"));
             return false;
        }


    }


   public function verificarDatos(){
        $this->verificar_datos();
   }


}

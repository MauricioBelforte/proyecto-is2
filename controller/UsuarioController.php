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

        if($_POST['email'] == "admin@admin.com" && $_POST['password'] == 1234){
             $this->alta_sesion($_POST['email'], 1); // el id es ficticio para esta entrega
             $this->vistaHome($_POST['email']);
        }else{           
             $this->vistaIniciarSesion(array('mensaje' => "Usuario o contraseña incorrecta"));
             return false;
        }


    }


   public function verificarDatos(){
        $this->verificar_datos();
   }

  public function userLogin(){
    // TODO: Validaciones del lado del servidor

    if($_POST['email-input-login'] == "user@user.com" && $_POST['password-input-login'] == 1234){
      $this->alta_sesion($_POST['email-input-login'], 1); // el id es ficticio para esta entrega
      $this->vistaUserPanel($_POST['email-input-login']);
    }else{
      $this->vistaIniciarSesion(array('mensaje' => "Email o contraseña incorrecta"));
      return false;
    }
  }

  public function vistaUserPanel($user){
    $view = new UserPanel();
    $listaresidencia=PDOResidencia::getInstance()->listarTodas();
    if(empty($user))
      $view->show(array('user' => null,'listaresidencia'=> $listaresidencia));
    else
      $view->show(array('user' => $user,'listaresidencia'=> $listaresidencia));
  }


}

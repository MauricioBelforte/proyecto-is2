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

        if($_POST['username'] == "admin" && $_POST['password'] == 1234){
             $this->alta_sesion($_POST['username'], 1, "administrador"); // el id es ficticio para esta entrega
            $datos= array('user' => $_POST['username'], 'tipousuario' => $_SESSION['tipo'] );
             $this->vistaHome($datos);
        }else{           
             $this->vistaIniciarSesion(array('mensaje' => "Email o contraseña incorrecta"));
             return false;
        }


    }


   public function verificarDatos(){
        $this->verificar_datos();
   }

   public function adminLogin(){
     // TODO: Validaciones del lado del servidor

     if($_POST['username-input-admin'] == "admin" && $_POST['password-input-admin'] == 1234){
       $this->alta_sesion($_POST['username-input-admin'], 1, "administrador"); // el id es ficticio para esta entrega
       $this->vistaAdminPanel($_POST['username-input-admin']);
     }else{
       $this->vistaIniciarSesion(array('mensaje' => "Email o contraseña incorrecta"));
       return false;
     }
   }


  public function vistaAdminPanel($user){
    $view = new AdminPanel();
    $listaresidencia=PDOResidencia::getInstance()->listarTodas();
    if(empty($user))
      $view->show(array('user' => null,'listaresidencia'=> $listaresidencia));
    else
      $view->show(array('user' => $user,'listaresidencia'=> $listaresidencia));
  }


}
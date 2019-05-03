<?php

class UsuarioController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function home($user){
        $view = new Home();
        if(empty($user))
           $view->show(array('user' => null));
        else
           $view->show(array('user' => $user));
        
    }

    
    public function iniciarsesionusuario(){

        $view = new IniciarSesionUsuario();
        $view->show();
    }

     public function alta_sesion($usuario,$id){
        if(!isset($_SESSION)){
            session_start();
         }else{
             session_destroy();
             session_start(); 
         }
        $_SESSION['id'] = $id;
        $_SESSION['usuario']= $usuario;

    }

    public function verificarDatosUsuario(){

         if(empty($_POST['email']) || empty($_POST['password'])){
            //falta agregar aviso a la vista de campos vacios
            $view = new IniciarSesionUsuario();
            $view->show();
            return false;
        }

        if($_POST['email'] == "guille@guille.com" && $_POST['password'] == 1234){
             self::getInstance()->alta_sesion($_POST['email'], 1); // el id es ficticio para esta entrega
            $view = new Home();
            $view->show(array('user' => $_POST['email']));
        }else{
           //falta agregar aviso a la vista de datos incorrectos
            $view = new IniciarSesionUsuario();
            $view->show();
            return false;
        }


    }
}

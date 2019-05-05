<?php

 class Controller {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    

    public function vistaHome($user){
        $view = new Home();
        $listaresidencia=PDOResidencia::getInstance()->listarTodas();
        if(empty($user))
           $view->show(array('user' => null,'listaresidencia'=> $listaresidencia));
        else
           $view->show(array('user' => $user,'listaresidencia'=> $listaresidencia));   
    }

    public function vistaIniciarSesion($datos){

        $view = new IniciarSesion();
         if(empty($datos))
           $view->show(array('mensaje' => null));
        else
           $view->show($datos);  
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

    public function cerrarSesion(){
        session_destroy();
        $this->vistaHome(null);
    }

    public function verificarDatos(){}




}
    
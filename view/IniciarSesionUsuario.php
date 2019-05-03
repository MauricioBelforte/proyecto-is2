<?php


class IniciarSesionUsuario extends TwigView {
    
    public function show() {
        
        echo self::getTwig()->render('iniciarsesionusuario.html');
        
        
    }
    
}

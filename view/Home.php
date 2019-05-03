<?php


class Home extends TwigView {
    
    public function show($datos) {
        
        echo self::getTwig()->render('home.html.twig',$datos);
        
        
    }

    
}

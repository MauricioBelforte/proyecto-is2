<?php

class PDOSubasta extends PDORepository {

	//IMPORTANTE: La clase esta esta armada con cruce de datos entre residencia y semana

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct() {
        
    }

    public function subastasDeResidenciaSemana($idResidencia){
        //trae de una residencia las semanas que tiene pero que esten en la tabla de subasta
         $final_answer = [];
        $residenciaSemana = PDOResidenciaSemana::getInstance()->traerResidenciaSemanas($idResidencia);






    }
}

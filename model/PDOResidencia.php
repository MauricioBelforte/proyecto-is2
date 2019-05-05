<?php

class PDOResidencia extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct() {
        
    }

    public function listarTodas() {
        $answer = $this->queryList("SELECT * FROM residencia",array());
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Residencia ($element["idResidencia"],$element["ciudad"], $element["direccion"],$element["idAdministrador"],$element["nombre"],$element["pais"]);
        }

        return $final_answer;
    }

}
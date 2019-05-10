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
            $final_answer[] = new Residencia ($element["idResidencia"],$element["ciudad"], $element["direccion"],$element["idAdministrador"],$element["titulo"],$element["provincia"],$element["partido"],$element["descripcion"]);
        }

        return $final_answer;
    }

    public function insertarResidencia(){

        $answer = $this->queryList("INSERT INTO residencia (ciudad, direccion, idAdministrador, titulo, provincia, descripcion, partido) VALUES (:ciudad, :direccion, :idAdministrador, :titulo, :provincia, :descripcion , :partido);", array(':ciudad' => $_POST['idLocalidad'], ':direccion' => $_POST['direccion'],':idAdministrador' => 1, ':titulo' => $_POST['titulo'], ':provincia'=> $_POST['idProvincia'], ':descripcion'=> $_POST['descripcion'],':partido'=> $_POST['idPartido']));
    }

        public function traerResidencia($idResidencia) {
        $answer = $this->queryList("SELECT * FROM residencia WHERE idResidencia=:idResidencia",array(':idResidencia' => $idResidencia));
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Residencia ($element["idResidencia"],$element["ciudad"], $element["direccion"],$element["idAdministrador"],$element["titulo"],$element["provincia"],$element["partido"],$element["descripcion"]);
        }

        return $final_answer;
    }


     public function traerResidenciaSemanas($idResidencia) {
         $answer = $this->queryList("SELECT * FROM residencia_semana rs INNER JOIN  semana s ON (rs.idSemana=s.idSemana) WHERE idResidencia=:idResidencia",array(':idResidencia' => $idResidencia));
         $final_answer = [];
                foreach ($answer as &$element) {


                }

        return $final_answer;
    }

}
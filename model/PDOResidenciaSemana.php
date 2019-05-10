<?php

class PDOResidenciaSemana extends PDORepository {

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



     public function traerResidenciaSemanas($idResidencia) {
     	//Para una residencia trae TODAS las semanas que intervengan en la misma
         $answer = $this->queryList("SELECT rs.idResidenciaSemana, rs.idResidencia,rs.idSemana ,s.fecha_inicio , s.fecha_fin, rs.estado FROM residencia_semana rs INNER JOIN  semana s ON (rs.idSemana=s.idSemana) WHERE idResidencia =:idResidencia",array(':idResidencia' => $idResidencia));
         $final_answer = [];

         foreach ($answer as &$element) {
            $final_answer[] = new ResidenciaSemana ($element["idResidenciaSemana"],$element["idResidencia"], $element["idSemana"],$element["fecha_inicio"],$element["fecha_fin"],$element["estado"]);
         }

        return $final_answer;
    }

         public function traerResidenciaSemanasSubastas($idResidencia) {

         	//Para una residencia trae unicamente las semanas que son SUBASTAS

         $answer = $this->queryList("SELECT rs.idResidenciaSemana, rs.idResidencia,rs.idSemana ,s.fecha_inicio , s.fecha_fin, rs.estado FROM residencia_semana rs INNER JOIN  semana s ON (rs.idSemana=s.idSemana) INNER JOIN subasta su ON (su.idResidenciaSemana=rs.idResidenciaSemana)WHERE idResidencia =:idResidencia",array(':idResidencia' => $idResidencia));
         
         $final_answer = [];

         foreach ($answer as &$element) {
            $final_answer[] = new ResidenciaSemana ($element["idResidenciaSemana"],$element["idResidencia"], $element["idSemana"],$element["fecha_inicio"],$element["fecha_fin"],$element["estado"]);
         }

        return $final_answer;
    }


}


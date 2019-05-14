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

    public function subastaInfo($idRS){
        //subasta info activas ( activo =0)
        $answer = $this->queryList("SELECT s.idSubasta, s.idResidenciaSemana, s.base FROM residencia_semana rs INNER JOIN subasta s ON (rs.idResidenciaSemana=s.idResidenciaSemana) WHERE s.idResidenciaSemana = :idResidenciaSemana and rs.estado = 0",array(':idResidenciaSemana' => $idRS));
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Subasta ($element["idSubasta"],$element["idResidenciaSemana"], $element["base"]);
        }

        return $final_answer;

    }


    public function pujaMaximaSubasta($idSubasta){

     $answer = $this->queryList("SELECT max(ps.puja) as puja FROM participa_subasta ps WHERE idSubasta= :idSubasta",array(':idSubasta' => $idSubasta));
     if(!empty($answer))
        return $answer[0]["puja"];
     else
        return 0;

    }

    public function esMayorPuja($idSubasta, $puja){
        $answer = $this->queryList("SELECT * FROM participa_subasta ps WHERE idSubasta= :idSubasta AND ps.puja > :puja",array(':idSubasta' => $idSubasta,':puja' => $puja));

        if (sizeof($answer) > 0) {
            return false;
        }

        return true;
    }
   

     public function insertarParticipanteSubasta($idUsuario, $idSubasta, $puja){
        $this->queryList("INSERT INTO participa_subasta (idSubasta,idUsuario,puja)
VALUES (:idUsuario, :idSubasta, :puja);",array(':idUsuario'=> $idUsuario,':idSubasta' => $idSubasta,':puja' => $puja));


     }



}

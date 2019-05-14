<?php

class Subasta extends PDORepository {
    
    public $idSubasta;
    public $idResidenciaSemana;
    public $base;

    public function __construct($idSubasta,$idResidenciaSemana,$base) {
    	$this->idSubasta = $idSubasta;
    	$this->idResidenciaSemana = $idResidenciaSemana;
    	$this->base = $base;

        
    }

    public function getIdSubasta(){
        return $this->idSubasta;
    }

    public function getIdResidenciaSemana(){
        return $this->idResidenciaSemana;
    }
    public function getBase(){
        return $this->base;
    }

}

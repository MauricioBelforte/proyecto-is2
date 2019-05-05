<?php

class Residencia extends PDORepository {
    
    public $idResidencia;
    public $ciudad;
    public $direccion;
    public $idAdministrador;
    public $nombre;
    public $pais;


    public function __construct($idResidencia,$ciudad,$direccion,$idAdministrador,$nombre,$pais) {
    	$this->idResidencia= $idResidencia;
    	$this->ciudad= $ciudad;
    	$this->direccion= $direccion;
    	$this->idAdministrador= $idAdministrador;
    	$this->nombre= $nombre;
    	$this->pais= $pais;
        
    }

    public function getIdResidencia(){
    	return $this->idResidencia;
    }

    public function getCiudad(){
    	return $this->ciudad;
    }
    public function getDireccion(){
    	return $this->direccion;
    }
    public function getIdAdministrador(){
    	return $this->idAdministrador;
    }
    
    public function getNombre(){
    	return $this->nombre;
    }
    
    public function getPais(){
    	return $this->pais;
    }
    



}